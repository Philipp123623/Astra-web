<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Impressum | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=4.3" />
</head>
<body>

<?php include "includes/header.php"; ?>

<main class="legal-main">

    <!-- ================= HERO ================= -->
    <section class="legal-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="24%" r="44" fill="#65e6ce22"/>
                <circle cx="86%" cy="28%" r="62" fill="#a7c8fd22"/>
                <circle cx="55%" cy="78%" r="38" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="legal-hero-content">
            <h1>Impressum</h1>
            <p class="legal-hero-desc">
                Rechtliche Angaben gemäß § 5 TMG für die Website und den Discord-Bot
                <strong>„Astra“</strong>.
            </p>

            <div class="legal-hero-meta">
                <span>📄 Rechtliches</span>
                <span>🤖 Discord Bot</span>
                <span>🌐 Website</span>
                <span>🇩🇪 Deutschland</span>
            </div>
        </div>
    </section>

    <!-- ================= MAIN CARD ================= -->
    <!-- ================= MAIN CARD ================= -->
    <section class="legal-main-card">


        <!-- ROW: Verantwortliche Person + Geltungsbereich -->
        <div class="legal-row">

            <!-- Verantwortliche Person -->
            <div class="legal-section">
                <h2>👤 Verantwortliche Person</h2>

                <div class="legal-grid">
                    <div class="legal-label">Name</div>
                    <div class="legal-value">Stüve, Philipp Lukas</div>

                    <div class="legal-label">Adresse</div>
                    <div class="legal-value">
                        Berliner Straße 25<br>
                        63477 Maintal<br>
                        Deutschland
                    </div>

                    <div class="legal-label">E-Mail</div>
                    <div class="legal-value">
                        <a href="mailto:support@astra-bot.de">support@astra-bot.de</a>
                    </div>
                </div>
            </div>

            <!-- Geltungsbereich BOX -->
            <div class="legal-side-card">
                <h3>📌 Geltungsbereich</h3>

                <p class="legal-text">
                    Dieses Impressum gilt für folgende Angebote:
                </p>

                <ul class="legal-list">
                    <li>🌐 Website <strong>astra-bot.de</strong></li>
                    <li>🤖 Discord-Bot <strong>„Astra“</strong></li>
                </ul>

                <span class="legal-chip">
                ℹ️ Nicht-kommerzielles Projekt · keine Gewinnerzielungsabsicht
            </span>
            </div>

        </div>

    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
