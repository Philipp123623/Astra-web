<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=2.4"/>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>

    <!-- HERO WRAPPER -->
    <section class="commands-hero-card">

        <!-- BUBBLES -->
        <div class="commands-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="42" fill="#65e6ce33"/>
                <circle cx="88%" cy="22%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="78%" r="52" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="26" fill="#60e9cb22"/>
            </svg>
        </div>

        <!-- CONTENT -->
        <div class="commands-hero-content">

            <!-- Command Info-Card -->
            <div class="commands-info-card">
                <div class="commands-info-row">
                    <span class="info-badge cyan">Prefix: / (Slash Commands)</span>
                    <span class="info-badge purple">Version: 2.0</span>
                </div>

                <div class="commands-info-desc">
                    <b>Entdecke alle Befehle von Astra, deinem vielseitigen Discord-Bot.</b><br>
                    Nutze die Suche, um schnell den passenden Command zu finden!
                </div>

                <div class="commands-label-row">
                    <span class="astra-label green">Level & XP</span>
                    <span class="astra-label blue">Moderation</span>
                    <span class="astra-label yellow">Economy & Games</span>
                    <span class="astra-label purple">Tickets & Tools</span>
                </div>
            </div>

            <!-- Suchleiste -->
            <div class="command-searchbar">
                <input type="text" id="commandSearch" placeholder="🔍 Command suchen..." />
            </div>

            <!-- Kategorie Buttons -->
            <div class="commands-category-buttons">
                <button data-filter="all" class="active">Alle</button>
                <button data-filter="moderation">Moderation</button>
                <button data-filter="levelsystem">Level & XP</button>
                <button data-filter="economy">Economy & Games</button>
                <button data-filter="tickets">Tickets & Tools</button>
                <button data-filter="fun">Fun</button>
            </div>

            <!-- Commands Accordion -->
            <div id="commands-accordion">

                <section class="command-section" data-category="moderation">
                    <button class="accordion-toggle" type="button">Moderation</button>
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

                <section class="command-section" data-category="levelsystem">
                    <button class="accordion-toggle" type="button">Levelsystem</button>
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

                <section class="command-section" data-category="economy">
                    <button class="accordion-toggle" type="button">Economy & Games</button>
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

                <section class="command-section" data-category="tickets">
                    <button class="accordion-toggle" type="button">Tickets & Tools</button>
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

                <section class="command-section" data-category="fun">
                    <button class="accordion-toggle" type="button">Fun</button>
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

        </div>
    </section>

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
<script>
    const navToggle = document.querySelector('.astra-nav-toggle');
    navToggle.addEventListener('click', () => {
        document.body.classList.toggle('nav-open');

        // aria-expanded toggle
        const expanded = navToggle.getAttribute('aria-expanded') === 'true';
        navToggle.setAttribute('aria-expanded', !expanded);

        navToggle.blur(); // Fokus direkt entfernen
    });
</script>
</body>
</html>
