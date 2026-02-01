<?php

session_start();

$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'de';
if (!in_array($lang, ['de','en'])) $lang = 'de';
$_SESSION['lang'] = $lang;

$t = require __DIR__ . "/lang/$lang.php";
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8" />
    <title><?= $t['imprint_title'] ?> | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=4.3" />
</head>
<body>

<?php include "includes/header.php"; ?>

<main class="legal-main">

    <!-- HERO -->
    <section class="legal-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="24%" r="44" fill="#65e6ce22"/>
                <circle cx="86%" cy="28%" r="62" fill="#a7c8fd22"/>
                <circle cx="55%" cy="78%" r="38" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="legal-hero-content">
            <h1><?= $t['imprint_title'] ?></h1>
            <p class="legal-hero-desc"><?= $t['imprint_desc'] ?></p>

            <div class="legal-hero-meta">
                <span>📄 <?= $t['imprint_meta_legal'] ?></span>
                <span>🤖 <?= $t['imprint_meta_bot'] ?></span>
                <span>🌐 <?= $t['imprint_meta_website'] ?></span>
                <span>🇩🇪 <?= $t['imprint_meta_country'] ?></span>
            </div>
        </div>
    </section>

    <!-- MAIN -->
    <section class="legal-main-card">

        <div class="legal-row">

            <!-- RESPONSIBLE -->
            <div class="legal-section">
                <h2>👤 <?= $t['imprint_responsible_title'] ?></h2>

                <div class="legal-grid">
                    <div class="legal-label"><?= $t['imprint_name'] ?></div>
                    <div class="legal-value">Stüve, Philipp Lukas</div>

                    <div class="legal-label"><?= $t['imprint_address'] ?></div>
                    <div class="legal-value">
                        Berliner Straße 25<br>
                        63477 Maintal<br>
                        Deutschland
                    </div>

                    <div class="legal-label"><?= $t['imprint_email'] ?></div>
                    <div class="legal-value">
                        <a href="mailto:support@astra-bot.de">support@astra-bot.de</a>
                    </div>
                </div>
            </div>

            <!-- SCOPE -->
            <div class="legal-side-card">
                <h3>📌 <?= $t['imprint_scope_title'] ?></h3>

                <p class="legal-text"><?= $t['imprint_scope_desc'] ?></p>

                <ul class="legal-list">
                    <li>🌐 <strong><?= $t['imprint_scope_website'] ?></strong></li>
                    <li>🤖 <strong><?= $t['imprint_scope_bot'] ?></strong></li>
                </ul>

                <span class="legal-chip">
                    ℹ️ <?= $t['imprint_scope_note'] ?>
                </span>
            </div>

        </div>

    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
