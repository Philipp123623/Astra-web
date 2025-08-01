<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=2.0">
</head>
<body>
<?php include 'includes/header.php'; ?>

<main>
    <h1 class="headline">Astra Bot – Command Übersicht</h1>

    <!-- Suchleiste -->
    <div class="command-searchbar">
        <input type="text" id="commandSearch" placeholder="🔍 Command suchen...">
    </div>

    <!-- Command Accordion Container -->
    <div id="commands-accordion">

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

<!-- Accordion + Suche Script -->
<script>
    console.log('Script läuft');
    console.log('Buttons gefunden:', document.querySelectorAll('.accordion-toggle').length);
    // Accordion Funktion mit Animation
    const toggleAccordion = (btn) => {
        const panel = btn.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            panel.style.display = 'none';  // verstecken
            btn.setAttribute('aria-expanded', 'false');
        } else {
            // Alle anderen schließen
            document.querySelectorAll('.accordion-panel').forEach(p => {
                p.style.maxHeight = null;
                p.style.display = 'none';
            });
            document.querySelectorAll('.accordion-toggle').forEach(b => b.setAttribute('aria-expanded', 'false'));

            panel.style.display = 'block'; // anzeigen
            panel.style.maxHeight = panel.scrollHeight + "px";
            btn.setAttribute('aria-expanded', 'true');
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
            // Kategorie nur anzeigen wenn Treffer oder Suche leer
            section.style.display = (visible || !val) ? '' : 'none';
            // Panel öffnen wenn Treffer sonst zu
            section.querySelector('.accordion-panel').style.maxHeight = (visible && val) ? section.querySelector('.accordion-panel').scrollHeight + "px" : null;
            section.querySelector('.accordion-toggle').setAttribute('aria-expanded', (visible && val) ? 'true' : 'false');
        });
    });
</script>
</body>
</html>
