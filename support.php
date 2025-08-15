<?php
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$isBot = preg_match('/discordbot|twitterbot|slackbot|facebookexternalhit|telegrambot/', $userAgent);

if (!$isBot) {
    // Normale Nutzer sofort zum Discord-Server weiterleiten
    header("Location: https://discord.gg/eatdJPfjWc");
    exit();
}

// Bots bekommen die OG-HTML-Ausgabe
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Astra Support-Server</title>

    <!-- Open Graph -->
    <meta property="og:title" content="Astra Support-Server">
    <meta property="og:description" content="Tritt dem offiziellen Astra Support-Server bei – Community, Hilfe & Updates direkt vom Team.">
    <meta property="og:image" content="https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg?ex=68a0900b&is=689f3e8b&hm=dc485e00d3a4b067153a0402fa30c6a65f277b8d0cac0e8914c3fffae6511320&">
    <meta property="og:url" content="https://astra-bot.de/support">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Astra Support-Server">
    <meta name="twitter:description" content="Community, Hilfe & Updates direkt vom Astra-Team.">
    <meta name="twitter:image" content="https://cdn.discordapp.com/attachments/1113404918414458991/1405915180881285172/Idee_2_blau.jpg?ex=68a0900b&is=689f3e8b&hm=dc485e00d3a4b067153a0402fa30c6a65f277b8d0cac0e8914c3fffae6511320&">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, sans-serif;
            display: grid;
            place-items: center;
            height: 100vh;
            margin: 0;
            background: #0d1117;
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
    <h1>🛠 Astra Support-Server</h1>
    <p>Community, Hilfe & Updates direkt vom Astra-Team.</p>
    <a href="https://discord.gg/eatdJPfjWc">Server beitreten</a>
</div>
</body>
</html>
