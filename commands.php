<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=5"/>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>

    <!-- ================= HERO ================= -->
    <section class="commands-hero-card">
        <div class="bubbles-bg"></div>

        <div class="commands-hero-content">
            <div class="astra-label-row">
                <span class="astra-label green">Slash Commands</span>
                <span class="astra-label blue">Live System</span>
                <span class="astra-label yellow">v2.0</span>
            </div>

            <h1>Astra Commands</h1>
            <p class="astra-desc">
                Alle verfügbaren Commands von Astra – übersichtlich, durchsuchbar und ständig erweitert.
            </p>

            <div class="astra-badges-row">
                <span class="astra-badge mint">Moderation</span>
                <span class="astra-badge blue">Level & XP</span>
                <span class="astra-badge violet">Economy</span>
                <span class="astra-badge yellow">Fun</span>
            </div>
        </div>
    </section>

    <!-- ================= PANEL ================= -->
    <section class="commands-panel-card">

        <!-- SEARCH -->
        <div class="commands-search-wrapper">
            <input
                    type="text"
                    id="commandSearch"
                    class="commands-search"
                    placeholder="🔍 Suche nach einem Command oder Feature …"
            />
        </div>

        <!-- FILTERS -->
        <div class="commands-filters">
            <button class="active" data-filter="all">Alle</button>
            <button data-filter="mod">Moderation</button>
            <button data-filter="level">Level & XP</button>
            <button data-filter="eco">Economy</button>
            <button data-filter="fun">Fun</button>
        </div>

        <!-- ================= MODERATION ================= -->
        <div class="command-category" data-category="mod">
            <button class="command-category-header">
                🛡️ Moderation
                <span>3 Commands</span>
            </button>

            <div class="command-category-body">
                <div class="command-row">
                    <div class="cmd-name">/kick</div>
                    <div class="cmd-desc">Kickt einen User vom Server</div>
                    <div class="cmd-usage">/kick [User] [Grund]</div>
                </div>

                <div class="command-row">
                    <div class="cmd-name">/ban</div>
                    <div class="cmd-desc">Bannt einen User dauerhaft</div>
                    <div class="cmd-usage">/ban [User] [Grund]</div>
                </div>

                <div class="command-row">
                    <div class="cmd-name">/clear</div>
                    <div class="cmd-desc">Löscht Nachrichten im Channel</div>
                    <div class="cmd-usage">/clear [Anzahl]</div>
                </div>
            </div>
        </div>

        <!-- ================= LEVEL ================= -->
        <div class="command-category" data-category="level">
            <button class="command-category-header">
                📈 Level & XP
                <span>2 Commands</span>
            </button>

            <div class="command-category-body">
                <div class="command-row">
                    <div class="cmd-name">/level</div>
                    <div class="cmd-desc">Zeigt dein aktuelles Level</div>
                    <div class="cmd-usage">/level</div>
                </div>

                <div class="command-row">
                    <div class="cmd-name">/top</div>
                    <div class="cmd-desc">Server Rangliste</div>
                    <div class="cmd-usage">/top</div>
                </div>
            </div>
        </div>

        <!-- ================= FUN ================= -->
        <div class="command-category" data-category="fun">
            <button class="command-category-header">
                🎉 Fun
                <span>2 Commands</span>
            </button>

            <div class="command-category-body">
                <div class="command-row">
                    <div class="cmd-name">/meme</div>
                    <div class="cmd-desc">Zufälliges Meme</div>
                    <div class="cmd-usage">/meme</div>
                </div>

                <div class="command-row">
                    <div class="cmd-name">/wanted</div>
                    <div class="cmd-desc">Wanted-Poster erstellen</div>
                    <div class="cmd-usage">/wanted</div>
                </div>
            </div>
        </div>

    </section>

</main>

<?php include 'includes/footer.php'; ?>

<!-- ================= FULL JAVASCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const searchInput = document.getElementById('commandSearch');
        const filterButtons = document.querySelectorAll('.commands-filters button');
        const categories = document.querySelectorAll('.command-category');

        let activeFilter = 'all';

        /* ACCORDION */
        document.querySelectorAll('.command-category-header').forEach(header => {
            header.addEventListener('click', () => {
                header.parentElement.classList.toggle('open');
            });
        });

        /* FILTER */
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeFilter = btn.dataset.filter;
                applyFilters();
            });
        });

        /* SEARCH */
        searchInput.addEventListener('input', applyFilters);

        function applyFilters() {
            const query = searchInput.value.toLowerCase();

            categories.forEach(category => {
                const type = category.dataset.category;
                let visible = false;

                if (activeFilter !== 'all' && type !== activeFilter) {
                    category.style.display = 'none';
                    return;
                }

                category.style.display = '';

                category.querySelectorAll('.command-row').forEach(row => {
                    const match = row.innerText.toLowerCase().includes(query);
                    row.style.display = match ? 'grid' : 'none';
                    if (match) visible = true;
                });

                if (!visible && query !== '') {
                    category.style.display = 'none';
                }
            });
        }

    });
</script>

</body>
</html>
