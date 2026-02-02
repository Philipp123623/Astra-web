<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Servers | Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=5.0">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"; ?>

<!-- PAGE MAIN -->
<main class="dashboard-page">

    <div class="dashboard-wrapper">
        <div class="dashboard">

            <!-- SIDEBAR -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/dashboard/includes/dashboard-sidebar.php'; ?>

            <!-- CONTENT -->
            <section class="dashboard-content">

                <!-- HEADER -->
                <header class="dashboard-header">
                    <div>
                        <h1>Servers</h1>
                        <p class="dashboard-subtitle">
                            Alle Discord Server, auf denen Astra aktiv ist
                        </p>
                    </div>
                </header>

                <!-- SERVER GRID -->
                <section id="serverGrid" class="dashboard-server-grid">

                    <!-- Loading State -->
                    <div class="dashboard-panel" id="servers-loading">
                        <h3>Lade Server…</h3>
                        <p>Verbinde mit Astra API…</p>
                    </div>

                </section>

            </section>

        </div>
    </div>

</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>

</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const grid = document.getElementById('serverGrid');

        fetch('http://localhost:5000/servers')
            .then(res => res.json())
            .then(data => {

                grid.innerHTML = '';

                if (!data.success) {
                    grid.innerHTML = `
                    <div class="dashboard-panel">
                        <h3>Fehler</h3>
                        <p>Server konnten nicht geladen werden.</p>
                    </div>
                `;
                    return;
                }

                if (data.count === 0) {
                    grid.innerHTML = `
                    <div class="dashboard-panel">
                        <h3>Keine Server</h3>
                        <p>Astra ist aktuell auf keinem Server aktiv.</p>
                    </div>
                `;
                    return;
                }

                data.servers.forEach(server => {

                    const iconUrl = server.icon
                        ? `https://cdn.discordapp.com/icons/${server.id}/${server.icon}.png`
                        : '/public/server_fallback.png';

                    const card = document.createElement('div');
                    card.className = 'dashboard-server-card';

                    card.innerHTML = `
                    <div class="server-icon">
                        <img src="${iconUrl}" alt="${server.name}">
                    </div>

                    <div class="server-info">
                        <strong>${server.name}</strong>
                        <span>${server.memberCount} Mitglieder</span>
                    </div>

                    <div class="server-actions">
                        <button class="dashboard-btn secondary"
                                onclick="openServer('${server.id}')">
                            Öffnen
                        </button>
                    </div>
                `;

                    grid.appendChild(card);
                });

            })
            .catch(err => {
                console.error(err);
                grid.innerHTML = `
                <div class="dashboard-panel">
                    <h3>API nicht erreichbar</h3>
                    <p>Stelle sicher, dass Astra läuft.</p>
                </div>
            `;
            });

    });

    function openServer(id) {
        window.location.href = `/dashboard/server.php?id=${id}`;
    }
</script>
