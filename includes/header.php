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
            </ul>
        </nav>

        <!-- HEADER ACTIONS -->
        <div class="astra-header-actions">

            <!-- Language Switch -->
            <div class="lang-switch" id="langSwitch">
                <button class="lang-btn" aria-label="Switch language">
                    <svg class="lang-core" viewBox="0 0 24 24">
                        <circle class="globe" cx="12" cy="12" r="9"/>
                        <path class="line" d="M3 12h18"/>
                        <path class="line" d="M12 3c3.5 4 3.5 14 0 18"/>
                        <path class="line" d="M12 3c-3.5 4-3.5 14 0 18"/>
                    </svg>
                </button>

                <div class="lang-dropdown">
                    <a href="?lang=de" class="<?= $lang === 'de' ? 'active' : '' ?>">Deutsch</a>
                    <a href="?lang=en" class="<?= $lang === 'en' ? 'active' : '' ?>">English</a>
                    <a href="?lang=fr" class="<?= $lang === 'fr' ? 'active' : '' ?>">Français</a>
                    <a href="?lang=es" class="<?= $lang === 'es' ? 'active' : '' ?>">Español</a>
                </div>
            </div>

            <!-- Theme Switch -->
            <!-- Theme Switch -->
            <div class="theme-switch" id="themeSwitch">
                <button class="theme-btn" aria-label="Choose theme">
                    <svg class="theme-core" viewBox="0 0 24 24">
                        <defs>
                            <linearGradient id="themeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#6affea"/>
                                <stop offset="100%" stop-color="#9cbcff"/>
                            </linearGradient>
                        </defs>

                        <circle class="theme-ring" cx="12" cy="12" r="9"/>
                        <circle class="theme-core-dot" cx="12" cy="12" r="4"/>
                    </svg>

                </button>

                <div class="theme-dropdown">
                    <button data-theme="default">Default</button>
                    <button data-theme="aurora-mint">Aurora Mint</button>
                    <button data-theme="aurora-deep-purple">Aurora Purple</button>
                    <button data-theme="midnight">Midnight</button>
                </div>
            </div>


        </div>

        <!-- Hamburger -->
        <button class="astra-nav-toggle" aria-label="<?= $t['nav_menu'] ?>">
            <span></span><span></span><span></span>
        </button>

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
        <a href="https://astra-bot.de/#about" class="nav-link"><?= $t['nav_about'] ?></a>
        <a href="https://astra-bot.de/#features" class="nav-link"><?= $t['nav_features'] ?></a>
        <a href="https://astra-bot.de/#faq" class="nav-link"><?= $t['nav_faq'] ?></a>
        <a href="https://astra-bot.de/commands" class="nav-link"><?= $t['nav_commands'] ?></a>
        <a href="https://astra-bot.de/status" class="nav-link"><?= $t['nav_status'] ?></a>
        <a href="https://astra-bot.de/report" class="nav-link"><?= $t['nav_report'] ?></a>
    </div>

    <div class="astra-nav-lang">
        <span class="astra-nav-lang-title"><?= $t['nav_language'] ?? 'Language' ?></span>
        <div class="astra-nav-lang-list">
            <a href="?lang=de" class="<?= $lang === 'de' ? 'active' : '' ?>">Deutsch</a>
            <a href="?lang=en" class="<?= $lang === 'en' ? 'active' : '' ?>">English</a>
            <a href="?lang=fr" class="<?= $lang === 'fr' ? 'active' : '' ?>">Français</a>
            <a href="?lang=es" class="<?= $lang === 'es' ? 'active' : '' ?>">Español</a>
        </div>
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

        toggle?.addEventListener('click', () => document.body.classList.add('nav-open'));
        closeBtn?.addEventListener('click', () => document.body.classList.remove('nav-open'));
        overlay?.addEventListener('click', () => document.body.classList.remove('nav-open'));
    });
</script>

<!-- ======================
     DROPDOWNS (LANG + THEME)
====================== -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const langSwitch = document.getElementById('langSwitch');
        const themeSwitch = document.getElementById('themeSwitch');

        function closeAll() {
            langSwitch?.classList.remove('open');
            themeSwitch?.classList.remove('open');
        }

        langSwitch?.querySelector('.lang-btn')?.addEventListener('click', e => {
            e.stopPropagation();
            langSwitch.classList.toggle('open');
            themeSwitch?.classList.remove('open');
        });

        themeSwitch?.querySelector('.theme-btn')?.addEventListener('click', e => {
            e.stopPropagation();
            themeSwitch.classList.toggle('open');
            langSwitch?.classList.remove('open');
        });

        document.addEventListener('click', closeAll);
    });
</script>

<!-- ======================
     THEME SELECTION
====================== -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.documentElement;
        const STORAGE_KEY = 'astra-theme';

        const savedTheme = localStorage.getItem(STORAGE_KEY);
        if (savedTheme && savedTheme !== 'default') {
            root.setAttribute('data-theme', savedTheme);
        }

        document.querySelectorAll('[data-theme]').forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const theme = btn.dataset.theme;

                if (theme === 'default') {
                    root.removeAttribute('data-theme');
                    localStorage.removeItem(STORAGE_KEY);
                } else {
                    root.setAttribute('data-theme', theme);
                    localStorage.setItem(STORAGE_KEY, theme);
                }
            });
        });
    });
</script>
