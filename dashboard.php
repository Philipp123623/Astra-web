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
                    <span class="dashboard-status">● Online</span>
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

                    <div class="dashboard-stat">
                        <span>Servers</span>
                        <strong>12</strong>
                    </div>

                    <div class="dashboard-stat">
                        <span>Users</span>
                        <strong>8.420</strong>
                    </div>

                    <div class="dashboard-stat">
                        <span>Uptime</span>
                        <strong>99.9%</strong>
                    </div>

                    <div class="dashboard-stat">
                        <span>Latency</span>
                        <strong>42ms</strong>
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
