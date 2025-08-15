<?php
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$isBot = preg_match('/discordbot|twitterbot|slackbot|facebookexternalhit|telegrambot/', $userAgent);

if (!$isBot) {
    // Browser-User direkt weiterleiten
    header("Location: https://discord.com/oauth2/authorize?client_id=1113403511045107773&permissions=1899359446&scope=bot%20applications.commands");
    exit();
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Astra – Dein All-in-One Discord-Bot</title>

    <!-- Open Graph -->
    <meta property="og:title" content="Astra – Dein All-in-One Discord-Bot">
    <meta property="og:description" content="Neueröffnung mit Backup-System, Notifier, Minigames, Level 2.0 und Economy 2.0 – lade Astra jetzt auf deinen Server ein.">
    <meta property="og:image" content="https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg?ex=68a0900b&is=689f3e8b&hm=dc485e00d3a4b067153a0402fa30c6a65f277b8d0cac0e8914c3fffae6511320&">
    <meta property="og:url" content="https://astra-bot.de/invite">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Astra – Dein All-in-One Discord-Bot">
    <meta name="twitter:description" content="Neueröffnung mit Backup-System, Notifier, Minigames, Level 2.0 und Economy 2.0 – lade Astra jetzt auf deinen Server ein.">
    <meta name="twitter:image" content="https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg?ex=68a0900b&is=689f3e8b&hm=dc485e00d3a4b067153a0402fa30c6a65f277b8d0cac0e8914c3fffae6511320&">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, sans-serif;
            display: grid;
            place-items: center;
            height: 100vh;
            margin: 0;
            background: #0d1117 url('https://cdn.discordapp.com/attachments/1113404918414458991/1405915181220892733/Profilbanner.gif?ex=68a0900b&is=689f3e8b&hm=7f9102aeb5e094e5bd84c6f81fd17dee0ebbeb1f0d5f039fb50f5b18b9b5997d&') no-repeat center/cover;
            color: white;
            text-align: center;
        }
        .card {
            background: rgba(0,0,0,0.6);
            padding: 2rem;
            border-radius: 12px;
            max-width: 500px;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.8rem 1.2rem;
            background: #5865F2;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover { background: #4752C4; }
    </style>
</head>
<body>
<div class="card">
    <h1>🚀 Astra – Dein All-in-One Discord-Bot</h1>
    <p>Backup-System · Notifier · Minigames · Levelsystem 2.0 · Economy 2.0</p>
    <a href="https://discord.com/oauth2/authorize?client_id=1113403511045107773&permissions=1899359446&scope=bot%20applications.commands">Bot einladen</a>
</div>
</body>
</html>
