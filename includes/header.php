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
                <li><a href="https://astra-bot.de/" class="nav-link">Home</a></li>
                <li><a href="https://astra-bot.de/#stats" class="nav-link">Stats</a></li>
                <li><a href="https://astra-bot.de/#about" class="nav-link scrollto">About</a></li>
                <li><a href="https://astra-bot.de/#features" class="nav-link scrollto">Features</a></li>
                <li><a href="https://astra-bot.de/#faq" class="nav-link scrollto">FAQ</a></li>
                <li><a href="https://astra-bot.de/commands" class="nav-link">Commands</a></li>
                <li><a href="https://astra-bot.de/status" class="nav-link">Status</a></li>
                <li><a href="https://astra-bot.de/report" class="nav-link">Report</a></li>
                <li><a href="https://astra-bot.de/invite" class="nav-btn">Bot einladen</a></li>
            </ul>
        </nav>

        <!-- Hamburger Button -->
        <button class="astra-nav-toggle" aria-label="Menü öffnen">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="lang-switch">
            <a href="?lang=de">🇩🇪 DE</a>
            <a href="?lang=en">🇬🇧 EN</a>
        </div>

    </div>
</header>

<!-- Mobile Overlay -->
<div class="astra-nav-mobile-overlay"></div>

<!-- ======================
     MOBILE MENU DRAWER
     ====================== -->
<nav class="astra-nav-mobile">

    <!-- HERO BUBBLES -->
    <div class="astra-nav-bubbles">
        <svg width="100%" height="100%" preserveAspectRatio="none">
            <circle cx="20%" cy="12%" r="46" fill="#65e6ce22"/>
            <circle cx="82%" cy="18%" r="78" fill="#a7c8fd22"/>
            <circle cx="36%" cy="64%" r="72" fill="#7c41ee22"/>
            <circle cx="88%" cy="78%" r="34" fill="#60e9cb22"/>
        </svg>
    </div>


    <!-- HEADER MIT ❌ -->
    <div class="astra-nav-mobile-header">
        <span class="astra-nav-mobile-title">Menu</span>
        <button class="astra-nav-close" aria-label="Menü schließen"></button>
    </div>

    <!-- ⬇️ NUR DAS SCROLLT -->
    <div class="astra-nav-mobile-scroll">

        <!-- LINKS -->
        <a href="https://astra-bot.de/" class="nav-link">Home</a>
        <a href="https://astra-bot.de/#stats" class="nav-link">Stats</a>
        <a href="https://astra-bot.de/#about" class="nav-link scrollto">About</a>
        <a href="https://astra-bot.de/#features" class="nav-link scrollto">Features</a>
        <a href="https://astra-bot.de/#faq" class="nav-link scrollto">FAQ</a>
        <a href="https://astra-bot.de/commands" class="nav-link">Commands</a>
        <a href="https://astra-bot.de/status" class="nav-link">Status</a>
        <a href="https://astra-bot.de/report" class="nav-link">Report</a>

        <!-- CTA -->
        <a href="https://astra-bot.de/invite" class="nav-btn">Bot einladen</a>

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

