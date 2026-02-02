<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';

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

// ENV laden
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

// DB Connect
$conn = @new mysqli(
    $env['DB_SERVER'] ?? '',
    $env['DB_USER'] ?? '',
    $env['DB_PASS'] ?? '',
    $env['DB_NAME'] ?? ''
);

$stats = [
    'servercount' => 0,
    'usercount' => 0,
    'commandCount' => 0,
    'channelCount' => 0
];

if ($conn && !$conn->connect_error) {
    $res = $conn->query("SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1");
    if ($res && $res->num_rows) {
        $stats = $res->fetch_assoc();
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
?>



<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=5.0">
</head>

<body>

<?php include "includes/header.php"; ?>

<!-- PAGE MAIN -->
<main class="dashboard-page">

    <!-- DASHBOARD WRAPPER -->
    <div class="dashboard-wrapper">

        <div class="dashboard">

            <!-- =====================
                 SIDEBAR
            ====================== -->
            <aside class="dashboard-sidebar">

                <div class="dashboard-logo">
                    Astra<span>Bot</span>
                </div>

                <nav class="dashboard-nav">
                    <a class="active" data-icon="📊">Overview</a>
                    <a data-icon="🖥️">Servers</a>
                    <a data-icon="⚙️">Commands</a>
                    <a data-icon="👥">Users</a>
                    <a data-icon="🛠️">Settings</a>
                </nav>

                <div class="dashboard-sidebar-footer">
                    <span>Status</span>
                    <span class="dashboard-status <?= $bot_online ? 'online' : 'offline' ?>">
        ● <?= $bot_online ? 'Online' : 'Offline' ?>
    </span>
                </div>


            </aside>

            <!-- =====================
                 CONTENT
            ====================== -->
            <section class="dashboard-content">

                <!-- HEADER -->
                <header class="dashboard-header">
                    <div>
                        <h1>Overview</h1>
                        <p class="dashboard-subtitle">
                            Überblick über deinen Astra Bot Status
                        </p>
                    </div>

                    <div class="dashboard-actions">
                        <button class="dashboard-btn secondary">Refresh</button>
                        <button class="dashboard-btn primary">Invite Bot</button>
                    </div>
                </header>

                <!-- =====================
                     STATS
                ====================== -->
                <section class="dashboard-stats">

                    <div class="dashboard-stat" data-count="<?= (int)$stats['servercount'] ?>">
                        <span>Servers</span>
                        <strong>0</strong>
                    </div>

                    <div class="dashboard-stat" data-count="<?= (int)$stats['usercount'] ?>">
                        <span>Users</span>
                        <strong>0</strong>
                    </div>

                    <div class="dashboard-stat" data-count="<?= (int)$stats['commandCount'] ?>">
                        <span>Commands</span>
                        <strong>0</strong>
                    </div>

                    <div class="dashboard-stat" data-count="<?= (int)$stats['channelCount'] ?>">
                        <span>Channels</span>
                        <strong>0</strong>
                    </div>

                </section>


                <!-- =====================
                     PANELS
                ====================== -->
                <section class="dashboard-panels">

                    <!-- SYSTEM STATUS -->
                    <div class="dashboard-panel">
                        <h3>System Status</h3>
                        <p>
                            Alle Systeme laufen stabil.<br>
                            Keine bekannten Störungen oder Ausfälle.
                        </p>

                        <ul>
                            <li>🟢 API erreichbar</li>
                            <li>🟢 Commands aktiv</li>
                            <li>🟢 Datenbank verbunden</li>
                        </ul>
                    </div>

                    <!-- RECENT ACTIVITY -->
                    <div class="dashboard-panel">
                        <h3>Recent Activity</h3>

                        <ul>
                            <li>Bot wurde zu neuem Server hinzugefügt</li>
                            <li>Slash Commands aktualisiert</li>
                            <li>Antwortzeiten optimiert</li>
                            <li>Neue Nutzer beigetreten</li>
                        </ul>
                    </div>

                </section>

                <!-- =====================
                     FUTURE PLACEHOLDER
                ====================== -->
                <section class="dashboard-panel" style="margin-top:32px;">
                    <h3>Coming Soon</h3>
                    <p>
                        Hier kommen bald:
                    </p>
                    <ul>
                        <li>📈 Live Statistiken</li>
                        <li>⚙️ Server Konfiguration</li>
                        <li>👥 User Management</li>
                        <li>🔔 Logs & Events</li>
                    </ul>
                </section>

            </section>

        </div>

    </div>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const stats = document.querySelectorAll('.dashboard-stat');

        stats.forEach(stat => {
            const target = parseInt(stat.dataset.count, 10);
            const output = stat.querySelector('strong');

            if (isNaN(target)) return;

            let current = 0;
            const duration = 1200; // ms
            const steps = 60;
            const increment = target / steps;

            const formatter = new Intl.NumberFormat('de-DE');

            const interval = setInterval(() => {
                current += increment;

                if (current >= target) {
                    output.textContent = formatter.format(target);
                    clearInterval(interval);
                } else {
                    output.textContent = formatter.format(Math.floor(current));
                }
            }, duration / steps);
        });

    });
</script>

