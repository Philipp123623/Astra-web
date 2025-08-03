<?php
// --------- ZEITZONE setzen (ganz oben!) ---------
date_default_timezone_set('Europe/Berlin');

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
    $lines = array_slice($lines, -72); // letzte 12h bei 10min Intervall = 72 Einträge
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=2.0" />
</head>
<body class="status-page">
<?php include 'includes/header.php'; ?>

<main class="astra-status-main">
    <section class="astra-status-card">
        <div class="status-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="43" fill="#65e6ce33"/>
                <circle cx="98%" cy="18%" r="58" fill="#a7c8fd22"/>
                <circle cx="50%" cy="95%" r="32" fill="#7c41ee22"/>
                <circle cx="6%" cy="89%" r="41" fill="#60e9cb22"/>
            </svg>
        </div>
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
                $dateStr = date("d.m. H:i", $ts);
                echo '<div class="uptime-bar '.$class.'" data-idx="'.$idx.'" data-status="'.$statusStr.'" data-time="'.$dateStr.'"></div>';
            }
            ?>
        </div>
        <div class="uptime-legend">Grün = Online, Rot = Offline. Jeder Balken = 10 Minuten</div>

        <div id="uptime-tooltip" style="display:none;">
            <div class="uptime-tooltip-bubble">
                <button type="button" class="uptime-tooltip-close" style="display:none;" aria-label="Schließen">&times;</button>
                <div class="uptime-tooltip-content"></div>
                <div class="uptime-tooltip-arrow"></div>
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
        const closeBtn = tooltip.querySelector('.uptime-tooltip-close');
        let tooltipPermanent = false; // Merker ob mobil dauerhaft angezeigt

        function getUptimePercent(idx) {
            let count = 0, online = 0;
            bars.forEach((b, i) => {
                if(i > idx) return;
                count++;
                if(b.classList.contains('online')) online++;
            });
            return count > 0 ? Math.round((online/count)*100) : 0;
        }

        function showTooltip(bar, idx, isPermanent=false) {
            const status = bar.dataset.status;
            const time = bar.dataset.time;
            const upPercent = getUptimePercent(idx);

            tooltipContent.innerHTML = `
            <b style="font-size:1.06em;letter-spacing:0.01em;">${time}</b><br>
            Status: <span style="font-weight:700;color:${status==='Online' ? '#65e6ce':'#ff7272'}">${status}</span><br>
            Uptime bis hier: <span style="color:#90e3e7">${upPercent}%</span>
        `;
            tooltip.style.display = 'block';

            // Show close button only for touch
            if(isPermanent) {
                closeBtn.style.display = "block";
                tooltipPermanent = true;
            } else {
                closeBtn.style.display = "none";
                tooltipPermanent = false;
            }

            // Positioniere die Sprechblase mittig über dem Balken
            const rect = bar.getBoundingClientRect();
            const bubble = tooltip.querySelector('.uptime-tooltip-bubble');
            setTimeout(() => {
                const bubbleRect = bubble.getBoundingClientRect();
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                const scrollX = window.scrollX || document.documentElement.scrollLeft;
                let left = rect.left + rect.width / 2 - bubbleRect.width / 2 + scrollX;
                let top = rect.top + scrollY - bubbleRect.height - 13;
                left = Math.max(7, Math.min(left, window.innerWidth - bubbleRect.width - 7));
                tooltip.style.left = left + "px";
                tooltip.style.top = top + "px";
            }, 1);
        }

        bars.forEach((bar, idx) => {
            // Desktop Hover
            bar.addEventListener('mouseenter', function() {
                if(window.innerWidth > 700 && !tooltipPermanent) showTooltip(bar, idx);
            });
            bar.addEventListener('mouseleave', function() {
                if(window.innerWidth > 700 && !tooltipPermanent) tooltip.style.display = 'none';
            });

            // Mobile Touch
            bar.addEventListener('touchstart', function(e) {
                showTooltip(bar, idx, true); // Permanent anzeigen, Button sichtbar
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Schließen-Button
        closeBtn.addEventListener('click', function(e) {
            tooltip.style.display = 'none';
            tooltipPermanent = false;
            e.stopPropagation();
        });

        // Klick außerhalb des Tooltips (nur bei permanent/Touch)
        document.addEventListener('touchstart', function(e) {
            if(tooltipPermanent && !tooltip.contains(e.target)) {
                tooltip.style.display = 'none';
                tooltipPermanent = false;
            }
        });

        // Klick außerhalb mit Maus (optional)
        document.addEventListener('mousedown', function(e) {
            if(tooltipPermanent && !tooltip.contains(e.target)) {
                tooltip.style.display = 'none';
                tooltipPermanent = false;
            }
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
