<?php
declare(strict_types=1);

session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['access_token'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Not authenticated'
    ]);
    exit;
}

/* =========================
   DISCORD API HELPER
========================= */
function discord_api(string $endpoint): array {
    $ctx = stream_context_create([
        'http' => [
            'header' => "Authorization: Bearer {$_SESSION['access_token']}"
        ]
    ]);

    $res = file_get_contents("https://discord.com/api/$endpoint", false, $ctx);
    return $res ? json_decode($res, true) : [];
}

/* =========================
   USER GUILDS (ADMIN ONLY)
========================= */
$userGuilds = discord_api('users/@me/guilds');

$adminGuildIds = [];

foreach ($userGuilds as $g) {
    if (
        ($g['owner'] ?? false) ||
        ((int)$g['permissions'] & 0x20)
    ) {
        $adminGuildIds[] = $g['id'];
    }
}

/* =========================
   BOT GUILDS
========================= */
$botJson = file_get_contents('http://127.0.0.1:5000/servers');

if ($botJson === false) {
    echo json_encode([
        'success' => false,
        'error' => 'Bot API not reachable'
    ]);
    exit;
}

$botData = json_decode($botJson, true);

if (!$botData['success']) {
    echo json_encode([
        'success' => false,
        'error' => 'Bot API error'
    ]);
    exit;
}

/* =========================
   MATCH BOT + USER
========================= */
$servers = [];

foreach ($botData['servers'] as $server) {
    if (in_array($server['id'], $adminGuildIds, true)) {
        $servers[] = $server;
    }
}

echo json_encode([
    'success' => true,
    'count'   => count($servers),
    'servers' => $servers
]);

