<!DOCTYPE html>
<html lang="de">
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

    <!-- ================= SIDEBAR ================= -->
    <aside class="dashboard-sidebar">

        <!-- LOGO -->
        <div class="dashboard-logo">
            <span class="logo-main">Astra</span><span class="logo-accent">Bot</span>
        </div>

        <!-- NAV -->
        <nav class="dashboard-nav">

            <a class="nav-item active">
                <span class="nav-icon">📊</span>
                <span class="nav-text">Overview</span>
            </a>

            <a class="nav-item">
                <span class="nav-icon">🖥️</span>
                <span class="nav-text">Servers</span>
            </a>

            <a class="nav-item">
                <span class="nav-icon">⚙️</span>
                <span class="nav-text">Commands</span>
            </a>

            <a class="nav-item">
                <span class="nav-icon">👥</span>
                <span class="nav-text">Users</span>
            </a>

            <a class="nav-item">
                <span class="nav-icon">🛠️</span>
                <span class="nav-text">Settings</span>
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="dashboard-sidebar-footer">
            <span class="status-label">Status</span>
            <span class="status-online">● Online</span>
        </div>

    </aside>

    <!-- ================= CONTENT ================= -->
    <main class="dashboard-content">
        <h1>Overview</h1>
        <p>Dashboard Content kommt hier…</p>
    </main>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
