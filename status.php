<?php
// Zeitzone setzen
date_default_timezone_set('Europe/Berlin');

// Funktion zum Laden der .env-Datei
function loadEnv(string $path): array {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        $trim = trim($line);
        if ($trim === '' || $trim[0] === '#' || strpos($trim, '=') === false) continue;
        list($key, $value) = explode('=', $trim, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

$env = loadEnv(__DIR__ . '/.env');

// Datenbank-Verbindung herstellen
$conn = @new mysqli(
    $env['DB_SERVER'] ?? '',
    $env['DB_USER'] ?? '',
    $env['DB_PASS'] ?? '',
    $env['DB_NAME'] ?? ''
);
$mysql_online = ($conn && !$conn->connect_error);

// Statistiken aus der Datenbank laden
$stats = [
    'servercount' => '-',
    'usercount' => '-',
    'commandCount' => '-',
    'channelCount' => '-'
];
if ($mysql_online) {
    $result = $conn->query("SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $stats = $result->fetch_assoc();
    }
    $conn->close();
}

// Bot Status prüfen
$bot_online = false;
try {
    $json = @file_get_contents('http://localhost:5000/status');
    if ($json) {
        $data = json_decode($json, true);
        $bot_online = (json_last_error() === JSON_ERROR_NONE && !empty($data['online']));
    }
} catch (Exception $e) {
    // Fehler ignorieren, $bot_online bleibt false
}

// Status Historie laden (letzte 12h und 30 Tage)
$historyFile = __DIR__ . '/status_history_bot.txt';

$history_12h = [];
if (file_exists($historyFile)) {
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = array_slice($lines, -72); // Letzte 12 Stunden (12*6 = 72 * 10min Intervalle)
    foreach ($lines as $line) {
        if (strpos($line, ':') === false) continue;
        list($ts, $st) = explode(':', $line, 2);
        $history_12h[] = ['timestamp' => (int)$ts, 'status' => (int)$st];
    }
}

$history_30d = [];
if (file_exists($historyFile)) {
    $daily = [];
    $lines = file($historyFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, ':') === false) continue;
        list($ts, $st) = explode(':', $line, 2);
        $tag = date("Y-m-d", (int)$ts);
        if (!isset($daily[$tag])) $daily[$tag] = ['total' => 0, 'online' => 0];
        $daily[$tag]['total']++;
        if ((int)$st === 1) $daily[$tag]['online']++;
    }
    // Nur letzte 30 Tage behalten
    $daily = array_slice($daily, -30, 30, true);
    foreach ($daily as $tag => $data) {
        $percent = ($data['total'] > 0) ? ($data['online'] / $data['total'] * 100) : 0;
        $history_30d[] = [
            'date' => $tag,
            'percent' => $percent,
            'online' => $data['online'],
            'total' => $data['total']
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=2.5" />
</head>
<body class="status-page">

<!-- ASTRA LOADER -->
<div id="astra-loader">
    <div class="astra-loader-bg"></div>

    <!-- Floating bubbles -->
    <div class="astra-loader-bubbles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="astra-loader-core">
        <div class="astra-loader-ring"></div>
        <img src="/public/favicon_transparent.png" class="astra-loader-logo" alt="Astra">
        <span class="astra-loader-text">Booting Astra</span>
    </div>
</div>



<?php include 'includes/header.php'; ?>

<main class="astra-status-main">
    <section class="astra-status-card">

        <h1><?= $t['status_heading'] ?></h1>

        <ul class="status-list">
            <li>
                <span>🤖 <?= $t['status_bot'] ?></span>
                <span class="status-badge <?= $bot_online ? 'ok' : 'err' ?>">
            <?= $bot_online ? $t['online'] : $t['offline'] ?>
        </span>
            </li>
            <li>
                <span>🗄️ MySQL</span>
                <span class="status-badge <?= $mysql_online ? 'ok' : 'err' ?>">
            <?= $mysql_online ? $t['online'] : $t['offline'] ?>
        </span>
            </li>
        </ul>

        <div class="status-tabs-row">
            <button class="status-tab-btn active" onclick="switchTab('detail')"><?= $t['last_12h'] ?></button>
            <button class="status-tab-btn" onclick="switchTab('tage')"><?= $t['last_30d'] ?></button>
        </div>

        <p class="uptime-legend"><?= $t['uptime_legend'] ?></p>

        <div class="stats-box-row">
            <div class="stat-box"><div><?= $t['servers'] ?></div><b><?= $stats['servercount'] ?></b></div>
            <div class="stat-box"><div><?= $t['users'] ?></div><b><?= $stats['usercount'] ?></b></div>
            <div class="stat-box"><div><?= $t['commands'] ?></div><b><?= $stats['commandCount'] ?></b></div>
            <div class="stat-box"><div><?= $t['channels'] ?></div><b><?= $stats['channelCount'] ?></b></div>
        </div>

    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    (function () {

        const loader = document.getElementById('astra-loader');
        const KEY = 'astra_loader_shown';

        // Nur beim ersten Besuch
        if (sessionStorage.getItem(KEY)) {
            loader.remove();
            return;
        }

        sessionStorage.setItem(KEY, 'true');

        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                setTimeout(() => loader.remove(), 500);
            }, 600); // fühlt sich smooth an, nicht künstlich
        });

    })();
</script>


<script>
    // Tab Switch
    function switchTab(tab) {
        document.getElementById('tab-btn-detail').classList.toggle('active', tab === 'detail');
        document.getElementById('tab-btn-tage').classList.toggle('active', tab === 'tage');
        document.getElementById('uptime-detail').style.display = (tab === 'detail') ? 'block' : 'none';
        document.getElementById('uptime-tage').style.display = (tab === 'tage') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const bars12h = document.querySelectorAll('.uptime-bar-row .uptime-bar');
        const bars30d = document.querySelectorAll('.uptime-bar-row-day .uptime-bar-day');
        const tooltip = document.getElementById('uptime-tooltip');
        const tooltipContent = tooltip.querySelector('.uptime-tooltip-content');
        const closeBtn = tooltip.querySelector('.uptime-tooltip-close');
        const arrow = tooltip.querySelector('.uptime-tooltip-arrow');
        let tooltipPermanent = false;

        function getUptimePercent(idx) {
            let count = 0, online = 0;
            bars12h.forEach((b, i) => {
                if (i > idx) return;
                count++;
                if (b.classList.contains('online')) online++;
            });
            return count > 0 ? Math.round((online / count) * 100) : 0;
        }

        function positionTooltip(bar) {
            const rect = bar.getBoundingClientRect();
            const bubble = tooltip.querySelector('.uptime-tooltip-bubble');

            setTimeout(() => {
                const bubbleRect = bubble.getBoundingClientRect();
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                const scrollX = window.scrollX || document.documentElement.scrollLeft;

                let left = rect.left + rect.width / 2 - bubbleRect.width / 2 + scrollX;
                let top = rect.top + scrollY - bubbleRect.height - 10;

                arrow.style.left = (bubbleRect.width / 2 - 6) + "px";
                arrow.style.top = '';
                arrow.style.transform = '';

                if (top < scrollY) {
                    top = rect.bottom + scrollY + 10;
                    arrow.style.top = "-6px";
                    arrow.style.transform = "rotate(180deg)";
                }

                tooltip.style.left = left + "px";
                tooltip.style.top = top + "px";
            }, 1);
        }

        function showTooltipHTML(bar, html, isPermanent = false) {
            tooltipContent.innerHTML = html;
            tooltip.style.display = 'block';
            closeBtn.style.display = (isPermanent || window.innerWidth <= 700) ? "block" : "none";
            tooltipPermanent = isPermanent || window.innerWidth <= 700;
            positionTooltip(bar);
        }

        // Events für 12h Balken
        bars12h.forEach((bar, idx) => {
            bar.addEventListener('mouseenter', () => {
                if (window.innerWidth > 700 && !tooltipPermanent) {
                    const status = bar.dataset.status;
                    const time = bar.dataset.time;
                    const upPercent = getUptimePercent(idx);

                    showTooltipHTML(bar, `
                        <b style="font-size:1.06em;letter-spacing:0.01em;">${time}</b><br>
                        Status: <span style="font-weight:700;color:${status === 'Online' ? '#65e6ce' : '#ff7272'}">${status}</span><br>
                        Uptime bis hier: <span style="color:#90e3e7">${upPercent}%</span>
                    `);
                }
            });
            bar.addEventListener('mouseleave', () => {
                if (window.innerWidth > 700 && !tooltipPermanent) tooltip.style.display = 'none';
            });
            bar.addEventListener('touchstart', (e) => {
                const status = bar.dataset.status;
                const time = bar.dataset.time;
                const upPercent = getUptimePercent(idx);

                showTooltipHTML(bar, `
                    <b style="font-size:1.06em;letter-spacing:0.01em;">${time}</b><br>
                    Status: <span style="font-weight:700;color:${status === 'Online' ? '#65e6ce' : '#ff7272'}">${status}</span><br>
                    Uptime bis hier: <span style="color:#90e3e7">${upPercent}%</span>
                `, true);

                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Events für 30 Tage Balken
        bars30d.forEach((bar) => {
            // Original-Tooltip sichern
            bar.dataset.tooltip = bar.getAttribute('title') || '';
            bar.removeAttribute('title');

            function getTooltipHTML(b) {
                return (b.dataset.tooltip || '').replace(/\n/g, '<br>');
            }

            bar.addEventListener('mouseenter', () => {
                if (window.innerWidth > 700 && !tooltipPermanent) {
                    showTooltipHTML(bar, getTooltipHTML(bar));
                }
            });
            bar.addEventListener('mouseleave', () => {
                if (window.innerWidth > 700 && !tooltipPermanent) tooltip.style.display = 'none';
            });
            bar.addEventListener('touchstart', (e) => {
                showTooltipHTML(bar, getTooltipHTML(bar), true);
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Tooltip schließen
        closeBtn.addEventListener('click', () => {
            tooltip.style.display = 'none';
            tooltipPermanent = false;
        });

        // Klick außerhalb schließt Tooltip
        document.addEventListener('mousedown', e => {
            if (tooltipPermanent && !tooltip.contains(e.target)) {
                tooltip.style.display = 'none';
                tooltipPermanent = false;
            }
        });

        // Initialer Tab
        switchTab('detail');
    });
</script>

<script>
    // Mobile Navigation Toggle
    const navToggle = document.querySelector('.astra-nav-toggle');
    navToggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !expanded);
        navToggle.blur();
    });
</script>

</body>
</html>
