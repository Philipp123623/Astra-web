<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/commands.css?v=4.0"/>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- ================= HERO ================= -->
    <section class="commands-hero">
        <div class="hero-bg">
            <span></span><span></span><span></span>
        </div>

        <div class="hero-content">
            <div class="hero-badges">
                <span class="badge mint">Prefix: / Slash Commands</span>
                <span class="badge violet">Version 2.0</span>
                <span class="badge dark">Live System</span>
            </div>

            <h1>Alle Astra Commands</h1>
            <p>
                Entdecke alle Funktionen von Astra – modern, übersichtlich,
                durchsuchbar und ständig erweitert.
            </p>

            <div class="hero-tags">
                <span class="tag green">Level & XP</span>
                <span class="tag blue">Moderation</span>
                <span class="tag yellow">Economy & Games</span>
                <span class="tag purple">Tickets & Tools</span>
                <span class="tag cyan">Fun</span>
            </div>
        </div>
    </section>

    <!-- ================= COMMANDS ================= -->
    <section class="commands-wrapper">

        <!-- SEARCH -->
        <div class="commands-search">
            <input type="text" id="commandSearch" placeholder="🔍 Command suchen…" />
        </div>

        <!-- FILTER -->
        <div class="commands-filters commands-category-buttons">
            <button data-filter="all" class="active">Alle</button>
            <button data-filter="moderation">Moderation</button>
            <button data-filter="levelsystem">Level & XP</button>
            <button data-filter="economy">Economy</button>
            <button data-filter="tickets">Tickets</button>
            <button data-filter="fun">Fun</button>
        </div>

        <!-- ACCORDION -->
        <div class="commands-accordion" id="commands-accordion">

            <!-- MODERATION -->
            <section class="command-section" data-category="moderation">
                <button class="accordion-toggle">
                    Moderation
                    <span class="chevron"></span>
                </button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/kick</strong>
                            <span class="command-badge red">Mod</span>
                        </div>
                        <p>Kickt einen User vom Server.</p>
                        <code>/kick [User] [Grund]</code>
                    </div>

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/ban</strong>
                            <span class="command-badge red">Mod</span>
                        </div>
                        <p>Bannt einen User dauerhaft.</p>
                        <code>/ban [User] [Grund]</code>
                    </div>

                </div>
            </section>

            <!-- LEVEL -->
            <section class="command-section" data-category="levelsystem">
                <button class="accordion-toggle">
                    Level & XP
                    <span class="chevron"></span>
                </button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/level</strong>
                            <span class="command-badge green">XP</span>
                        </div>
                        <p>Zeigt deinen aktuellen Level & XP.</p>
                        <code>/level</code>
                    </div>

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/top</strong>
                            <span class="command-badge green">XP</span>
                        </div>
                        <p>Leaderboard des Servers.</p>
                        <code>/top</code>
                    </div>

                </div>
            </section>

            <!-- ECONOMY -->
            <section class="command-section" data-category="economy">
                <button class="accordion-toggle">
                    Economy
                    <span class="chevron"></span>
                </button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/balance</strong>
                            <span class="command-badge yellow">Coins</span>
                        </div>
                        <p>Zeigt dein aktuelles Guthaben.</p>
                        <code>/balance</code>
                    </div>

                </div>
            </section>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<!-- ================= JS ================= -->
<script>
    const toggleAccordion = (btn) => {
        const panel = btn.nextElementSibling;
        const isOpen = btn.classList.contains('open');

        document.querySelectorAll('.accordion-panel').forEach(p => {
            p.style.maxHeight = null;
            p.style.opacity = 0;
        });
        document.querySelectorAll('.accordion-toggle').forEach(b => {
            b.classList.remove('open');
        });

        if (!isOpen) {
            panel.style.maxHeight = panel.scrollHeight + "px";
            panel.style.opacity = 1;
            btn.classList.add('open');
        }
    };

    document.querySelectorAll('.accordion-toggle').forEach(btn => {
        btn.addEventListener('click', () => toggleAccordion(btn));
    });

    document.getElementById('commandSearch').addEventListener('input', function () {
        const val = this.value.toLowerCase();

        document.querySelectorAll('.command-section').forEach(section => {
            let visible = false;
            section.querySelectorAll('.command-entry').forEach(entry => {
                const match = entry.innerText.toLowerCase().includes(val);
                entry.style.display = match ? '' : 'none';
                if (match) visible = true;
            });
            section.style.display = visible || !val ? '' : 'none';
        });
    });

    document.querySelectorAll('.commands-category-buttons button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-category-buttons button')
                .forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            document.querySelectorAll('.command-section').forEach(section => {
                section.style.display =
                    filter === 'all' || section.dataset.category === filter
                        ? ''
                        : 'none';
            });

            document.getElementById('commandSearch').value = '';
        });
    });
</script>

</body>
</html>
