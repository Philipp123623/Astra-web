<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
ini_set('display_errors', '0');

$json = file_get_contents('http://127.0.0.1:5000/servers');

if ($json === false) {
    echo json_encode([
        'success' => false,
        'error' => 'API not reachable'
    ]);
    exit;
}

echo $json;

