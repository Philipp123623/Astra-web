<?php
header('Content-Type: application/json');

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
   CALL BOT API
========================= */
$json = @file_get_contents("http://127.0.0.1:5000/servers/$serverId");

if ($json === false) {
    echo json_encode([
        'success' => false,
        'error' => 'API not reachable'
    ]);
    exit;
}

echo $json;
