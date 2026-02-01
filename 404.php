<?php

session_start();

$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'de';
if (!in_array($lang, ['de','en'])) $lang = 'de';
$_SESSION['lang'] = $lang;

$t = require __DIR__ . "/lang/$lang.php";
?>

<?php include "includes/header.php"; ?>
<script>document.body.classList.add('error-layout');</script>

<main class="error-page">

    <section class="error-hero-card">
        <div class="error-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="18%" cy="22%" r="42" fill="#65e6ce33"/>
                <circle cx="85%" cy="30%" r="70" fill="#a7c8fd22"/>
                <circle cx="55%" cy="75%" r="48" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="28" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="error-hero-content">
            <span class="error-code"><?= $t['error_404_code'] ?></span>

            <h1><?= $t['error_404_title'] ?></h1>

            <p>
                <?= nl2br($t['error_404_desc']) ?>
            </p>

            <div class="error-actions">
                <a href="/" class="astra-btn main">
                    <?= $t['error_404_home'] ?>
                </a>
                <a href="/support" class="astra-btn outline">
                    <?= $t['error_404_support'] ?>
                </a>
            </div>
        </div>
    </section>

</main>

<?php include "includes/footer.php"; ?>
