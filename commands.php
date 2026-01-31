<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=2.9" />
</head>
<body>

<!-- ASTRA LOADER -->
<div id="astra-loader">
    <div class="astra-loader-bg"></div>

    <!-- Floating bubbles -->
    <div class="astra-loader-bubbles">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="astra-loader-core">
        <div class="astra-loader-ring"></div>
        <img src="/public/favicon_transparent.png" class="astra-loader-logo" alt="Astra">
        <span class="astra-loader-text">Booting Astra</span>
    </div>
</div>


<?php include 'includes/header.php'; ?>

<main class="commands-main">

    <!-- HERO -->
    <section class="commands-hero-card">

        <!-- BUBBLES -->
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="12%" cy="18%" r="42" fill="#65e6ce33"/>
                <circle cx="88%" cy="22%" r="64" fill="#a7c8fd22"/>
                <circle cx="50%" cy="78%" r="52" fill="#7c41ee22"/>
                <circle cx="92%" cy="82%" r="26" fill="#60e9cb22"/>
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
                data-placeholder="Suche nach einem Command oder Feature …"
        />

        <!-- FILTERS -->
        <div class="commands-filters">
            <button class="active" data-filter="all">Alle</button>
            <button data-filter="Mod">Moderation</button>
            <button data-filter="Level">Level</button>
            <button data-filter="Eco">Economy</button>
            <button data-filter="Fun">Fun</button>
            <button data-filter="Settings">Settings</button>
            <button data-filter="Info">Info</button>
        </div>

        <!-- ACCORDION (DYNAMIC) -->
        <div class="commands-accordion" id="commandsAccordion"></div>

    </section>

</main>

<?php include 'includes/footer.php'; ?>

<script>
    (function () {

        const loader = document.getElementById('astra-loader');
        const KEY = 'astra_loader_shown';

        // Nur beim ersten Besuch
        if (sessionStorage.getItem(KEY)) {
            loader.remove();
            return;
        }

        sessionStorage.setItem(KEY, 'true');

        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hide');
                setTimeout(() => loader.remove(), 500);
            }, 600); // fühlt sich smooth an, nicht künstlich
        });

    })();
</script>


<script>
    /* ============================
       LOAD JSON & RENDER
    ============================ */
    fetch('/json/commands.json')
        .then(res => res.json())
        .then(data => renderCommands(data));

    function renderCommands(data) {
        const accordion = document.getElementById('commandsAccordion');

        Object.entries(data).forEach(([category, catData]) => {
            const count = catData.commands.length;

            const categoryEl = document.createElement('div');
            categoryEl.className = 'command-category';
            categoryEl.dataset.category = category;

            categoryEl.innerHTML = `
            <button class="command-category-header">
                ${getIcon(category)} ${category}
                <span>${count} Commands</span>
            </button>
            <div class="command-category-body">
                ${catData.commands.map(cmd => `
                    <div class="command-item">
                        <div class="cmd-name">${cmd.name}</div>
                        <div class="cmd-desc">${cmd.description}</div>
                        ${
                            cmd.usage && cmd.usage.trim() !== cmd.name.trim()
                                ? `<div class="cmd-usage">${cmd.usage}</div>`
                                : ''
                        }

                    </div>
                `).join('')}
            </div>
        `;

            accordion.appendChild(categoryEl);
        });

        initAccordion();
    }

    /* ============================
       ICONS
    ============================ */
    function getIcon(cat) {
        const icons = {
            Moderation: '🛡️',
            Levelsystem: '📈',
            Economy: '💰',
            Fun: '🎉',
            Einstellungen: '⚙️',
            Informationen: 'ℹ️',
            Gewinnspiele: '🎁',
            Ticket: '🎫',
            Automoderation: '🤖',
            Nachrichten: '💬',
            Minigames: '🕹️',
            Backups: '🗄️',
            Geburtstage: '🎂'
        };
        return icons[cat] || '📘';
    }

    /* ============================
       ACCORDION – SINGLE OPEN
    ============================ */
    function initAccordion() {
        document.querySelectorAll('.command-category-header').forEach(btn => {
            btn.addEventListener('click', () => {
                const current = btn.parentElement;

                document.querySelectorAll('.command-category').forEach(cat => {
                    if (cat !== current) cat.classList.remove('open');
                });

                current.classList.toggle('open');
            });
        });
    }

    /* ============================
       FILTER
    ============================ */
    document.querySelectorAll('.commands-filters button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.commands-filters button')
                .forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const f = btn.dataset.filter;

            document.querySelectorAll('.command-category').forEach(cat => {
                cat.style.display = (f === 'all' || cat.dataset.category === f) ? '' : 'none';
                cat.classList.remove('open');
            });
        });
    });

    /* ============================
       SEARCH (MIT KATEGORIE-OPEN)
    ============================ */
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
                cat.style.display = '';
                cat.classList.remove('open');
                cat.querySelectorAll('.command-item').forEach(cmd => cmd.style.display = '');
            } else {
                cat.style.display = hasMatch ? '' : 'none';
                cat.classList.toggle('open', hasMatch);
            }
        });
    });

    /* ============================
       PLACEHOLDER TYPE EFFECT
    ============================ */
    const searchInput = document.getElementById('commandSearch');
    const placeholderText = searchInput.dataset.placeholder;
    let typingInterval = null;

    searchInput.addEventListener('focus', () => {
        searchInput.classList.add('hide-placeholder');
        clearInterval(typingInterval);
    });

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
            searchInput.placeholder += placeholderText.charAt(i++);
        }, 35);
    });
</script>

</body>
</html>
