<?php
declare(strict_types=1);

/* ==========================================================
   API: SERVER DETAILS
   - liest .env selbst
   - PHP 7+ kompatibel
   - gibt IMMER JSON zurück
========================================================== */

/* =========================
   ERROR HANDLING
========================= */
ini_set('display_errors', '0');
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

/* =========================
   LOAD .ENV (CUSTOM)
========================= */
function loadEnv(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }

    $vars = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || $line[0] === '#') {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $vars[$key] = trim($value, "\"'");
    }

    return $vars;
}

/* =========================
   LOAD CONFIG FROM .ENV
========================= */
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

$dbHost = $env['DB_SERVER'] ?? 'localhost';
$dbUser = $env['DB_USER']   ?? '';
$dbPass = $env['DB_PASS']   ?? '';
$dbName = $env['DB_NAME']   ?? '';

/* =========================
   VALIDATE INPUT
========================= */
if (!isset($_GET['id']) || !preg_match('/^\d+$/', $_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid server ID'
    ]);
    exit;
}

$serverId = (string)$_GET['id'];

/* =========================
   BOT API: SERVER INFO
========================= */
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => "http://127.0.0.1:5000/servers/$serverId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 5,
    CURLOPT_CONNECTTIMEOUT => 2,
]);

$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'error'   => 'Bot API unreachable'
    ]);
    exit;
}

$data = json_decode($response, true);

if (
    json_last_error() !== JSON_ERROR_NONE ||
    !isset($data['success']) ||
    $data['success'] !== true ||
    !isset($data['server'])
) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid bot response'
    ]);
    exit;
}

/* =========================
   DATABASE CONNECT
========================= */
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Database connection failed'
    ]);
    exit;
}

/* =========================
   JOIN ROLE (DB)
========================= */
$joinRole = [
    'enabled' => false,
    'roleId'  => null
];

$stmt = $conn->prepare("
    SELECT roleID
    FROM join_roles
    WHERE guildID = ?
    LIMIT 1
");

$stmt->bind_param('s', $serverId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    $joinRole['enabled'] = true;
    $joinRole['roleId']  = (string)$row['roleID'];
}

$stmt->close();

/* =========================
   ROLES (BOT API)
========================= */
$roles = [];

$rolesJson = @file_get_contents(
    "http://127.0.0.1:5000/servers/$serverId/roles"
);

if ($rolesJson !== false) {
    $rolesData = json_decode($rolesJson, true);

    if (
        json_last_error() === JSON_ERROR_NONE &&
        isset($rolesData['roles']) &&
        is_array($rolesData['roles'])
    ) {
        $roles = $rolesData['roles'];
    }
}

/* =========================
   FINAL RESPONSE
========================= */
echo json_encode([
    'success' => true,
    'server'  => [
        'id'           => $serverId,
        'name'         => $data['server']['name'],
        'icon'         => $data['server']['icon'],
        'memberCount'  => (int)$data['server']['memberCount'],
        'channelCount' => (int)$data['server']['channelCount'],
        'roleCount'    => (int)$data['server']['roleCount'],
        'roles'        => $roles,
        'joinRole'     => $joinRole
    ]
]);

exit;
