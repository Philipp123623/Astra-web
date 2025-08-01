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
        /* 404 Hero Styling */
        main {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
            max-width: 980px;
            margin: 0 auto;
            background: linear-gradient(115deg, #251f5b 0%, #362897 65%, #3fd6dd 160%);
            border-radius: 38px;
            box-shadow: 0 12px 48px #5b65ff2a;
            color: #f4faff;
            position: relative;
            overflow: hidden;
        }

        /* Leicht animiertes Hintergrund-Overlay */
        main::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(101, 230, 206, 0.2), transparent 70%);
            animation: pulseGlow 8s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }
        @keyframes pulseGlow {
            0%, 100% { transform: scale(1) translate(0, 0); opacity: 0.4; }
            50% { transform: scale(1.1) translate(10%, 10%); opacity: 0.7; }
        }

        /* Inhalte vor Overlay */
        main > * {
            position: relative;
            z-index: 1;
        }

        main h1 {
            font-size: 9rem;
            font-weight: 900;
            color: #65e6ce;
            text-shadow: 0 2px 12px #60e9cbaa;
            margin: 0 0 20px 0;
            animation: flicker 3s infinite alternate;
        }
        @keyframes flicker {
            0%, 100% { opacity: 1; text-shadow: 0 2px 12px #60e9cbaa, 0 0 30px #65e6ceaa; }
            50% { opacity: 0.85; text-shadow: 0 2px 5px #60e9cb88; }
        }

        main h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #d7f3ff;
            letter-spacing: 1.2px;
            text-shadow: 0 1px 6px #251f5bbb;
        }
        main p {
            max-width: 520px;
            font-size: 1.3rem;
            color: #b7f8f6;
            line-height: 1.5;
            margin-bottom: 36px;
            text-shadow: 0 1px 6px #251f5b99;
        }

        main a.astra-btn.main {
            font-size: 1.3em;
            padding: 16px 46px;
            border-radius: 22px;
            font-weight: 900;
            box-shadow: 0 4px 30px #5de8ff80;
            text-decoration: none;
            color: #223254;
            background: linear-gradient(90deg, #60e9cb, #a7c8fd);
            position: relative;
            overflow: hidden;
            transition: filter 0.16s ease, box-shadow 0.16s ease;
        }
        main a.astra-btn.main:hover {
            filter: brightness(1.15);
            box-shadow: 0 10px 38px #60f0d4cc;
        }
        /* Glanz-Highlight-Animation auf Button */
        main a.astra-btn.main::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -75%;
            width: 50%;
            height: 200%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
            transform: skewX(-20deg);
            transition: none;
            animation: shine 2.5s infinite;
            pointer-events: none;
            z-index: 2;
        }
        main a.astra-btn.main:hover::before {
            animation-play-state: paused;
            opacity: 0;
        }
        @keyframes shine {
            0% { left: -75%; }
            100% { left: 125%; }
        }

        /* Responsive */
        @media (max-width: 900px) {
            main {
                border-radius: 24px;
                padding: 30px 16px;
                min-height: 65vh;
            }
            main h1 {
                font-size: 6rem;
            }
            main h2 {
                font-size: 2rem;
                margin-bottom: 18px;
            }
            main p {
                font-size: 1.1rem;
                max-width: 90vw;
                margin-bottom: 28px;
            }
            main a.astra-btn.main {
                font-size: 1.15em;
                padding: 14px 38px;
                border-radius: 18px;
            }
            main a.astra-btn.main::before {
                display: none; /* Kein Glanzeffekt mobil */
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
    <h1>404</h1>
    <h2>Seite nicht gefunden</h2>
    <p>
        Die angeforderte Seite existiert leider nicht oder wurde verschoben.<br>
        Überprüfe die URL oder kehre zur Startseite zurück.
    </p>
    <a href="/" class="astra-btn main">Zur Startseite</a>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>
