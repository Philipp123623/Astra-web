<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

/* =========================
   CONFIG
========================= */
$client_id = '1113403511045107773';
$redirect_uri = 'https://astra-bot.de/login/callback.php';

/* =========================
   DISCORD OAUTH PARAMS
========================= */
$params = [
    'response_type' => 'code',
    'client_id'     => $client_id,
    'redirect_uri'  => $redirect_uri,
    'scope'         => 'identify guilds'
];

/* =========================
   REDIRECT TO DISCORD
========================= */
$auth_url = 'https://discord.com/api/oauth2/authorize?' . http_build_query($params);

header('Location: ' . $auth_url);
exit;
