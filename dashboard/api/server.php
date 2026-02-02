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
   CALL BOT API (CURL!)
========================= */
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "http://127.0.0.1:5000/servers/$serverId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 3,
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
http_response_code($httpCode);
echo $response;
