<?php

session_start();
if (!isset($_SESSION['access_token'])) {
    header("Location: /login/discord.php");
    exit;
}

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

/* =========================
   SECURITY: SERVER PERMISSION LOCK
========================= */
function getUserGuilds(): array {
    $token = $_SESSION['access_token'];

    $ctx = stream_context_create([
        "http" => [
            "header" => "Authorization: Bearer $token"
        ]
    ]);

    $json = file_get_contents(
        "https://discord.com/api/users/@me/guilds",
        false,
        $ctx
    );

    return $json ? json_decode($json, true) : [];
}

$userGuilds = getUserGuilds();
$userAdminGuildIds = [];

// ADMINISTRATOR = 0x8
foreach ($userGuilds as $g) {
    if (($g['permissions'] & 0x8) === 0x8) {
        $userAdminGuildIds[] = $g['id'];
    }
}

// Bot-Guilds holen
$botGuildIds = [];
$botJson = @file_get_contents('http://127.0.0.1:5000/servers');

if ($botJson !== false) {
    $botData = json_decode($botJson, true);
    if ($botData && !empty($botData['servers'])) {
        foreach ($botData['servers'] as $s) {
            $botGuildIds[] = $s['id'];
        }
    }
}

// HARD CHECK bei Server-Detail
if ($hasServerId) {

    if (!in_array($serverId, $userAdminGuildIds, true)) {
        http_response_code(403);
        die('Zugriff verweigert – kein Admin auf diesem Server');
    }

    if (!in_array($serverId, $botGuildIds, true)) {
        http_response_code(403);
        die('Zugriff verweigert – Bot ist nicht auf diesem Server');
    }
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
                            <p>Deine Discord-Server, auf denen du Admin bist</p>
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
                    <section class="dashboard-panel" style="margin-top:32px;">
                        <h3>Join Role</h3>
                        <p>Neue Mitglieder erhalten automatisch eine Rolle beim Beitritt.</p>

                        <div style="display:flex;gap:16px;align-items:center;margin-top:16px;">
                            <label class="switch">
                                <input type="checkbox" id="joinRoleToggle">
                                <span class="slider"></span>
                            </label>

                            <select id="joinRoleSelect" disabled>
                                <option>Lade Rollen…</option>
                            </select>
                        </div>

                        <small style="opacity:.7;display:block;margin-top:8px;">
                            Änderungen werden sofort gespeichert.
                        </small>
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

        const grid = document.getElementById('serverGrid');

        fetch('/dashboard/api/servers.php')
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {

                grid.innerHTML = '';

                if (!data.success) {
                    throw new Error(data.error || 'API Fehler');
                }

                if (data.count === 0) {
                    grid.innerHTML = `
                    <div class="servers-empty">
                        <h3>Keine Server</h3>
                        <p>Du bist auf keinem Server Admin, auf dem Astra aktiv ist.</p>
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
                        <button onclick="openServer('${server.id}')">Öffnen</button>
                    </div>
                `;

                    grid.appendChild(card);
                });
            })
            .catch(err => {
                grid.innerHTML = `
                <div class="servers-empty">
                    <h3>Fehler</h3>
                    <p>${err.message}</p>
                </div>`;
            });

        <?php else: ?>

        const header = document.getElementById('serverHeader');
        const stats  = document.getElementById('serverStats');
        const joinToggle = document.getElementById('joinRoleToggle');
        const joinSelect = document.getElementById('joinRoleSelect');
        const serverId = "<?= htmlspecialchars($serverId) ?>";

        fetch(`/dashboard/api/server.php?id=${serverId}`)
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {

                if (!data.success) {
                    throw new Error(data.error || 'API Fehler');
                }

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
                <div class="server-card"><span>Mitglieder</span><strong>${s.memberCount}</strong></div>
                <div class="server-card"><span>Channels</span><strong>${s.channelCount}</strong></div>
                <div class="server-card"><span>Rollen</span><strong>${s.roleCount}</strong></div>
                <div class="server-card"><span>Status</span><strong style="color:var(--accent-primary)">Online</strong></div>
            `;

                /* ===== JOIN ROLE INIT ===== */
                joinToggle.checked = s.joinRole.enabled;
                joinSelect.disabled = !s.joinRole.enabled;

                joinSelect.innerHTML = '<option value="">Rolle auswählen</option>';

                s.roles.forEach(role => {
                    if (role.name === '@everyone') return;

                    const opt = document.createElement('option');
                    opt.value = role.id;
                    opt.textContent = role.name;

                    if (role.id === s.joinRole.roleId) {
                        opt.selected = true;
                    }

                    joinSelect.appendChild(opt);
                });
            })
            .catch(err => {
                header.innerHTML = `<h1>Fehler</h1><p>${err.message}</p>`;
                stats.innerHTML = '';
            });

        /* ===== EVENTS ===== */
        joinToggle.addEventListener('change', () => {
            joinSelect.disabled = !joinToggle.checked;

            saveJoinRole(
                joinToggle.checked,
                joinToggle.checked ? joinSelect.value : null
            );
        });

        joinSelect.addEventListener('change', () => {
            if (!joinToggle.checked) return;
            saveJoinRole(true, joinSelect.value);
        });

        <?php endif; ?>
    });

    function saveJoinRole(enabled, roleId) {
        fetch('/dashboard/api/joinrole.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                serverId,
                enabled,
                roleId
            })
        });
    }

    function openServer(id) {
        window.location.href = `/dashboard/servers.php?id=${id}`;
    }
</script>


</body>
</html>
