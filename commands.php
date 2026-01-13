<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=2.5" />
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- =========================
         HERO
         ========================= -->
    <section class="commands-hero">
        <div class="hero-glow"></div>

        <div class="commands-hero-inner">
            <div class="hero-badges">
                <span class="hero-badge mint">Prefix: / Slash Commands</span>
                <span class="hero-badge violet">Version 2.0</span>
                <span class="hero-badge dark">Live System</span>
            </div>

            <h1>Alle Astra Commands</h1>
            <p>
                Entdecke alle Funktionen von Astra – modern, übersichtlich,
                durchsuchbar und ständig erweitert.
            </p>

            <div class="hero-tags">
                <span class="tag green">Moderation</span>
                <span class="tag blue">Level & XP</span>
                <span class="tag yellow">Economy</span>
                <span class="tag purple">Tickets</span>
                <span class="tag cyan">Fun</span>
            </div>
        </div>
    </section>

    <!-- =========================
         COMMANDS PANEL
         ========================= -->
    <section class="commands-panel">

        <!-- SEARCH -->
        <div class="commands-search-wrapper">
            <input type="text" id="commandSearch" placeholder="🔍 Command suchen…" />
        </div>

        <!-- FILTER -->
        <div class="commands-filters commands-category-buttons">
            <button class="active" data-filter="all">Alle</button>
            <button data-filter="mod">Moderation</button>
            <button data-filter="level">Level</button>
            <button data-filter="eco">Economy</button>
            <button data-filter="ticket">Tickets</button>
            <button data-filter="automod">Automod</button>
            <button data-filter="settings">Settings</button>
            <button data-filter="info">Info</button>
            <button data-filter="fun">Fun</button>
            <button data-filter="gw">Gewinnspiele</button>
            <button data-filter="messages">Messages</button>
            <button data-filter="bdays">Birthdays</button>
            <button data-filter="minigames">Minigames</button>
            <button data-filter="backups">Backups</button>
        </div>

        <!-- =========================
             ACCORDION
             ========================= -->
        <div class="commands-accordion" id="commands-accordion">

            <!-- MODERATION -->
            <section class="command-section" data-category="mod">
                <button class="accordion-toggle">🛡️ Moderation</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <strong>/kick</strong>
                        <span>Kickt einen User vom Server.</span>
                        <code>/kick [User] [Grund]</code>
                    </div>
                    <div class="command-entry">
                        <strong>/ban</strong>
                        <span>Bannt einen User dauerhaft.</span>
                        <code>/ban [User] [Grund]</code>
                    </div>
                    <div class="command-entry">
                        <strong>/clear</strong>
                        <span>Löscht Nachrichten im Channel.</span>
                        <code>/clear [Anzahl]</code>
                    </div>
                </div>
            </section>

            <!-- LEVEL -->
            <section class="command-section" data-category="level">
                <button class="accordion-toggle">📈 Level & XP</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <strong>/level</strong>
                        <span>Zeigt deinen aktuellen Level & XP.</span>
                        <code>/level</code>
                    </div>
                    <div class="command-entry">
                        <strong>/top</strong>
                        <span>Leaderboard des Servers.</span>
                        <code>/top</code>
                    </div>
                </div>
            </section>

            <!-- ECONOMY -->
            <section class="command-section" data-category="eco">
                <button class="accordion-toggle">💰 Economy</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <strong>/eco balance</strong>
                        <span>Zeigt dein Guthaben.</span>
                        <code>/eco balance</code>
                    </div>
                    <div class="command-entry">
                        <strong>/eco slot</strong>
                        <span>Spiele Slots mit Coins.</span>
                        <code>/eco slot</code>
                    </div>
                </div>
            </section>

            <!-- TICKET -->
            <section class="command-section" data-category="ticket">
                <button class="accordion-toggle">🎫 Tickets</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <strong>/ticket setup</strong>
                        <span>Richtet das Ticketsystem ein.</span>
                        <code>/ticket setup</code>
                    </div>
                </div>
            </section>

            <!-- FUN -->
            <section class="command-section" data-category="fun">
                <button class="accordion-toggle">🎉 Fun</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <strong>/meme</strong>
                        <span>Sendet ein zufälliges Meme.</span>
                        <code>/meme</code>
                    </div>
                    <div class="command-entry">
                        <strong>/wanted</strong>
                        <span>Wanted-Poster erstellen.</span>
                        <code>/wanted</code>
                    </div>
                </div>
            </section>

        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>

<!-- =========================
     JAVASCRIPT
     ========================= -->
<script>
    const toggleAccordion = (btn) => {
        const panel = btn.nextElementSibling;
        const open = btn.classList.contains('open');

        document.querySelectorAll('.accordion-panel').forEach(p => {
            p.style.maxHeight = null;
            p.style.display = 'none';
        });
        document.querySelectorAll('.accordion-toggle').forEach(b => b.classList.remove('open'));

        if (!open) {
            panel.style.display = 'block';
            panel.style.maxHeight = panel.scrollHeight + "px";
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
        });
    });

    document.querySelectorAll('.commands-category-buttons button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-category-buttons button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;

            document.querySelectorAll('.command-section').forEach(section => {
                section.style.display = (filter === 'all' || section.dataset.category === filter) ? '' : 'none';
            });

            document.getElementById('commandSearch').value = '';
        });
    });
</script>

</body>
</html>
