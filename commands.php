<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=2.0" />
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
    <h1 class="headline">Astra Bot – Command Übersicht</h1>

    <!-- Erklärung oben -->
    <section class="commands-intro">
        <p>Entdecke alle Befehle von Astra, deinem vielseitigen Discord-Bot.
            Nutze die Suche, um schnell den passenden Command zu finden!</p>
    </section>

    <!-- Suchleiste -->
    <div class="command-searchbar">
        <input type="text" id="commandSearch" placeholder="🔍 Command suchen..." />
    </div>

    <!-- Kategorie Buttons -->
    <div class="commands-category-buttons" style="max-width: 950px; margin: 0 auto 25px auto; text-align:center;">
        <button data-filter="all" class="active">Alle</button>
        <button data-filter="moderation">Moderation</button>
        <button data-filter="levelsystem">Level & XP</button>
        <button data-filter="economy">Economy & Games</button>
        <button data-filter="tickets">Tickets & Tools</button>
        <button data-filter="fun">Fun</button>
    </div>

    <!-- Commands Container -->
    <div id="commands-accordion" style="max-width: 950px; margin: 0 auto;">
        <!-- Kategorie Moderation -->
        <section class="command-section" data-category="moderation">
            <button class="accordion-toggle" type="button" aria-expanded="false">Moderation</button>
            <div class="accordion-panel">
                <div class="command-entry">
                    <div class="command-name">/kick</div>
                    <div class="command-info">
                        <div class="command-desc">Kickt einen User vom Server.</div>
                        <div><b>Usage:</b> <code>/kick [User] [Grund]</code></div>
                        <div><b>Berechtigung:</b> Kick Members</div>
                    </div>
                </div>
                <div class="command-entry">
                    <div class="command-name">/ban</div>
                    <div class="command-info">
                        <div class="command-desc">Bannt einen User vom Server.</div>
                        <div><b>Usage:</b> <code>/ban [User] [Grund]</code></div>
                        <div><b>Berechtigung:</b> Ban Members</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategorie Levelsystem -->
        <section class="command-section" data-category="levelsystem">
            <button class="accordion-toggle" type="button" aria-expanded="false">Levelsystem</button>
            <div class="accordion-panel">
                <div class="command-entry">
                    <div class="command-name">/level</div>
                    <div class="command-info">
                        <div class="command-desc">Zeigt deinen aktuellen Level & XP.</div>
                        <div><b>Usage:</b> <code>/level</code></div>
                    </div>
                </div>
                <div class="command-entry">
                    <div class="command-name">/top</div>
                    <div class="command-info">
                        <div class="command-desc">Zeigt das Leaderboard des Servers.</div>
                        <div><b>Usage:</b> <code>/top</code></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategorie Economy & Games -->
        <section class="command-section" data-category="economy">
            <button class="accordion-toggle" type="button" aria-expanded="false">Economy & Games</button>
            <div class="accordion-panel">
                <div class="command-entry">
                    <div class="command-name">/balance</div>
                    <div class="command-info">
                        <div class="command-desc">Zeigt dein aktuelles Guthaben.</div>
                        <div><b>Usage:</b> <code>/balance</code></div>
                    </div>
                </div>
                <div class="command-entry">
                    <div class="command-name">/slot</div>
                    <div class="command-info">
                        <div class="command-desc">Slot-Game für Astra-Coins.</div>
                        <div><b>Usage:</b> <code>/slot [Einsatz]</code></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategorie Tickets & Tools -->
        <section class="command-section" data-category="tickets">
            <button class="accordion-toggle" type="button" aria-expanded="false">Tickets & Tools</button>
            <div class="accordion-panel">
                <div class="command-entry">
                    <div class="command-name">/ticket</div>
                    <div class="command-info">
                        <div class="command-desc">Öffnet ein neues Support-Ticket.</div>
                        <div><b>Usage:</b> <code>/ticket</code></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kategorie Fun -->
        <section class="command-section" data-category="fun">
            <button class="accordion-toggle" type="button" aria-expanded="false">Fun</button>
            <div class="accordion-panel">
                <div class="command-entry">
                    <div class="command-name">/meme</div>
                    <div class="command-info">
                        <div class="command-desc">Sendet ein zufälliges Meme.</div>
                        <div><b>Usage:</b> <code>/meme</code></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    // Accordion Funktion mit Animation
    const toggleAccordion = (btn) => {
        const panel = btn.nextElementSibling;
        const isOpen = btn.classList.contains('open');

        if (isOpen) {
            panel.style.maxHeight = null;
            panel.style.display = 'none';
            btn.setAttribute('aria-expanded', 'false');
            btn.classList.remove('open');
        } else {
            // Alle anderen schließen
            document.querySelectorAll('.accordion-panel').forEach(p => {
                p.style.maxHeight = null;
                p.style.display = 'none';
            });
            document.querySelectorAll('.accordion-toggle').forEach(b => {
                b.setAttribute('aria-expanded', 'false');
                b.classList.remove('open');
            });

            panel.style.display = 'block';
            panel.style.maxHeight = panel.scrollHeight + "px";
            btn.setAttribute('aria-expanded', 'true');
            btn.classList.add('open');
        }
    };

    document.querySelectorAll('.accordion-toggle').forEach(btn => {
        btn.addEventListener('click', () => toggleAccordion(btn));
    });

    // Command Suche
    document.getElementById('commandSearch').addEventListener('input', function () {
        const val = this.value.toLowerCase();

        document.querySelectorAll('.command-section').forEach(section => {
            let visible = false;

            section.querySelectorAll('.command-entry').forEach(entry => {
                const match = entry.innerText.toLowerCase().includes(val);
                entry.style.display = match ? '' : 'none';
                if (match) visible = true;
            });

            // Sektion ein- oder ausblenden
            section.style.display = (visible || !val) ? '' : 'none';

            const panel = section.querySelector('.accordion-panel');
            const toggleBtn = section.querySelector('.accordion-toggle');

            if (visible && val) {
                panel.style.display = 'block';
                panel.style.maxHeight = panel.scrollHeight + 'px';
                toggleBtn.setAttribute('aria-expanded', 'true');
                toggleBtn.classList.add('open');
            } else if (!val) {
                // Suche leer → alles zu
                panel.style.display = 'none';
                panel.style.maxHeight = null;
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.classList.remove('open');
            } else {
                // Suche aktiv aber kein Treffer → alles zu
                panel.style.display = 'none';
                panel.style.maxHeight = null;
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.classList.remove('open');
            }
        });
    });

    // Kategorie Buttons filter
    document.querySelectorAll('.commands-category-buttons button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-category-buttons button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.getAttribute('data-filter');

            document.querySelectorAll('.command-section').forEach(section => {
                const cat = section.getAttribute('data-category');

                if (filter === 'all' || filter === cat) {
                    section.style.display = '';
                } else {
                    section.style.display = 'none';
                }

                // Panels schließen nur, wenn die Sektion nicht sichtbar ist
                const panel = section.querySelector('.accordion-panel');
                const toggleBtn = section.querySelector('.accordion-toggle');

                if (section.style.display === 'none') {
                    panel.style.display = 'none';
                    panel.style.maxHeight = null;
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    toggleBtn.classList.remove('open');
                }
            });

            // Suche zurücksetzen bei Filter
            const searchInput = document.getElementById('commandSearch');
            if (searchInput.value) {
                searchInput.value = '';
            }
        });
    });
</script>

</body>
</html>
