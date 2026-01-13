<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=3.3"/>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- =========================
         HERO / INFO
         ========================= -->
    <section class="commands-hero">

        <div class="commands-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="14%" cy="22%" r="48" fill="#65e6ce22"/>
                <circle cx="82%" cy="18%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="82%" r="56" fill="#7c41ee22"/>
                <circle cx="92%" cy="70%" r="32" fill="#60e9cb22"/>
            </svg>
        </div>

        <div class="commands-hero-inner">
            <div class="commands-badges">
                <span class="badge mint">Prefix: / Slash Commands</span>
                <span class="badge violet">Version 2.0</span>
                <span class="badge dark">Live System</span>
            </div>

            <h1>Alle Astra Commands</h1>
            <p>
                Entdecke alle Funktionen von Astra – übersichtlich sortiert,
                durchsuchbar und ständig erweitert.
            </p>

            <div class="commands-tags">
                <span class="tag green">Level & XP</span>
                <span class="tag blue">Moderation</span>
                <span class="tag yellow">Economy & Games</span>
                <span class="tag purple">Tickets & Tools</span>
                <span class="tag cyan">Fun</span>
            </div>
        </div>
    </section>

    <!-- =========================
         COMMANDS CARD
         ========================= -->
    <section class="commands-card">

        <!-- Suche -->
        <div class="commands-search">
            <input type="text" id="commandSearch" placeholder="🔍 Command suchen…" />
        </div>

        <!-- Filter -->
        <div class="commands-filters commands-category-buttons">
            <button data-filter="all" class="active">Alle</button>
            <button data-filter="moderation">Moderation</button>
            <button data-filter="levelsystem">Level & XP</button>
            <button data-filter="economy">Economy</button>
            <button data-filter="tickets">Tickets</button>
            <button data-filter="fun">Fun</button>
        </div>

        <!-- Accordion -->
        <div class="commands-accordion" id="commands-accordion">

            <!-- MODERATION -->
            <section class="command-section" data-category="moderation">
                <button class="accordion-toggle">Moderation</button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/kick</strong>
                            <span class="command-badge red">Mod</span>
                        </div>
                        <span>Kickt einen User vom Server.</span>
                        <code>/kick [User] [Grund]</code>
                    </div>

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/ban</strong>
                            <span class="command-badge red">Mod</span>
                        </div>
                        <span>Bannt einen User dauerhaft.</span>
                        <code>/ban [User] [Grund]</code>
                    </div>

                </div>
            </section>

            <!-- LEVEL -->
            <section class="command-section" data-category="levelsystem">
                <button class="accordion-toggle">Level & XP</button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/level</strong>
                            <span class="command-badge green">XP</span>
                        </div>
                        <span>Zeigt deinen aktuellen Level & XP.</span>
                        <code>/level</code>
                    </div>

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/top</strong>
                            <span class="command-badge green">XP</span>
                        </div>
                        <span>Leaderboard des Servers.</span>
                        <code>/top</code>
                    </div>

                </div>
            </section>

            <!-- ECONOMY -->
            <section class="command-section" data-category="economy">
                <button class="accordion-toggle">Economy</button>
                <div class="accordion-panel">

                    <div class="command-entry">
                        <div class="command-head">
                            <strong>/balance</strong>
                            <span class="command-badge yellow">Coins</span>
                        </div>
                        <span>Zeigt dein aktuelles Guthaben.</span>
                        <code>/balance</code>
                    </div>

                </div>
            </section>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<!-- =========================
     JAVASCRIPT (VOLLSTÄNDIG)
     ========================= -->
<script>
    const toggleAccordion = (btn) => {
        const panel = btn.nextElementSibling;
        const isOpen = btn.classList.contains('open');

        if (isOpen) {
            panel.style.display = 'none';
            panel.style.maxHeight = null;
            btn.classList.remove('open');
        } else {
            document.querySelectorAll('.accordion-panel').forEach(p => {
                p.style.display = 'none';
                p.style.maxHeight = null;
            });
            document.querySelectorAll('.accordion-toggle').forEach(b => b.classList.remove('open'));

            panel.style.display = 'block';
            panel.style.maxHeight = panel.scrollHeight + 'px';
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

            section.style.display = (visible || !val) ? '' : 'none';

            const panel = section.querySelector('.accordion-panel');
            const toggleBtn = section.querySelector('.accordion-toggle');

            if (visible && val) {
                panel.style.display = 'block';
                panel.style.maxHeight = panel.scrollHeight + 'px';
                toggleBtn.classList.add('open');
            } else {
                panel.style.display = 'none';
                panel.style.maxHeight = null;
                toggleBtn.classList.remove('open');
            }
        });
    });

    document.querySelectorAll('.commands-category-buttons button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-category-buttons button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');

            document.querySelectorAll('.command-section').forEach(section => {
                const cat = section.getAttribute('data-category');
                section.style.display = (filter === 'all' || filter === cat) ? '' : 'none';

                const panel = section.querySelector('.accordion-panel');
                const toggleBtn = section.querySelector('.accordion-toggle');

                panel.style.display = 'none';
                panel.style.maxHeight = null;
                toggleBtn.classList.remove('open');
            });

            document.getElementById('commandSearch').value = '';
        });
    });
</script>

<script>
    const navToggle = document.querySelector('.astra-nav-toggle');
    navToggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !expanded);
        navToggle.blur();
    });
</script>

</body>
</html>
