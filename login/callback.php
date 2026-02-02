<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

/* =========================
   ENV LOADER
========================= */
function loadEnv(string $path): array {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden");
    }

    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }

    return $env;
}

/* =========================
   LOAD ENV
========================= */
$env = loadEnv($_SERVER['DOCUMENT_ROOT'] . '/.env');

$client_id     = $env['DISCORD_CLIENT_ID'] ?? null;
$client_secret = $env['DISCORD_CLIENT_SECRET'] ?? null;
$redirect_uri  = 'https://astra-bot.de/login/callback.php';

if (!$client_id || !$client_secret) {
    die('Client ID oder Secret fehlt im .env');
}

/* =========================
   CHECK CODE
========================= */
if (!isset($_GET['code'])) {
    die('Kein OAuth-Code erhalten');
}

$code = $_GET['code'];

/* =========================
   TOKEN REQUEST
========================= */
$postData = http_build_query([
    'client_id'     => $client_id,
    'client_secret' => $client_secret,
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'redirect_uri'  => $redirect_uri
]);

$context = stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  =>
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "User-Agent: AstraDashboard/1.0\r\n",
        'content' => $postData,
        'ignore_errors' => true
    ]
]);

$response = file_get_contents('https://discord.com/api/oauth2/token', false, $context);
$data = json_decode($response, true);

/* =========================
   ERROR DEBUG (falls nötig)
========================= */
if (!isset($data['access_token'])) {
    echo "<pre>";
    echo "Token Fehler\n\n";
    print_r($data);
    echo "\n\nRAW RESPONSE:\n$response";
    echo "</pre>";
    exit;
}

/* =========================
   SAVE SESSION
========================= */
$_SESSION['access_token'] = $data['access_token'];
$_SESSION['token_type']   = $data['token_type'];
$_SESSION['expires_in']   = time() + $data['expires_in'];

/* =========================
   REDIRECT TO DASHBOARD
========================= */
header('Location: /dashboard');
exit;

