<?php
header('Content-Type: application/json');

$json = @file_get_contents('http://127.0.0.1:5000/servers');

if ($json === false) {
    echo json_encode([
        'success' => false,
        'error' => 'API not reachable'
    ]);
    exit;
}

echo $json;
