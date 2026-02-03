<?php
declare(strict_types=1);

function loadEnv(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }

    $vars = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $vars[$key] = trim($value, "\"'");
    }

    return $vars;
}


/* ==========================================================
   API: SERVER DETAILS (NO ENV, NO DOTENV)
========================================================== */

ini_set('display_errors', '0');
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

/* =========================
   CONFIG (HARD CODED)
========================= */
$dbHost = 'localhost';
$dbUser = 'DB_USER_HERE';
$dbPass = 'DB_PASS_HERE';
$dbName = 'DB_NAME_HERE';

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
    empty($data['success']) ||
    empty($data['server'])
) {
    http_response_code(502);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid bot response'
    ]);
    exit;
}

/* =========================
   DB CONNECT
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
   JOIN ROLE
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
$res = $stmt->get_result()->fetch_assoc();

if ($res) {
    $joinRole['enabled'] = true;
    $joinRole['roleId']  = (string)$res['roleID'];
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
        !empty($rolesData['roles'])
    ) {
        $roles = $rolesData['roles'];
    }
}

/* =========================
   RESPONSE
========================= */
echo json_encode([
    'success' => true,
    'server' => [
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
