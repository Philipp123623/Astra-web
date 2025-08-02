<?php
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>404 – Seite nicht gefunden | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=2.0" />
    <style>
        body, html {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(120deg, #221c50 0%, #2a2463 90%, #33ccd7 200%);
            font-family: 'Montserrat', sans-serif;
            color: #e7f8fc;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            min-height: 440px;
            max-width: 620px;
            margin: 60px auto 60px auto;
            padding: 54px 38px 64px 38px;
            background: linear-gradient(135deg, #251f5b 0%, #312c6c 100%);
            border-radius: 42px;
            box-shadow: 0 8px 32px rgba(91, 101, 255, 0.13);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Bubbles wie Astra Landingpage */
        .blob {
            position: absolute;
            border-radius: 50%;
            opacity: 0.18;
            z-index: 0;
            filter: blur(1.5px);
            pointer-events: none;
            transition: opacity 0.25s;
        }
        .blob1 {
            width: 150px; height: 150px;
            top: -50px; left: -60px;
            background: #4cd9ee;
            animation: blobFloat1 7.4s ease-in-out infinite;
        }
        .blob2 {
            width: 120px; height: 120px;
            bottom: 40px; right: -60px;
            background: #897bff;
            animation: blobFloat2 9s ease-in-out infinite;
        }
        .blob3 {
            width: 80px; height: 80px;
            top: 60px; right: 80px;
            background: #65e6ce;
            animation: blobFloat3 6.2s ease-in-out infinite;
        }
        .blob4 {
            width: 52px; height: 52px;
            bottom: 24px; left: 40px;
            background: #eafffd;
            opacity: 0.10;
            animation: blobFloat4 8.1s ease-in-out infinite;
        }

        @keyframes blobFloat1 {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%      { transform: translateY(-16px) scale(1.08); }
        }
        @keyframes blobFloat2 {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%      { transform: translateY(12px) scale(0.96); }
        }
        @keyframes blobFloat3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25%      { transform: translate(-8px, 4px) scale(1.06);}
            75%      { transform: translate(7px, -6px) scale(1.04);}
        }
        @keyframes blobFloat4 {
            0%, 100% { transform: translate(0, 0) scale(1);}
            40%      { transform: translate(3px, -10px) scale(1.10);}
            70%      { transform: translate(-5px, 8px) scale(0.95);}
        }

        .notfound-icon {
            font-size: 3.2rem;
            margin-bottom: 18px;
            z-index: 1;
            opacity: 0.95;
            filter: drop-shadow(0 0 12px #65e6ce55); /* sanftes Glow für die Rakete */
            transition: filter 0.18s;
        }
        /* Optional: SVG Rocket im Astra-Style, damit es nicht nach Emoji aussieht */
        .notfound-icon svg {
            width: 52px;
            height: 52px;
            display: block;
            margin: 0 auto;
        }

        .notfound-404 {
            font-weight: 700;
            font-size: 4.2rem;
            color: #7cebe7;
            margin: 0 0 10px 0;
            letter-spacing: 0.04em;
            text-shadow: 0 1px 10px #251f5b2e;
            z-index: 1;
        }
        .notfound-headline {
            font-weight: 700;
            font-size: 1.7rem;
            color: #d7f3ff;
            margin: 0 0 18px 0;
            letter-spacing: 0.04em;
            z-index: 1;
        }
        .notfound-desc {
            font-weight: 500;
            font-size: 1.13rem;
            max-width: 440px;
            line-height: 1.4;
            color: #b7f8f6;
            margin-bottom: 46px;
            z-index: 1;
        }
        a.astra-btn.main {
            position: relative;
            z-index: 1;
            font-weight: 900;
            font-size: 1.15rem;
            padding: 16px 46px;
            border-radius: 22px;
            background: linear-gradient(90deg, #65e6ce, #a7c8fd);
            color: #223254;
            box-shadow: 0 0 12px #5de8ff25, 0 3px 14px #60f0d433;
            text-decoration: none;
            transition: all 0.19s cubic-bezier(.6,1.7,.3,1.03);
            margin-top: 8px;
        }
        a.astra-btn.main:hover {
            filter: brightness(1.10) saturate(1.15);
            box-shadow: 0 0 16px 6px #65e6ce99, 0 6px 24px #60f0d488;
            transform: scale(1.035);
        }

        @media (max-width: 700px) {
            main { max-width: 97vw; padding: 12vw 5vw 12vw 5vw; border-radius: 18px; }
            .notfound-404 { font-size: 2.5rem; }
            .notfound-headline { font-size: 1.07rem; }
            .blob1 { width: 70px; height: 70px; left: -20px; top: -20px; }
            .blob2 { width: 52px; height: 52px; right: -18px; bottom: 18px; }
            .blob3 { width: 40px; height: 40px; right: 24px; top: 34px; }
            .blob4 { width: 22px; height: 22px; left: 20px; bottom: 20px; }
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
    <!-- Blobs wie Astra Landingpage -->
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="blob blob3"></div>
    <div class="blob blob4"></div>

    <!-- Icon: Astra-Style Rakete als SVG mit sanftem Glow -->
    <div class="notfound-icon">
        <svg viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="22" fill="#2a2463" />
            <path d="M24 8 L30 26 L24 22 L18 26 Z" fill="#fa62a4"/>
            <rect x="22" y="22" width="4" height="11" rx="2" fill="#66eff6"/>
            <ellipse cx="24" cy="33" rx="3" ry="2" fill="#b7f8f6"/>
            <circle cx="24" cy="18" r="2" fill="#fff"/>
        </svg>
    </div>
    <div class="notfound-404">404</div>
    <div class="notfound-headline">Seite nicht gefunden</div>
    <div class="notfound-desc">
        Die angeforderte Seite existiert nicht oder wurde verschoben.<br>
        Überprüfe die URL oder gehe zur Startseite zurück.
    </div>
    <a href="/" class="astra-btn main">Zur Startseite</a>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
<script>
    const navToggle = document.querySelector('.astra-nav-toggle');
    navToggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');

        // aria-expanded toggle
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !expanded);

        navToggle.blur(); // Fokus direkt entfernen
    });
</script>
<script>
    document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
        var toggle = dropdown.querySelector('.dropdown-toggle');
        var menu = dropdown.querySelector('.dropdown-menu');
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    });
</script>

