<?php
session_start();

$client_id = "DEINE_CLIENT_ID";
$client_secret = "DEIN_CLIENT_SECRET";
$redirect_uri = "https://DEINE-DOMAIN/login/callback.php";

if (!isset($_GET['code'])) {
    die("Kein OAuth-Code erhalten");
}

$code = $_GET['code'];

$context = stream_context_create([
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query([
            "client_id" => $client_id,
            "client_secret" => $client_secret,
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => $redirect_uri
        ])
    ]
]);

$response = file_get_contents("https://discord.com/api/oauth2/token", false, $context);
$data = json_decode($response, true);

if (!isset($data['access_token'])) {
    die("Token Fehler");
}

$_SESSION['access_token'] = $data['access_token'];

header("Location: /dashboard");
exit;
