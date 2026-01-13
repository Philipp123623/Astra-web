<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=2.5" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- HERO -->
    <section class="commands-hero-card">
        <div class="bubbles-bg"></div>

        <div class="commands-hero-content">
            <div class="commands-hero-text">
                <div class="astra-label-row">
                    <span class="astra-label green">Slash Commands</span>
                    <span class="astra-label blue">Live System</span>
                    <span class="astra-label yellow">v2.0</span>
                </div>

                <h1>Astra Commands</h1>
                <p class="astra-desc">
                    Alle verfügbaren Commands von Astra – übersichtlich,
                    durchsuchbar und ständig erweitert.
                </p>

                <div class="astra-badges-row">
                    <span class="astra-badge mint">Moderation</span>
                    <span class="astra-badge blue">Level & XP</span>
                    <span class="astra-badge violet">Economy</span>
                    <span class="astra-badge yellow">Fun</span>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMANDS PANEL -->
    <section class="commands-panel-card">

        <!-- SEARCH -->
        <input id="commandSearch" class="commands-search"
               placeholder="🔍 Suche nach einem Command oder Feature …">

        <!-- FILTERS -->
        <div class="commands-filters">
            <button class="active" data-filter="all">Alle</button>
            <button data-filter="mod">Moderation</button>
            <button data-filter="level">Level & XP</button>
            <button data-filter="eco">Economy</button>
            <button data-filter="fun">Fun</button>
        </div>

        <!-- ACCORDION -->
        <div class="commands-accordion">

            <!-- MODERATION -->
            <div class="command-category" data-category="mod">
                <button class="command-category-header">
                    🛡️ Moderation
                    <span>3 Commands</span>
                </button>
                <div class="command-category-body">
                    <div class="command-item">
                        <strong>/kick</strong>
                        <p>Kickt einen User vom Server</p>
                        <code>/kick [User] [Grund]</code>
                    </div>
                    <div class="command-item">
                        <strong>/ban</strong>
                        <p>Bannt einen User dauerhaft</p>
                        <code>/ban [User] [Grund]</code>
                    </div>
                    <div class="command-item">
                        <strong>/clear</strong>
                        <p>Löscht Nachrichten im Channel</p>
                        <code>/clear [Anzahl]</code>
                    </div>
                </div>
            </div>

            <!-- LEVEL -->
            <div class="command-category" data-category="level">
                <button class="command-category-header">
                    📈 Level & XP
                    <span>2 Commands</span>
                </button>
                <div class="command-category-body">
                    <div class="command-item">
                        <strong>/level</strong>
                        <p>Zeigt dein aktuelles Level</p>
                        <code>/level</code>
                    </div>
                    <div class="command-item">
                        <strong>/top</strong>
                        <p>Server Rangliste</p>
                        <code>/top</code>
                    </div>
                </div>
            </div>

            <!-- FUN -->
            <div class="command-category" data-category="fun">
                <button class="command-category-header">
                    🎉 Fun
                    <span>2 Commands</span>
                </button>
                <div class="command-category-body">
                    <div class="command-item">
                        <strong>/meme</strong>
                        <p>Zufälliges Meme</p>
                        <code>/meme</code>
                    </div>
                    <div class="command-item">
                        <strong>/wanted</strong>
                        <p>Wanted-Poster erstellen</p>
                        <code>/wanted</code>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<script>
    /* Accordion */
    document.querySelectorAll('.command-category-header').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.parentElement.classList.toggle('open');
        });
    });

    /* Filter */
    document.querySelectorAll('.commands-filters button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-filters button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const f = btn.dataset.filter;
            document.querySelectorAll('.command-category').forEach(cat => {
                cat.style.display = (f === 'all' || cat.dataset.category === f) ? '' : 'none';
            });
        });
    });

    /* Search */
    document.getElementById('commandSearch').addEventListener('input', e => {
        const val = e.target.value.toLowerCase();
        document.querySelectorAll('.command-item').forEach(cmd => {
            cmd.style.display = cmd.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
