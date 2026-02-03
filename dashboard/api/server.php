<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

/* =========================
   VALIDATE ID
========================= */
if (!isset($_GET['id']) || !preg_match('/^\d+$/', $_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid server ID'
    ]);
    exit;
}

$serverId = $_GET['id'];

/* =========================
   CALL BOT API (CURL)
========================= */
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "http://127.0.0.1:5000/servers/$serverId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5,
    CURLOPT_CONNECTTIMEOUT => 2,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'error' => 'Curl error: ' . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);

/* =========================
   FORWARD RESPONSE
========================= */
$data = json_decode($response, true);

if (!$data || empty($data['success'])) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid bot response'
    ]);
    exit;
}

// ENV laden
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

// DB Connect
$conn = @new mysqli(
    $env['DB_SERVER'] ?? '',
    $env['DB_USER'] ?? '',
    $env['DB_PASS'] ?? '',
    $env['DB_NAME'] ?? ''
);

$stats = [
    'servercount' => 0,
    'usercount' => 0,
    'commandCount' => 0,
    'channelCount' => 0
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

$joinRole = [
    'enabled' => $row !== null,
    'roleId'  => $row['roleID'] ?? null
];


?>
