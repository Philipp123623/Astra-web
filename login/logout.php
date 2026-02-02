<?php
session_start();

/**
 * Session vollständig zerstören
 */
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

/**
 * Optional: Discord Logout (nicht zwingend nötig)
 * Discord OAuth Tokens sind stateless – Session killt Login
 */

/**
 * Zurück zur Startseite
 */
header("Location: https://astra-bot.de/");
exit;
