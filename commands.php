<?php
session_start();

$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'de';
if (!in_array($lang, ['de','en'])) $lang = 'de';
$_SESSION['lang'] = $lang;

$t = require __DIR__ . "/lang/$lang.php";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Commands | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=4.3" />
</head>
<body>

<!-- ASTRA LOADER -->
<div id="astra-loader">
    <div class="astra-loader-bg"></div>
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
                    <span class="astra-label green"><?= $t['cmd_label_slash'] ?></span>
                    <span class="astra-label blue"><?= $t['cmd_label_live'] ?></span>
                    <span class="astra-label yellow"><?= $t['cmd_label_version'] ?></span>
                </div>

                <h1><?= $t['cmd_title'] ?></h1>
                <p class="astra-desc"><?= $t['cmd_desc'] ?></p>

                <div class="astra-badges-row">
                    <span class="astra-badge mint"><?= $t['cmd_badge_mod'] ?></span>
                    <span class="astra-badge blue"><?= $t['cmd_badge_level'] ?></span>
                    <span class="astra-badge violet"><?= $t['cmd_badge_eco'] ?></span>
                    <span class="astra-badge yellow"><?= $t['cmd_badge_fun'] ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMANDS PANEL -->
    <section class="commands-panel-card">

        <input
                id="commandSearch"
                class="commands-search"
                type="text"
                placeholder="<?= $t['cmd_search'] ?>"
                data-placeholder="<?= $t['cmd_search'] ?>"
        />

        <div class="commands-filters">
            <button class="active" data-filter="all"><?= $t['filter_all'] ?></button>
            <button data-filter="Moderation"><?= $t['filter_mod'] ?></button>
            <button data-filter="Levelsystem"><?= $t['filter_level'] ?></button>
            <button data-filter="Economy"><?= $t['filter_eco'] ?></button>
            <button data-filter="Fun"><?= $t['filter_fun'] ?></button>
            <button data-filter="Einstellungen"><?= $t['filter_settings'] ?></button>
            <button data-filter="Informationen"><?= $t['filter_info'] ?></button>
        </div>

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
       LOAD JSON & RENDER (SAFE)
    ============================ */
    fetch('/json/commands.json')
        .then(res => res.json())
        .then(data => renderCommands(data));

    function renderCommands(data) {
        const accordion = document.getElementById('commandsAccordion');
        accordion.innerHTML = '';

        Object.entries(data).forEach(([category, catData]) => {
            const count = catData.commands.length;

            const categoryEl = document.createElement('div');
            categoryEl.className = 'command-category';
            categoryEl.dataset.category = category;

            const body = document.createElement('div');
            body.className = 'command-category-body';

            catData.commands.forEach(cmd => {
                const item = document.createElement('div');
                item.className = 'command-item';

                const name = document.createElement('div');
                name.className = 'cmd-name';
                name.textContent = cmd.name;

                const desc = document.createElement('div');
                desc.className = 'cmd-desc';
                desc.textContent = cmd.description;

                const usage = document.createElement('div');
                usage.className = 'cmd-usage';
                usage.textContent = cmd.usage; // ⬅️ DAS IST DER FIX

                item.appendChild(name);
                item.appendChild(desc);
                item.appendChild(usage);
                body.appendChild(item);
            });

            categoryEl.innerHTML = `
      <button class="command-category-header">
        ${getIcon(category)} ${category}
        <span>${count} Commands</span>
      </button>
    `;

            categoryEl.appendChild(body);
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
       ACCORDION
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
            // Active State
            document.querySelectorAll('.commands-filters button')
                .forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            document.querySelectorAll('.command-category').forEach(cat => {
                const isMatch = filter === 'all' || cat.dataset.category === filter;

                // Sichtbarkeit
                cat.style.display = isMatch ? '' : 'none';

                // Accordion State
                if (filter === 'all') {
                    cat.classList.remove('open');
                } else {
                    cat.classList.toggle('open', isMatch);
                }
            });
        });
    });

    /* ============================
       SEARCH
    ============================ */
    document.getElementById('commandSearch').addEventListener('input', e => {
        const val = e.target.value.toLowerCase().trim();

        document.querySelectorAll('.command-category').forEach(cat => {
            let hasMatch = false;

            cat.querySelectorAll('.command-item').forEach(cmd => {
                const name = cmd.querySelector('.cmd-name')?.innerText.toLowerCase() || '';
                const usage = cmd.querySelector('.cmd-usage')?.innerText.toLowerCase() || '';

                const match = name.includes(val) || usage.includes(val);

                cmd.style.display = match ? '' : 'none';
                if (match) hasMatch = true;
            });

            if (val === '') {
                cat.style.display = '';
                cat.classList.remove('open');
                cat.querySelectorAll('.command-item')
                    .forEach(cmd => cmd.style.display = '');
            } else {
                cat.style.display = hasMatch ? '' : 'none';
                cat.classList.toggle('open', hasMatch);
            }
        });
    });
</script>



</body>
</html>
