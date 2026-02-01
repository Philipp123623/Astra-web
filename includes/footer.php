<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>


<footer class="astra-footer">
    <link rel="stylesheet" href="/css/style.css?v=2.4"/>

    <div class="astra-footer-wrap">

        <div class="astra-footer-brand">
            <div class="astra-footer-logo">
                <img src="/public/favicon_transparent.png" alt="Astra Bot">
                <span>Astra <strong>Bot</strong></span>
            </div>

            <p class="astra-footer-text">
                <?= $t['footer_desc'] ?>
            </p>

            <p class="astra-footer-copy">
                © <?= date('Y'); ?> Astra Bot<br>
                <?= $t['footer_not_affiliated'] ?>
            </p>
        </div>

        <div class="astra-footer-links">
            <h4><?= $t['footer_links_useful'] ?></h4>
            <a href="/"><?= $t['footer_home'] ?></a>
            <a href="/features"><?= $t['footer_features'] ?></a>
            <a href="/commands"><?= $t['footer_commands'] ?></a>
            <a href="/faq"><?= $t['footer_faq'] ?></a>
            <a href="/status"><?= $t['footer_status'] ?></a>
        </div>

        <div class="astra-footer-links">
            <h4><?= $t['footer_links_other'] ?></h4>
            <a href="/support"><?= $t['footer_support'] ?></a>
            <a href="/invite"><?= $t['footer_invite'] ?></a>
            <a href="/impressum"><?= $t['footer_imprint'] ?></a>
            <a href="/privacy-policy"><?= $t['footer_privacy'] ?></a>
            <a href="/terms-of-service"><?= $t['footer_terms'] ?></a>
        </div>

    </div>
</footer>
