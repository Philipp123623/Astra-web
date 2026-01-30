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

    </div>
</header>

<!-- Mobile Overlay -->
<div class="astra-nav-mobile-overlay"></div>

<!-- ======================
     MOBILE MENU DRAWER
     ====================== -->
<nav class="astra-nav-mobile">

    <!-- HEADER MIT ❌ -->
    <div class="astra-nav-mobile-header">
        <span class="astra-nav-mobile-title">Menu</span>
        <button class="astra-nav-close" aria-label="Menü schließen"></button>
    </div>

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
</nav>

<!-- ======================
     MOBILE MENU SCRIPT
     ====================== -->
<script>
    const toggle = document.querySelector('.astra-nav-toggle');
    const closeBtn = document.querySelector('.astra-nav-close');
    const overlay = document.querySelector('.astra-nav-mobile-overlay');

    toggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');
    });

    closeBtn.addEventListener('click', () => {
        document.body.classList.remove('nav-open');
    });

    overlay.addEventListener('click', () => {
        document.body.classList.remove('nav-open');
    });
</script>
