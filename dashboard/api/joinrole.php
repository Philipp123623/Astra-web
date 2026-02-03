<?php
declare(strict_types=1);

session_start();
header('Content-Type: application/json; charset=utf-8');

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['access_token'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error'   => 'Not authenticated'
    ]);
    exit;
}

/* =========================
   READ JSON BODY
========================= */
$input = json_decode(file_get_contents('php://input'), true);

if (
    empty($input['serverId']) ||
    !preg_match('/^\d+$/', (string)$input['serverId'])
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid server ID'
    ]);
    exit;
}

$serverId = (string)$input['serverId'];
$enabled  = (bool)($input['enabled'] ?? false);
$roleId   = $input['roleId'] ?? null;

/* =========================
   LOAD ENV + DB CONNECT
========================= */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/env.php';
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
   TOGGLE OFF -> DELETE
========================= */
if ($enabled === false) {

    $stmt = $conn->prepare("
        DELETE FROM join_roles
        WHERE guildID = ?
    ");
    $stmt->bind_param('s', $serverId);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'action'  => 'deleted'
    ]);
    exit;
}

/* =========================
   TOGGLE ON / UPDATE ROLE
========================= */
if (
    empty($roleId) ||
    !preg_match('/^\d+$/', (string)$roleId)
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid role ID'
    ]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO join_roles (guildID, roleID)
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE roleID = VALUES(roleID)
");

$stmt->bind_param('ss', $serverId, $roleId);
$stmt->execute();

echo json_encode([
    'success' => true,
    'action'  => 'saved'
]);
exit;
