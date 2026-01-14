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
                </div>

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
                data-placeholder="Suche nach einem Command oder Feature …"
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
                        <div class="cmd-name">/kick</div>
                        <div class="cmd-desc">Kickt einen User vom Server</div>
                        <div class="cmd-usage">/kick [User] [Grund]</div>
                    </div>
                    <div class="command-item">
                        <div class="cmd-name">/ban</div>
                        <div class="cmd-desc">Bannt einen User dauerhaft</div>
                        <div class="cmd-usage">/ban [User] [Grund]</div>
                    </div>
                    <div class="command-item">
                        <div class="cmd-name">/clear</div>
                        <div class="cmd-desc">Löscht Nachrichten im Channel</div>
                        <div class="cmd-usage">/clear [Anzahl]</div>
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
                        <div class="cmd-name">/level</div>
                        <div class="cmd-desc">Zeigt dein aktuelles Level</div>
                        <div class="cmd-usage">/level</div>
                    </div>
                    <div class="command-item">
                        <div class="cmd-name">/top</div>
                        <div class="cmd-desc">Server Rangliste</div>
                        <div class="cmd-usage">/top</div>
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
                        <div class="cmd-name">/meme</div>
                        <div class="cmd-desc">Zufälliges Meme</div>
                        <div class="cmd-usage">/meme</div>
                    </div>
                    <div class="command-item">
                        <div class="cmd-name">/wanted</div>
                        <div class="cmd-desc">Wanted-Poster erstellen</div>
                        <div class="cmd-usage">/wanted</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<script>
    /* ACCORDION – SINGLE OPEN */
    document.querySelectorAll('.command-category-header').forEach(btn => {
        btn.addEventListener('click', () => {
            const current = btn.parentElement;

            document.querySelectorAll('.command-category').forEach(cat => {
                if (cat !== current) {
                    cat.classList.remove('open');
                }
            });

            current.classList.toggle('open');
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

    /* SEARCH – mit Kategorie-Logik */
    document.getElementById('commandSearch').addEventListener('input', e => {
    const val = e.target.value.toLowerCase().trim();

    document.querySelectorAll('.command-category').forEach(cat => {
    let hasMatch = false;

    cat.querySelectorAll('.command-item').forEach(cmd => {
    const match = cmd.innerText.toLowerCase().includes(val);
    cmd.style.display = match ? '' : 'none';
    if (match) hasMatch = true;
    });

        if (val === '') {
        // Reset-Zustand
        cat.style.display = '';
        cat.classList.remove('open');
        cat.querySelectorAll('.command-item').forEach(cmd => cmd.style.display = '');
    } else {
        // Suchmodus
        cat.style.display = hasMatch ? '' : 'none';
        cat.classList.toggle('open', hasMatch);
    }
    });
    });

    const searchInput = document.getElementById('commandSearch');
    const placeholderText = searchInput.dataset.placeholder;
    let typingInterval = null;

    /* Fokus: Placeholder sofort weg */
    searchInput.addEventListener('focus', () => {
        searchInput.classList.add('hide-placeholder');
        clearInterval(typingInterval);
    });

    /* Blur: Placeholder tippen, wenn leer */
    searchInput.addEventListener('blur', () => {
        if (searchInput.value.trim() !== '') return;

        clearInterval(typingInterval);
        searchInput.classList.remove('hide-placeholder');

        let i = 0;
        searchInput.placeholder = '';

        typingInterval = setInterval(() => {
            if (i >= placeholderText.length) {
                clearInterval(typingInterval);
                return;
            }

            searchInput.placeholder += placeholderText.charAt(i);
            i++;
        }, 35);
    });



</script>
