<?php include "includes/header.php"; ?>
<script>document.body.classList.add('error-layout');</script>
<main class="error-page">

    <section class="error-hero-card">
        <div class="error-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="18%" cy="22%" r="42" fill="#65e6ce33"/>
                <circle cx="85%" cy="30%" r="70" fill="#a7c8fd22"/>
                <circle cx="55%" cy="75%" r="48" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="28" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="error-hero-content">
            <span class="error-code">404</span>
            <h1>Seite nicht gefunden</h1>
            <p>
                Die Seite, die du suchst, existiert nicht<br>
                oder wurde verschoben.
            </p>

            <div class="error-actions">
                <a href="/" class="astra-btn main">Zur Startseite</a>
                <a href="/support" class="astra-btn outline">Support</a>
            </div>
        </div>
    </section>

</main>

<?php include "includes/footer.php"; ?>

