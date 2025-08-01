<?php
// --------- .env laden ---------
function loadEnv($path) {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}
$env = loadEnv(__DIR__ . '/.env');

$servername = $env['DB_SERVER'];
$username   = $env['DB_USER'];
$password   = $env['DB_PASS'];
$dbname     = $env['DB_NAME'];

// --------- Stats holen ---------
$conn = @new mysqli($servername, $username, $password, $dbname);

// Daten abrufen und Status prüfen
$mysql_online = ($conn && !$conn->connect_error);

$servercount = $usercount = $commandCount = $channelCount = "-";
if ($mysql_online) {
    $sql = "SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $servercount  = $row['servercount'] ?? "-";
        $usercount    = $row['usercount'] ?? "-";
        $commandCount = $row['commandCount'] ?? "-";
        $channelCount = $row['channelCount'] ?? "-";
    }
    @$conn->close();
}

// --------- Bot-Status prüfen ---------
$bot_online = false;
try {
    $json = @file_get_contents('http://127.0.0.1:5000/status');
    if ($json) {
        $data = json_decode($json, true);
        if ($data && isset($data['online']) && $data['online'] === true) {
            $bot_online = true;
        }
    }
} catch (Exception $e) {}

// --------- Bot-Uptime-Chart-Logging ---------
$historyFile = __DIR__ . '/status_history_bot.txt';
$now = time();
$bot_status_now = $bot_online ? "1" : "0";

$writeEntry = true;
if (file_exists($historyFile)) {
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (count($lines) > 0) {
        $lastLine = $lines[count($lines) - 1];
        list($lastTimestamp, $lastStatus) = explode(':', $lastLine);

        // Schreibe nur, wenn mind. 600 Sekunden vergangen sind oder sich Status geändert hat
        if (($now - intval($lastTimestamp)) < 600 && $bot_status_now === $lastStatus) {
            $writeEntry = false;
        }
    }
}

if ($writeEntry) {
    file_put_contents($historyFile, $now . ':' . $bot_status_now . "\n", FILE_APPEND | LOCK_EX);
}

// --- Hier die History einlesen und in $history speichern ---
$history = [];
if (file_exists($historyFile)) {
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_slice($lines, -72); // letzte 12h (bei 10 min Intervall)
    foreach ($lines as $line) {
        list($ts, $st) = explode(':', $line);
        $history[] = [
            'timestamp' => intval($ts),
            'status' => intval($st)
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Status | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=2.0" />
    <style>
        body, html {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(120deg, #221c50 0%, #2a2463 90%, #33ccd7 200%);
            font-family: 'Montserrat', sans-serif;
            color: #e7f8fc;
            display: flex;
            flex-direction: column;
        }
        .astra-status-main {
            flex: 1;
            min-height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .status-bubbles-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .astra-status-card {
            position: relative;
            z-index: 2;
            max-width: 540px;
            width: 98vw;
            margin: 40px auto;
            padding: 42px 24px 36px 24px;
            border-radius: 36px;
            background: linear-gradient(135deg, #241d50 0%, #2e265a 70%, #3fd6dd 230%);
            box-shadow: 0 8px 44px 0 #21303f2e, 0 2px 20px 0 #65e6ce12;
            text-align: center;
            overflow: hidden;
        }
        .astra-status-card h1 {
            font-size: 2.1rem;
            font-weight: 900;
            color: #65e6ce;
            margin-bottom: 17px;
            text-shadow: 0 1px 18px #251f5b38;
            letter-spacing: 0.03em;
        }
        .status-list {
            margin-bottom: 25px;
        }
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 0 14px 0;
            padding: 0 7px;
            font-size: 1.13rem;
            font-weight: 600;
            border-bottom: 1.2px solid #30437055;
        }
        .status-row:last-child { border: none; }
        .status-label {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-badge {
            display: inline-block;
            min-width: 89px;
            font-weight: bold;
            padding: 8px 0;
            border-radius: 18px;
            font-size: 1.07rem;
            letter-spacing: 0.03em;
            box-shadow: 0 1px 12px 0 #42eaaf22;
            background: #292659;
            color: #d8ffef;
            border: 2px solid #65e6ce38;
            transition: background .15s, color .17s, border .17s;
            position: relative;
        }
        .status-badge.ok {
            background: linear-gradient(93deg,#65e6ce 0%, #54fdbe 110%);
            color: #223254;
            border-color: #60e9cb77;
            box-shadow: 0 0 0 3px #54fdbe11;
            font-weight: 800;
        }
        .status-badge.err {
            background: linear-gradient(93deg, #ff7272 0%, #ffb3b3 110%);
            color: #481d24;
            border-color: #ff727266;
            font-weight: 800;
            box-shadow: 0 0 0 3px #ff72721d;
        }
        .status-badge.warn {
            background: linear-gradient(93deg, #ffe479 0%, #ffbd34 110%);
            color: #553a10;
            border-color: #ffe47966;
            font-weight: 800;
            box-shadow: 0 0 0 3px #ffe4792e;
        }
        .status-icon {
            font-size: 1.19em;
            margin-right: 8px;
        }
        .uptime-chart-title {
            font-size: 1.05rem;
            margin: 25px 0 5px 0;
            color: #90e3e7;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .uptime-bar-row {
            display: flex;
            gap: 2px;
            justify-content: center;
            align-items: end;
            height: 20px;
            margin-bottom: 8px;
        }
        .uptime-bar {
            width: 7px;
            height: 16px;
            border-radius: 4px;
            background: #3a5255;
            opacity: 0.42;
            transition: background .18s, opacity .18s;
            cursor: pointer;
        }
        .uptime-bar.online { background: #65e6ce; opacity: 1; }
        .uptime-bar.offline { background: #ff7272; opacity: .85;}
        .uptime-legend {
            font-size: 0.89rem;
            color: #b1cde3;
            margin-bottom: 4px;
        }
        .stats-box-row {
            display: flex;
            justify-content: space-between;
            gap: 19px;
            margin: 25px 0 0 0;
        }
        .stat-box {
            flex: 1 1 25%;
            background: linear-gradient(127deg, #262364 0%, #23354b 100%);
            border-radius: 16px;
            padding: 13px 4px 12px 4px;
            color: #c5fffd;
            font-size: 1.01rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 13px 0 #3fd6dd0e;
        }
        .stat-head {
            font-size: 0.97rem;
            color: #9cecff;
            margin-bottom: 2px;
        }
        .stat-num {
            font-size: 1.35rem;
            color: #65e6ce;
            font-weight: 800;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
            margin-top: 4px;
        }
        /* --- Tooltip Styles --- */
        #uptime-tooltip {
            position: fixed;
            z-index: 10000;
            pointer-events: none;
        }
        .uptime-tooltip-bubble {
            background: linear-gradient(120deg, #292659 60%, #2e265a 120%);
            color: #d8ffef;
            padding: 10px 18px 11px 15px;
            border-radius: 18px;
            font-size: 0.97rem;
            box-shadow: 0 3px 22px 0 #22325451;
            min-width: 155px;
            max-width: 250px;
            text-align: left;
            position: relative;
            opacity: 0.96;
            font-weight: 500;
            animation: fadeInTT .2s;
        }
        @keyframes fadeInTT { from { opacity: 0; transform: translateY(5px); } to { opacity: .96; transform: none; } }
        .uptime-tooltip-arrow {
            position: absolute;
            bottom: -11px;
            left: 32px;
            width: 24px; height: 18px;
            overflow: hidden;
        }
        .uptime-tooltip-arrow::after {
            content: "";
            position: absolute;
            top: 0; left: 6px;
            width: 12px; height: 12px;
            background: linear-gradient(120deg, #292659 60%, #2e265a 120%);
            transform: rotate(45deg);
            box-shadow: 0 1px 8px #23354b31;
        }
        @media (max-width: 700px) {
            .astra-status-card { padding: 7vw 2vw 7vw 2vw; border-radius: 17px; }
            .astra-status-card h1 { font-size: 1.13rem; }
            .status-row { font-size: 1.02rem; }
            .status-badge { min-width: 65px; font-size: 0.92rem; }
            .stats-box-row { flex-direction: column; gap: 10px;}
            .stat-box { padding: 12px 2px 9px 2px; border-radius: 14px;}
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<main class="astra-status-main">
    <div class="status-bubbles-bg">
        <svg width="100%" height="100%">
            <circle cx="12%" cy="18%" r="43" fill="#65e6ce33"/>
            <circle cx="98%" cy="18%" r="58" fill="#a7c8fd22"/>
            <circle cx="50%" cy="95%" r="32" fill="#7c41ee22"/>
            <circle cx="6%" cy="89%" r="41" fill="#60e9cb22"/>
        </svg>
    </div>
    <section class="astra-status-card">
        <h1>Service Status</h1>
        <div class="status-list">
            <div class="status-row">
                <span class="status-label"><span class="status-icon">🤖</span> Bot</span>
                <span class="status-badge <?php echo $bot_online ? 'ok' : 'err'; ?>">
                    <?php echo $bot_online ? 'Online' : 'Offline'; ?>
                </span>
            </div>
            <div class="status-row">
                <span class="status-label"><span class="status-icon">🗄️</span> MySQL</span>
                <span class="status-badge <?php echo $mysql_online ? 'ok' : 'err'; ?>">
                    <?php echo $mysql_online ? 'Online' : 'Offline'; ?>
                </span>
            </div>
            <!-- Weitere Dienste wie API, Webserver hier hinzufügen -->
        </div>

        <div class="uptime-chart-title">Bot-Uptime Verlauf (letzte 12h)</div>
        <div class="uptime-bar-row" id="uptimeBarRow">
            <?php
            foreach ($history as $idx => $entry) {
                $class = $entry['status'] ? 'online' : 'offline';
                $ts = $entry['timestamp'];
                $statusStr = $entry['status'] ? 'Online' : 'Offline';
                $dateStr = date("d.m. H:i", $ts); // oder "Y-m-d H:i"
                echo '<div class="uptime-bar '.$class.'" data-idx="'.$idx.'" data-status="'.$statusStr.'" data-time="'.$dateStr.'"></div>';
            }
            ?>
        </div>
        <div class="uptime-legend">Grün = Online, Rot = Offline. Jeder Balken = ~10min</div>

        <!-- Tooltip Element (wird von JS gefüllt) -->
        <div id="uptime-tooltip" style="display:none;">
            <div class="uptime-tooltip-bubble">
                <div class="uptime-tooltip-arrow"></div>
                <div class="uptime-tooltip-content"></div>
            </div>
        </div>

        <div class="stats-box-row">
            <div class="stat-box">
                <div class="stat-head">Server</div>
                <div class="stat-num"><?php echo $servercount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">User</div>
                <div class="stat-num"><?php echo $usercount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">Commands</div>
                <div class="stat-num"><?php echo $commandCount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">Channels</div>
                <div class="stat-num"><?php echo $channelCount; ?></div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bars = document.querySelectorAll('.uptime-bar-row .uptime-bar');
        const tooltip = document.getElementById('uptime-tooltip');
        const tooltipContent = tooltip.querySelector('.uptime-tooltip-content');

        // Optional: Statistische Berechnung für Uptime in Prozent bis zum Balken
        function getUptimePercent(idx) {
            let count = 0, online = 0;
            bars.forEach((b, i) => {
                if(i > idx) return;
                count++;
                if(b.classList.contains('online')) online++;
            });
            return count > 0 ? Math.round((online/count)*100) : 0;
        }

        bars.forEach((bar, idx) => {
            bar.addEventListener('mouseenter', function(e) {
                const status = bar.dataset.status;
                const time = bar.dataset.time;
                const upPercent = getUptimePercent(idx);

                tooltipContent.innerHTML = `
                <b>${time}</b><br>
                Status: <span style="font-weight:700;color:${status==='Online' ? '#65e6ce':'#ff7272'}">${status}</span><br>
                Uptime bis hier: <span style="color:#90e3e7">${upPercent}%</span>
            `;
                tooltip.style.display = 'block';

                // Positionierung
                const rect = bar.getBoundingClientRect();
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                tooltip.style.left = (rect.left + rect.width/2 - 70) + 'px';
                tooltip.style.top = (rect.top + scrollY - 56) + 'px';
            });
            bar.addEventListener('mouseleave', function() {
                tooltip.style.display = 'none';
            });
        });

        // Optional: Für mobile Touch
        bars.forEach((bar, idx) => {
            bar.addEventListener('touchstart', function(e) {
                const status = bar.dataset.status;
                const time = bar.dataset.time;
                const upPercent = getUptimePercent(idx);

                tooltipContent.innerHTML = `
                <b>${time}</b><br>
                Status: <span style="font-weight:700;color:${status==='Online' ? '#65e6ce':'#ff7272'}">${status}</span><br>
                Uptime bis hier: <span style="color:#90e3e7">${upPercent}%</span>
            `;
                tooltip.style.display = 'block';

                const rect = bar.getBoundingClientRect();
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                tooltip.style.left = (rect.left + rect.width/2 - 70) + 'px';
                tooltip.style.top = (rect.top + scrollY - 56) + 'px';

                e.preventDefault();
            });
            bar.addEventListener('touchend', function() {
                tooltip.style.display = 'none';
            });
        });
    });
</script>
<script>
    const navToggle = document.querySelector('.astra-nav-toggle');
    if(navToggle){
        navToggle.addEventListener('click', () => {
            document.body.classList.toggle('nav-open');
            const expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', !expanded);
            navToggle.blur();
        });
    }
</script>
</body>
</html>
