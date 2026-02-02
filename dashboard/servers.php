<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';

/* =========================
   MODE DETECTION
========================= */
$hasServerId = false;
$serverId = null;

if (isset($_GET['id'])) {
    if (!preg_match('/^\d+$/', $_GET['id'])) {
        http_response_code(400);
        die('Ungültige Server-ID');
    }
    $hasServerId = true;
    $serverId = $_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?= $hasServerId ? 'Server Details' : 'Servers' ?> | Astra Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=5.1">
</head>

<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"; ?>

<main class="dashboard-page">
    <div class="dashboard-wrapper">
        <div class="dashboard">

            <?php include $_SERVER['DOCUMENT_ROOT'].'/dashboard/includes/dashboard-sidebar.php'; ?>

            <section class="dashboard-content servers-page">

                <?php if (!$hasServerId): ?>
                    <!-- ======================================================
                         SERVER LIST
                    ====================================================== -->

                    <header class="servers-header">
                        <div>
                            <h1>Servers</h1>
                            <p>Alle Discord Server, auf denen Astra aktiv ist</p>
                        </div>
                    </header>

                    <section id="serverGrid" class="servers-grid">
                        <div class="dashboard-panel" id="servers-loading">
                            <h3>Lade Server…</h3>
                            <p>Verbinde mit Astra API…</p>
                        </div>
                    </section>

                <?php else: ?>
                    <!-- ======================================================
                         SERVER DETAIL
                    ====================================================== -->

                    <header class="servers-header" id="serverHeader">
                        <div>
                            <h1>Lade Server…</h1>
                            <p>Verbinde mit Astra API</p>
                        </div>
                    </header>

                    <section class="servers-grid" id="serverStats"></section>

                    <section class="dashboard-panel" style="margin-top:32px;">
                        <h3>Overview</h3>
                        <p>
                            Hier findest du alle Basisinformationen zu diesem Discord-Server.
                            Weitere Funktionen wie Moderation, Logs und Einstellungen folgen.
                        </p>
                    </section>

                <?php endif; ?>

            </section>
        </div>
    </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        <?php if (!$hasServerId): ?>

        /* =========================
           SERVER LIST SCRIPT
        ========================= */
        const grid = document.getElementById('serverGrid');

        fetch('/dashboard/api/servers.php')
            .then(res => res.json())
            .then(data => {

                grid.innerHTML = '';

                if (!data.success) {
                    grid.innerHTML = `
                    <div class="servers-empty">
                        <h3>Fehler</h3>
                        <p>Server konnten nicht geladen werden.</p>
                    </div>`;
                    return;
                }

                if (data.count === 0) {
                    grid.innerHTML = `
                    <div class="servers-empty">
                        <h3>Keine Server</h3>
                        <p>Astra ist aktuell auf keinem Server aktiv.</p>
                    </div>`;
                    return;
                }

                data.servers.forEach(server => {

                    const iconUrl = server.icon
                        ? `https://cdn.discordapp.com/icons/${server.id}/${server.icon}.png`
                        : '/public/server_fallback.png';

                    const card = document.createElement('div');
                    card.className = 'server-card';

                    card.innerHTML = `
                    <div class="server-header">
                        <div class="server-icon">
                            <img src="${iconUrl}" alt="${server.name}">
                        </div>
                        <div>
                            <div class="server-name">${server.name}</div>
                            <div class="server-id">ID: ${server.id}</div>
                        </div>
                    </div>

                    <div class="server-stats">
                        <div class="server-stat">
                            <span>Mitglieder</span>
                            <strong>${server.memberCount}</strong>
                        </div>
                        <div class="server-stat">
                            <span>Status</span>
                            <strong style="color:var(--accent-primary)">Online</strong>
                        </div>
                    </div>

                    <div class="server-actions">
                        <button onclick="openServer('${encodeURIComponent(server.id)}')">
                            Öffnen
                        </button>
                    </div>
                `;

                    grid.appendChild(card);
                });
            })
            .catch(() => {
                grid.innerHTML = `
                <div class="servers-empty">
                    <h3>API nicht erreichbar</h3>
                    <p>Stelle sicher, dass Astra läuft.</p>
                </div>`;
            });

        <?php else: ?>

        /* =========================
           SERVER DETAIL SCRIPT
        ========================= */
        const header = document.getElementById('serverHeader');
        const stats  = document.getElementById('serverStats');
        const serverId = "<?= htmlspecialchars($serverId) ?>";

        fetch(`/dashboard/api/server.php?id=${serverId}`)
            .then(res => res.json())
            .then(data => {

                if (!data.success) throw new Error();

                const s = data.server;
                const iconUrl = s.icon
                    ? `https://cdn.discordapp.com/icons/${s.id}/${s.icon}.png`
                    : '/public/server_fallback.png';

                header.innerHTML = `
                <div style="display:flex;align-items:center;gap:18px;">
                    <div class="server-icon" style="width:64px;height:64px;">
                        <img src="${iconUrl}" alt="${s.name}">
                    </div>
                    <div>
                        <h1>${s.name}</h1>
                        <p>ID: ${s.id}</p>
                    </div>
                </div>
            `;

                stats.innerHTML = `
                <div class="server-card">
                    <div class="server-stat">
                        <span>Mitglieder</span>
                        <strong>${s.memberCount}</strong>
                    </div>
                </div>

                <div class="server-card">
                    <div class="server-stat">
                        <span>Channels</span>
                        <strong>${s.channelCount}</strong>
                    </div>
                </div>

                <div class="server-card">
                    <div class="server-stat">
                        <span>Rollen</span>
                        <strong>${s.roleCount}</strong>
                    </div>
                </div>

                <div class="server-card">
                    <div class="server-stat">
                        <span>Status</span>
                        <strong style="color:var(--accent-primary)">Online</strong>
                    </div>
                </div>
            `;
            })
            .catch(() => {
                header.innerHTML = `
                <h1>Server nicht erreichbar</h1>
                <p>Dieser Server konnte nicht geladen werden.</p>
            `;
                stats.innerHTML = '';
            });

        <?php endif; ?>
    });

    /* =========================
       NAV
    ========================= */
    function openServer(id) {
        window.location.href = `/dashboard/servers.php?id=${id}`;
    }
</script>

</body>
</html>
