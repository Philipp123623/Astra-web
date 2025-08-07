<?php
date_default_timezone_set('Europe/Berlin');

function loadEnv($path) {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        $trim = trim($line);
        if ($trim === '' || $trim[0] === '#') continue;
        if (strpos($trim, '=') === false) continue;
        list($key, $value) = explode('=', $trim, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}
$env = loadEnv(__DIR__ . '/.env');

$servername = $env['DB_SERVER'] ?? '';
$username   = $env['DB_USER'] ?? '';
$password   = $env['DB_PASS'] ?? '';
$dbname     = $env['DB_NAME'] ?? '';

$conn = @new mysqli($servername, $username, $password, $dbname);
$mysql_online = ($conn && !$conn->connect_error);

$servercount = $usercount = $commandCount = $channelCount = "-";
if ($mysql_online) {
    $sql = "SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1";
    if ($result = $conn->query($sql)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $servercount  = $row['servercount'] ?? "-";
            $usercount    = $row['usercount'] ?? "-";
            $commandCount = $row['commandCount'] ?? "-";
            $channelCount = $row['channelCount'] ?? "-";
        }
        $result->free();
    }
    @$conn->close();
}

$bot_online = false;
try {
    $json = @file_get_contents('http://127.0.0.1:5000/status');
    if ($json) {
        $data = json_decode($json, true);
        if (!empty($data['online'])) {
            $bot_online = true;
        }
    }
} catch (Exception $e) {}

$historyFile = __DIR__ . '/status_history_bot.txt';

// Letzte 12h
$history_12h = [];
if (file_exists($historyFile)) {
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_slice($lines, -72);
    foreach ($lines as $line) {
        if (strpos($line, ':') === false) continue;
        list($ts, $st) = explode(':', $line, 2);
        $history_12h[] = [
            'timestamp' => (int)$ts,
            'status'    => (int)$st
        ];
    }
}

// Letzte 30 Tage
$history_30d = [];
if (file_exists($historyFile)) {
    $daily = [];
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, ':') === false) continue;
        list($ts, $st) = explode(':', $line, 2);
        $tag = date("Y-m-d", (int)$ts);
        if (!isset($daily[$tag])) $daily[$tag] = ['total'=>0, 'online'=>0];
        $daily[$tag]['total']++;
        if ((int)$st === 1) $daily[$tag]['online']++;
    }
    $daily = array_slice($daily, -30, 30, true);
    foreach ($daily as $tag => $data) {
        $percent = ($data['total'] > 0) ? ($data['online'] / $data['total'] * 100) : 0;
        $history_30d[] = [
            'date'    => $tag,
            'percent' => $percent,
            'online'  => $data['online'],
            'total'   => $data['total'],
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
    <link rel="stylesheet" href="/css/style.css?v=2.1" />
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
        </div>

        <div class="status-tabs-row">
            <button class="status-tab-btn active" id="tab-btn-detail" onclick="switchTab('detail')">Letzte 12h</button>
            <button class="status-tab-btn" id="tab-btn-tage" onclick="switchTab('tage')">Letzte 30 Tage</button>
        </div>

        <div class="uptime-chart-title" id="uptime-title-detail">Bot-Uptime Verlauf (letzte 12h)</div>
        <div class="uptime-bar-row" id="uptimeBarRowDetail">
            <?php foreach ($history_12h as $idx => $entry):
                $class = $entry['status'] ? 'online' : 'offline';
                $ts = $entry['timestamp'];
                $statusStr = $entry['status'] ? 'Online' : 'Offline';
                $dateStr = date("d.m. H:i", $ts);
                echo '<div class="uptime-bar '.$class.'" data-idx="'.$idx.'" data-status="'.$statusStr.'" data-time="'.$dateStr.'"></div>';
            endforeach; ?>
        </div>

        <div class="uptime-chart-title" id="uptime-title-tage" style="display:none;">Tages-Uptime (letzte 30 Tage)</div>
        <div class="uptime-bar-row-day" id="uptimeBarRowTage" style="display:none;">
            <?php foreach ($history_30d as $entry):
                $p = $entry['percent'];
                $dateStr = date("d.m.", strtotime($entry['date']));
                if ($p >= 99.95) $class = 'perfect';
                elseif ($p >= 98.0) $class = 'good';
                elseif ($p >= 90.0) $class = 'warn';
                else $class = 'bad';
                $tooltip = "{$dateStr} <br>Uptime: ".round($p,2)."%<br>({$entry['online']}/{$entry['total']})";
                echo '<div class="uptime-bar-day '.$class.'" title="'.$tooltip.'"></div>';
            endforeach; ?>
        </div>

        <div class="uptime-legend">Grün = Online, Rot = Offline. Jeder Balken = 10 Minuten — oder 1 Tag.</div>

        <div id="uptime-tooltip" style="display:none;">
            <div class="uptime-tooltip-bubble">
                <button type="button" class="uptime-tooltip-close" style="display:none;" aria-label="Schließen">&times;</button>
                <div class="uptime-tooltip-content"></div>
                <div class="uptime-tooltip-arrow"></div>
            </div>
        </div>

        <div class="stats-box-row">
            <div class="stat-box"><div class="stat-head">Server</div><div class="stat-num"><?php echo $servercount; ?></div></div>
            <div class="stat-box"><div class="stat-head">User</div><div class="stat-num"><?php echo $usercount; ?></div></div>
            <div class="stat-box"><div class="stat-head">Commands</div><div class="stat-num"><?php echo $commandCount; ?></div></div>
            <div class="stat-box"><div class="stat-head">Channels</div><div class="stat-num"><?php echo $channelCount; ?></div></div>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>

<script>
    // Tab Switch
    function switchTab(tab) {
        document.getElementById('tab-btn-detail').classList.toggle('active', tab==='detail');
        document.getElementById('tab-btn-tage').classList.toggle('active', tab==='tage');
        document.getElementById('uptimeBarRowDetail').style.display = (tab==='detail') ? 'flex':'none';
        document.getElementById('uptime-title-detail').style.display = (tab==='detail') ? 'block':'none';
        document.getElementById('uptimeBarRowTage').style.display = (tab==='tage') ? 'flex':'none';
        document.getElementById('uptime-title-tage').style.display = (tab==='tage') ? 'block':'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bars = document.querySelectorAll('.uptime-bar-row .uptime-bar');
        const tooltip = document.getElementById('uptime-tooltip');
        const tooltipContent = tooltip.querySelector('.uptime-tooltip-content');
        const closeBtn = tooltip.querySelector('.uptime-tooltip-close');
        let tooltipPermanent = false;

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
            tooltip.classList.remove('mobile');

            closeBtn.style.display = (isPermanent || window.innerWidth <= 700) ? "block" : "none";
            tooltipPermanent = isPermanent || window.innerWidth <= 700;

            const rect = bar.getBoundingClientRect();
            const bubble = tooltip.querySelector('.uptime-tooltip-bubble');
            const arrow = tooltip.querySelector('.uptime-tooltip-arrow');

            setTimeout(() => {
                const bubbleRect = bubble.getBoundingClientRect();
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                const scrollX = window.scrollX || document.documentElement.scrollLeft;

                // X mittig über Balken
                let left = rect.left + rect.width / 2 - bubbleRect.width / 2 + scrollX;
                // Standard: oben anzeigen
                let top = rect.top + scrollY - bubbleRect.height - 10;

                // Pfeil zentrieren
                arrow.style.left = (bubbleRect.width / 2 - 6) + "px";
                arrow.style.top = '';
                arrow.style.transform = '';

                // Falls kein Platz oben → unten anzeigen
                if (top < scrollY) {
                    top = rect.bottom + scrollY + 10;
                    arrow.style.top = "-6px";
                    arrow.style.transform = "rotate(180deg)";
                }

                tooltip.style.left = left + "px";
                tooltip.style.top = top + "px";
            }, 1);
        }


        bars.forEach((bar, idx) => {
            bar.addEventListener('mouseenter', () => { if(window.innerWidth > 700 && !tooltipPermanent) showTooltip(bar, idx); });
            bar.addEventListener('mouseleave', () => { if(window.innerWidth > 700 && !tooltipPermanent) tooltip.style.display = 'none'; });
            bar.addEventListener('touchstart', function(e) {
                showTooltip(bar, idx, true);
                e.preventDefault(); e.stopPropagation();
            });
        });

        closeBtn.addEventListener('click', () => {
            tooltip.style.display = 'none';
            tooltipPermanent = false;
        });

        document.addEventListener('mousedown', e => {
            if(tooltipPermanent && !tooltip.contains(e.target)) {
                tooltip.style.display = 'none';
                tooltipPermanent = false;
            }
        });

        switchTab('detail');
    });
</script>
</body>
</html>
