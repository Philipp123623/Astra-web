<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/lang.php';
?>


<header class="astra-header">
    <div class="astra-header-inner">

        <!-- Logo -->
        <a href="https://astra-bot.de/" class="astra-logo">
            <img src="/public/favicon_transparent.png" alt="Astra Logo">
            <span class="astra-logo-text">Astra <span>Bot</span></span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="astra-navbar">
            <ul>
                <li><a href="https://astra-bot.de/" class="nav-link"><?= $t['nav_home'] ?></a></li>
                <li><a href="https://astra-bot.de/#stats" class="nav-link"><?= $t['nav_stats'] ?></a></li>
                <li><a href="https://astra-bot.de/#about" class="nav-link scrollto"><?= $t['nav_about'] ?></a></li>
                <li><a href="https://astra-bot.de/#features" class="nav-link scrollto"><?= $t['nav_features'] ?></a></li>
                <li><a href="https://astra-bot.de/#faq" class="nav-link scrollto"><?= $t['nav_faq'] ?></a></li>
                <li><a href="https://astra-bot.de/commands" class="nav-link"><?= $t['nav_commands'] ?></a></li>
                <li><a href="https://astra-bot.de/status" class="nav-link"><?= $t['nav_status'] ?></a></li>
                <li><a href="https://astra-bot.de/report" class="nav-link"><?= $t['nav_report'] ?></a></li>
                <li><a href="https://astra-bot.de/invite" class="nav-btn"><?= $t['nav_invite'] ?></a></li>
            </ul>
        </nav>

        <!-- Hamburger Button -->
        <button class="astra-nav-toggle" aria-label="<?= $t['nav_menu'] ?>">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Language Switch -->

        <div class="lang-switch" id="langSwitch">
            <button class="lang-btn" aria-label="Switch language">
                <svg class="lang-core" viewBox="0 0 100 100" aria-hidden="true">
                    <!-- Outer Energy Ring -->
                    <circle cx="50" cy="50" r="46" class="q-ring"/>

                    <!-- Pulse Ring -->
                    <circle cx="50" cy="50" r="38" class="q-pulse"/>

                    <!-- Core Planet -->
                    <circle cx="50" cy="50" r="22" class="q-core"/>

                    <!-- Latitude Lines -->
                    <ellipse cx="50" cy="50" rx="34" ry="12" class="q-lat"/>
                    <ellipse cx="50" cy="50" rx="34" ry="12" class="q-lat flip"/>

                    <!-- Orbit -->
                    <circle cx="50" cy="50" r="30" class="q-orbit"/>
                </svg>
            </button>

            <div class="lang-dropdown">
                <a href="?lang=de" class="active">🇩🇪 Deutsch</a>
                <a href="?lang=en">🇬🇧 English</a>
            </div>
        </div>



    </div>
</header>

<!-- Mobile Overlay -->
<div class="astra-nav-mobile-overlay"></div>

<nav class="astra-nav-mobile">

    <div class="astra-nav-bubbles">
        <svg width="100%" height="100%" preserveAspectRatio="none">
            <circle cx="20%" cy="12%" r="46" fill="#65e6ce22"/>
            <circle cx="82%" cy="18%" r="78" fill="#a7c8fd22"/>
            <circle cx="36%" cy="64%" r="72" fill="#7c41ee22"/>
            <circle cx="88%" cy="78%" r="34" fill="#60e9cb22"/>
        </svg>
    </div>

    <div class="astra-nav-mobile-header">
        <span class="astra-nav-mobile-title"><?= $t['nav_menu'] ?></span>
        <button class="astra-nav-close" aria-label="<?= $t['nav_menu'] ?>"></button>
    </div>

    <div class="astra-nav-mobile-scroll">
        <a href="https://astra-bot.de/" class="nav-link"><?= $t['nav_home'] ?></a>
        <a href="https://astra-bot.de/#stats" class="nav-link"><?= $t['nav_stats'] ?></a>
        <a href="https://astra-bot.de/#about" class="nav-link scrollto"><?= $t['nav_about'] ?></a>
        <a href="https://astra-bot.de/#features" class="nav-link scrollto"><?= $t['nav_features'] ?></a>
        <a href="https://astra-bot.de/#faq" class="nav-link scrollto"><?= $t['nav_faq'] ?></a>
        <a href="https://astra-bot.de/commands" class="nav-link"><?= $t['nav_commands'] ?></a>
        <a href="https://astra-bot.de/status" class="nav-link"><?= $t['nav_status'] ?></a>
        <a href="https://astra-bot.de/report" class="nav-link"><?= $t['nav_report'] ?></a>

        <a href="https://astra-bot.de/invite" class="nav-btn"><?= $t['nav_invite'] ?></a>
    </div>
</nav>


<!-- ======================
     MOBILE MENU SCRIPT
     ====================== -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const toggle = document.querySelector('.astra-nav-toggle');
        const closeBtn = document.querySelector('.astra-nav-close');
        const overlay = document.querySelector('.astra-nav-mobile-overlay');

        if (!toggle) return;

        toggle.addEventListener('click', () => {
            document.body.classList.add('nav-open');
        });

        closeBtn.addEventListener('click', () => {
            document.body.classList.remove('nav-open');
        });

        overlay.addEventListener('click', () => {
            document.body.classList.remove('nav-open');
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const langSwitch = document.querySelector('.lang-switch');
        if (!langSwitch) return;

        const btn = langSwitch.querySelector('.lang-btn');

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            langSwitch.classList.toggle('open');
        });

        document.addEventListener('click', () => {
            langSwitch.classList.remove('open');
        });
    });
</script>



