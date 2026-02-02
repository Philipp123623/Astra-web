<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$client_id = "DEINE_CLIENT_ID";
$redirect_uri = urlencode("https://astra-bot.de/login/callback.php");

$scope = "identify guilds";

$url = "https://discord.com/oauth2/authorize"
    . "?response_type=code"
    . "&client_id=$client_id"
    . "&scope=$scope"
    . "&redirect_uri=$redirect_uri";

header("Location: $url");
exit;
