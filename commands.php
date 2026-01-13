<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Astra | Commands</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css?v=2.5"/>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>

    <!-- =========================
         MINI HERO / INFO BEREICH
         ========================= -->
    <section class="commands-hero-mini">

        <div class="commands-bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="42" fill="#65e6ce33"/>
                <circle cx="88%" cy="22%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="78%" r="52" fill="#7c41ee22"/>
            </svg>
        </div>

        <div class="commands-hero-content">

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

        </div>
    </section>

    <!-- ABSTAND -->
    <div class="commands-separator"></div>

    <!-- =========================
         COMMANDS CONTENT
         ========================= -->
    <section class="commands-content">

        <div class="command-searchbar">
            <input type="text" id="commandSearch" placeholder="🔍 Command suchen..." />
        </div>

        <div class="commands-category-buttons">
            <button data-filter="all" class="active">Alle</button>
            <button data-filter="moderation">Moderation</button>
            <button data-filter="levelsystem">Level & XP</button>
            <button data-filter="economy">Economy & Games</button>
            <button data-filter="tickets">Tickets & Tools</button>
            <button data-filter="fun">Fun</button>
        </div>

        <div id="commands-accordion">

            <section class="command-section" data-category="moderation">
                <button class="accordion-toggle">Moderation</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <div class="command-name">/kick</div>
                        <div class="command-info">
                            <div class="command-desc">Kickt einen User vom Server.</div>
                            <div><b>Usage:</b> <code>/kick [User] [Grund]</code></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="command-section" data-category="levelsystem">
                <button class="accordion-toggle">Levelsystem</button>
                <div class="accordion-panel">
                    <div class="command-entry">
                        <div class="command-name">/level</div>
                        <div class="command-info">
                            <div class="command-desc">Zeigt deinen Level.</div>
                            <div><b>Usage:</b> <code>/level</code></div>
                        </div>
                    </div>
                </div>
            </section>

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
