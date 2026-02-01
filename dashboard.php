<!DOCTYPE html>
<html lang="de" data-theme="aurora-mint">
<head>
    <meta charset="UTF-8">
    <title>Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Base / Theme -->
    <link rel="stylesheet" href="/assets/css/themes.css">

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="/assets/css/dashboard.css">
</head>

<body>

<div class="dashboard">

    <!-- ========== SIDEBAR ========== -->
    <aside class="dashboard-sidebar">

        <div class="sidebar-logo">
            <span>Astra</span>
        </div>

        <nav class="sidebar-nav">
            <a class="active">Overview</a>
            <a>Servers</a>
            <a>Commands</a>
            <a>Users</a>
            <a>Settings</a>
        </nav>

        <div class="sidebar-footer">
            <span>Status</span>
            <strong class="status-online">Online</strong>
        </div>

    </aside>

    <!-- ========== CONTENT ========== -->
    <main class="dashboard-content">

        <!-- Header -->
        <header class="dashboard-header">
            <h1>Overview</h1>

            <div class="dashboard-actions">
                <button class="btn-secondary">Refresh</button>
                <button class="btn-primary">Invite Bot</button>
            </div>
        </header>

        <!-- Stats -->
        <section class="dashboard-stats">

            <div class="stat-card">
                <span>Servers</span>
                <strong>12</strong>
            </div>

            <div class="stat-card">
                <span>Users</span>
                <strong>8.420</strong>
            </div>

            <div class="stat-card">
                <span>Uptime</span>
                <strong>99.9%</strong>
            </div>

            <div class="stat-card">
                <span>Latency</span>
                <strong>42ms</strong>
            </div>

        </section>

        <!-- Panels -->
        <section class="dashboard-panels">

            <div class="panel">
                <h3>System Status</h3>
                <p>All systems operational. No incidents reported.</p>
            </div>

            <div class="panel">
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

</body>
</html>
