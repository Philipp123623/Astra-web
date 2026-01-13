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
        <div class="status-bubbles-bg">
            <svg viewBox="0 0 800 600" preserveAspectRatio="xMidYMid slice">

                <!-- Links oben -->
                <circle cx="80"  cy="90"  r="28" fill="rgba(101,230,206,0.35)" />
                <circle cx="150" cy="160" r="18" fill="rgba(167,200,253,0.30)" />
                <circle cx="210" cy="80"  r="14" fill="rgba(124,65,238,0.28)" />

                <!-- Mitte -->
                <circle cx="360" cy="140" r="22" fill="rgba(101,230,206,0.32)" />
                <circle cx="420" cy="220" r="16" fill="rgba(255,215,153,0.30)" />
                <circle cx="480" cy="100" r="12" fill="rgba(167,200,253,0.28)" />

                <!-- Rechts oben -->
                <circle cx="620" cy="90"  r="26" fill="rgba(101,230,206,0.30)" />
                <circle cx="700" cy="160" r="18" fill="rgba(124,65,238,0.26)" />
                <circle cx="740" cy="70"  r="12" fill="rgba(255,215,153,0.28)" />

                <!-- Links unten -->
                <circle cx="120" cy="420" r="22" fill="rgba(167,200,253,0.30)" />
                <circle cx="200" cy="500" r="14" fill="rgba(101,230,206,0.28)" />

                <!-- Mitte unten -->
                <circle cx="380" cy="480" r="26" fill="rgba(124,65,238,0.25)" />
                <circle cx="450" cy="520" r="16" fill="rgba(255,215,153,0.28)" />

                <!-- Rechts unten -->
                <circle cx="620" cy="460" r="22" fill="rgba(101,230,206,0.30)" />
                <circle cx="700" cy="520" r="14" fill="rgba(167,200,253,0.26)" />

            </svg>
        </div>


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
        <input
                id="commandSearch"
                class="commands-search"
                type="text"
                placeholder="Suche nach einem Command oder Feature …"
        />

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
