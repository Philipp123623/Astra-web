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

<!-- DASHBOARD WRAPPER -->
<div class="dashboard-wrapper">

    <div class="dashboard">

        <!-- SIDEBAR -->
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

        <!-- CONTENT -->
        <main class="dashboard-content">
            <h1>Overview</h1>
            <p style="opacity:.6">Dashboard Content kommt hier…</p>
        </main>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
