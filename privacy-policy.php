<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Datenschutzerklärung | Astra Bot</title>
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
                <circle cx="14%" cy="26%" r="46" fill="#65e6ce22"/>
                <circle cx="82%" cy="30%" r="64" fill="#a7c8fd22"/>
                <circle cx="52%" cy="78%" r="40" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="legal-hero-content">
            <h1>Datenschutzerklärung</h1>
            <p class="legal-hero-desc">
                Transparente Informationen zur Verarbeitung personenbezogener Daten
                gemäß DSGVO für den Discord-Bot <strong>Astra</strong> und diese Website.
            </p>

            <div class="legal-hero-meta">
                <span>🔐 DSGVO</span>
                <span>🤖 Discord Bot</span>
                <span>🌐 Website</span>
                <span>🇪🇺 EU-Recht</span>
            </div>
        </div>
    </section>

    <!-- ================= MAIN CARD ================= -->
    <section class="legal-main-card">

        <!-- Verantwortlicher -->
        <div class="legal-section">
            <h2>👤 Verantwortlicher</h2>

            <div class="legal-grid">
                <div class="legal-label">Name</div>
                <div class="legal-value">[Vorname Nachname]</div>

                <div class="legal-label">Adresse</div>
                <div class="legal-value">
                    [Straße Hausnummer]<br>
                    [PLZ Ort]<br>
                    Deutschland
                </div>

                <div class="legal-label">E-Mail</div>
                <div class="legal-value">
                    <a href="mailto:deine@email.de">deine@email.de</a>
                </div>
            </div>
        </div>

        <div class="legal-divider"></div>

        <!-- Erhobene Daten -->
        <div class="legal-section">
            <h2>📊 Erhobene Daten</h2>
            <p class="legal-text">
                Astra verarbeitet ausschließlich Daten, die für den technischen Betrieb
                und die Bereitstellung der Bot-Funktionen erforderlich sind.
            </p>

            <ul class="legal-list">
                <li>Discord User-ID</li>
                <li>Server-ID (Guild-ID)</li>
                <li>Nachrichten- & Befehls-Metadaten</li>
                <li>Konfigurations- & Systemeinstellungen</li>
            </ul>
        </div>

        <div class="legal-divider"></div>

        <!-- Zweck -->
        <div class="legal-section">
            <h2>🎯 Zweck der Verarbeitung</h2>
            <p class="legal-text">
                Sicherstellung von Funktionalität, Stabilität, Sicherheit,
                Weiterentwicklung sowie Fehleranalyse des Bots.
            </p>
        </div>

        <div class="legal-divider"></div>

        <!-- Speicher & Sicherheit -->
        <div class="legal-section legal-two-col">
            <div>
                <h2>🗑️ Speicherdauer</h2>
                <p class="legal-text">
                    Personenbezogene Daten werden nur so lange gespeichert,
                    wie dies für den jeweiligen Zweck erforderlich ist
                    oder gesetzliche Aufbewahrungspflichten bestehen.
                </p>
            </div>

            <div>
                <h2>🔒 Datensicherheit</h2>
                <p class="legal-text">
                    Es werden geeignete technische und organisatorische Maßnahmen
                    eingesetzt, um Daten vor Verlust, Missbrauch und unbefugtem Zugriff zu schützen.
                </p>
            </div>
        </div>

    </section>

    <!-- ================= SMALL CARDS ================= -->
    <section class="legal-mini-cards">

        <div class="legal-mini-card">
            <h3>🤖 Discord Bot</h3>
            <ul>
                <li>Keine privaten Nachrichten</li>
                <li>Keine Weitergabe an Dritte</li>
                <li>Keine Profilbildung</li>
            </ul>
            <span class="legal-chip">Art. 6 Abs. 1 lit. b DSGVO</span>
        </div>

        <div class="legal-mini-card">
            <h3>🌐 Website</h3>
            <ul>
                <li>IP-Adresse (anonymisiert)</li>
                <li>Datum & Uhrzeit</li>
                <li>User-Agent / Browser</li>
            </ul>
        </div>

        <div class="legal-mini-card">
            <h3>⚖️ Deine Rechte</h3>
            <ul>
                <li>Auskunft</li>
                <li>Berichtigung</li>
                <li>Löschung</li>
                <li>Widerspruch</li>
            </ul>
            <span class="legal-chip">📩 Anfrage per E-Mail</span>
        </div>

    </section>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
