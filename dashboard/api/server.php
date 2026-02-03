<?php
declare(strict_types=1);

/* =========================
   DEBUG (DEV ONLY)
========================= */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

/* =========================
   ENV
========================= */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/env.php';

/* =========================
   VALIDATE ID
========================= */
if (!isset($_GET['id']) || !preg_match('/^\d+$/', $_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid server ID'
    ]);
    exit;
}

$serverId = $_GET['id'];

/* =========================
   CALL BOT API (SERVER INFO)
========================= */
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "http://127.0.0.1:5000/servers/$serverId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5,
    CURLOPT_CONNECTTIMEOUT => 2,
]);

$response = curl_exec($ch);

if ($response === false) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Curl error: ' . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if (!$data || empty($data['success']) || empty($data['server'])) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid bot response'
    ]);
    exit;
}

/* =========================
   LOAD ENV + DB CONNECT
========================= */
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

$conn = new mysqli(
    $env['DB_SERVER'] ?? '',
    $env['DB_USER']   ?? '',
    $env['DB_PASS']   ?? '',
    $env['DB_NAME']   ?? ''
);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Database connection failed'
    ]);
    exit;
}

/* =========================
   JOIN ROLE (DB = SOURCE OF TRUTH)
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

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $joinRole['enabled'] = true;
    $joinRole['roleId']  = $row['roleID'];
}

/* =========================
   ROLES (FAIL-SAFE)
========================= */
$roles = [];

$rolesJson = @file_get_contents("http://127.0.0.1:5000/servers/$serverId/roles");
if ($rolesJson !== false) {
    $rolesData = json_decode($rolesJson, true);
    if (isset($rolesData['roles']) && is_array($rolesData['roles'])) {
        $roles = $rolesData['roles'];
    }
}

/* =========================
   FINAL RESPONSE
========================= */
echo json_encode([
    'success' => true,
    'server'  => [
        'id'           => $data['server']['id'] ?? $serverId,
        'name'         => $data['server']['name'] ?? 'Unknown',
        'icon'         => $data['server']['icon'] ?? null,
        'memberCount'  => $data['server']['memberCount'] ?? 0,
        'channelCount' => $data['server']['channelCount'] ?? 0,
        'roleCount'    => $data['server']['roleCount'] ?? 0,
        'roles'        => $roles,
        'joinRole'     => $joinRole
    ]
]);
exit;
