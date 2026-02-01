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

        <!-- Hamburger -->
        <button class="astra-nav-toggle" aria-label="<?= $t['nav_menu'] ?>">
            <span></span><span></span><span></span>
        </button>

        <!-- Language Switch -->
        <div class="lang-switch" id="langSwitch">
            <button class="lang-btn" aria-label="Switch language">
                <svg class="lang-core" viewBox="0 0 24 24" aria-hidden="true">
                    <defs>
                        <linearGradient id="globeGradient" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#ffffff"/>
                            <stop offset="100%" stop-color="#65e6ce"/>
                        </linearGradient>
                    </defs>

                    <circle cx="12" cy="12" r="9" class="globe"/>
                    <path d="M3 12h18" class="line"/>
                    <path d="M12 3c3.5 4 3.5 14 0 18" class="line"/>
                    <path d="M12 3c-3.5 4-3.5 14 0 18" class="line"/>
                </svg>
            </button>

            <div class="lang-dropdown">

                <a href="?lang=de" class="<?= $lang === 'de' ? 'active' : '' ?>">
                    <svg class="lang-text-icon" viewBox="0 0 32 20" aria-hidden="true">
                        <rect x="1" y="1" width="30" height="18" rx="6" />
                        <text x="16" y="14">DE</text>
                    </svg>
                    Deutsch
                </a>

                <a href="?lang=en" class="<?= $lang === 'en' ? 'active' : '' ?>">
                    <svg class="lang-text-icon" viewBox="0 0 32 20" aria-hidden="true">
                        <rect x="1" y="1" width="30" height="18" rx="6" />
                        <text x="16" y="14">EN</text>
                    </svg>
                    English
                </a>

                <a href="?lang=fr" class="<?= $lang === 'fr' ? 'active' : '' ?>">
                    <svg class="lang-text-icon" viewBox="0 0 32 20" aria-hidden="true">
                        <rect x="1" y="1" width="30" height="18" rx="6" />
                        <text x="16" y="14">FR</text>
                    </svg>
                    Français
                </a>

                <a href="?lang=es" class="<?= $lang === 'es' ? 'active' : '' ?>">
                    <svg class="lang-text-icon" viewBox="0 0 32 20" aria-hidden="true">
                        <rect x="1" y="1" width="30" height="18" rx="6" />
                        <text x="16" y="14">ES</text>
                    </svg>
                    Español
                </a>

            </div>

        </div>
        <!-- Theme Switch (Desktop) -->
        <div class="theme-switch" id="themeSwitch">

            <button class="theme-btn" aria-label="Choose theme">
                <svg class="theme-core" viewBox="0 0 24 24" aria-hidden="true">
                    <defs>
                        <linearGradient id="themeGradient" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#6affea"/>
                            <stop offset="100%" stop-color="#9cbcff"/>
                        </linearGradient>
                    </defs>

                    <!-- Outer ring -->
                    <circle cx="12" cy="12" r="9" class="theme-ring"/>

                    <!-- Inner dot -->
                    <circle cx="12" cy="12" r="4" class="theme-core-dot"/>

                    <!-- Rays -->
                    <g class="theme-rays">
                        <line x1="12" y1="1.5" x2="12" y2="4"/>
                        <line x1="12" y1="20" x2="12" y2="22.5"/>
                        <line x1="1.5" y1="12" x2="4" y2="12"/>
                        <line x1="20" y1="12" x2="22.5" y2="12"/>
                    </g>
                </svg>
            </button>

            <div class="theme-dropdown">
                <button data-theme="default">Default</button>
                <button data-theme="aurora-mint">Aurora Mint</button>
                <button data-theme="aurora-violet">Aurora Violet</button>
                <button data-theme="midnight">Midnight</button>
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

        /* =========================
           MOBILE MENU
        ========================= */

        const toggle = document.querySelector('.astra-nav-toggle');
        const closeBtn = document.querySelector('.astra-nav-close');
        const overlay = document.querySelector('.astra-nav-mobile-overlay');

        if (toggle) {
            toggle.addEventListener('click', () => {
                document.body.classList.add('nav-open');
            });

            closeBtn?.addEventListener('click', () => {
                document.body.classList.remove('nav-open');
            });

            overlay?.addEventListener('click', () => {
                document.body.classList.remove('nav-open');
            });
        }

        /* =========================
           DROPDOWNS (LANG + THEME)
        ========================= */

        const langSwitch  = document.getElementById('langSwitch');
        const themeSwitch = document.getElementById('themeSwitch');

        function closeAllDropdowns() {
            langSwitch?.classList.remove('open');
            themeSwitch?.classList.remove('open');
        }

        // Language toggle
        if (langSwitch) {
            const btn = langSwitch.querySelector('.lang-btn');
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const wasOpen = langSwitch.classList.contains('open');
                closeAllDropdowns();
                if (!wasOpen) langSwitch.classList.add('open');
            });
        }

        // Theme dropdown toggle
        if (themeSwitch) {
            const btn = themeSwitch.querySelector('.theme-btn');
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const wasOpen = themeSwitch.classList.contains('open');
                closeAllDropdowns();
                if (!wasOpen) themeSwitch.classList.add('open');
            });
        }

        // Click outside closes all
        document.addEventListener('click', closeAllDropdowns);

        /* =========================
           THEME SELECTION + ANIMATION
        ========================= */

        if (themeSwitch) {
            const root = document.documentElement;
            const STORAGE_KEY = 'astra-theme';
            const items = themeSwitch.querySelectorAll('[data-theme]');

            // INIT – nur setzen, KEINE Animation
            const savedTheme = localStorage.getItem(STORAGE_KEY);
            if (savedTheme && savedTheme !== 'default') {
                root.setAttribute('data-theme', savedTheme);
            }

            function updateActive(theme) {
                items.forEach(el =>
                    el.classList.toggle('active', el.dataset.theme === theme)
                );
            }

            updateActive(savedTheme || 'default');

            // Theme auswählen
            items.forEach(item => {
                item.addEventListener('click', e => {
                    e.stopPropagation();

                    const theme = item.dataset.theme;

                    // 🔥 Animation explizit triggern
                    root.classList.add('theme-animating');

                    if (theme === 'default') {
                        root.removeAttribute('data-theme');
                        localStorage.removeItem(STORAGE_KEY);
                    } else {
                        root.setAttribute('data-theme', theme);
                        localStorage.setItem(STORAGE_KEY, theme);
                    }

                    updateActive(theme);
                    closeAllDropdowns();

                    // 🔥 Animation nach Ende entfernen
                    setTimeout(() => {
                        root.classList.remove('theme-animating');
                    }, 1700);
                });
            });
        }

    });
</script>







