<!DOCTYPE html>
<html lang="de" data-theme="aurora-mint">
<head>
    <meta charset="UTF-8">
    <title>Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=2.4"/>
</head>

<body>
<?php include "includes/header.php"; ?>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="dashboard-sidebar">

        <div class="dashboard-logo">
            Astra<span>Bot</span>
        </div>

        <nav class="dashboard-nav">
            <a class="active">Overview</a>
            <a>Servers</a>
            <a>Commands</a>
            <a>Users</a>
            <a>Settings</a>
        </nav>

        <div class="dashboard-sidebar-footer">
            <span>Status</span>
            <span class="dashboard-status">Online</span>
        </div>

    </aside>

    <!-- CONTENT -->
    <main class="dashboard-content">

        <header class="dashboard-header">
            <h1>Overview</h1>

            <div class="dashboard-actions">
                <button class="dashboard-btn secondary">Refresh</button>
                <button class="dashboard-btn primary">Invite Bot</button>
            </div>
        </header>

        <!-- STATS -->
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

        <!-- PANELS -->
        <section class="dashboard-panels">

            <div class="dashboard-panel">
                <h3>System Status</h3>
                <p>All systems operational. No incidents reported.</p>
            </div>

            <div class="dashboard-panel">
                <h3>Recent Activity</h3>
                <ul>
                    <li>Bot joined new server</li>
                    <li>Commands updated</li>
                    <li>Latency optimized</li>
                </ul>
            </div>

        </section>

    </main>

</div>

<?php include "includes/footer.php"; ?>
</body>
</html>
