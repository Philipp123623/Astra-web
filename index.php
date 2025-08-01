<?php
// Funktion um .env zu laden
function loadEnv($path) {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Kommentare überspringen
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}

// Lade die .env (Pfad anpassen falls nötig)
$env = loadEnv(__DIR__ . '/.env');

// Benutze die geladenen Variablen
$servername = $env['DB_SERVER'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];

// Verbindung herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Beispiel-Abfrage
$sql = "SELECT id, servercount, usercount, commandCount, channelCount FROM website_stats";
$result = $conn->query($sql);

// Daten auslesen
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $servercount = $row['servercount'];
        $usercount = $row['usercount'];
        $commandCount = $row['commandCount'];
        $channelCount = $row['channelCount'];
    }
} else {
    $servercount = 0;
    $usercount = 0;
    $commandCount = 0;
    $channelCount = 0;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Astra | Discord Bot</title>
    <meta name="description" content="Astra – All-in-One Discord Bot mit Levelsystem, Economy, Moderation, Tickets, Mini-Games & mehr.">
    <meta name="theme-color" content="#251f5b">
    <link rel="icon" href="/public/favicon_transparent.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css?v=2.0">
</head>
<body>

<!-- HEADER -->
<header class="astra-header">
    <div class="astra-header-inner">
        <a href="https://astra-bot.de/" class="astra-logo">
            <img src="/public/favicon_transparent.png" alt="Astra Logo">
            <span class="astra-logo-text">Astra <span>Bot</span></span>
        </a>
        <nav class="astra-navbar">
            <ul>
                <li><a href="https://astra-bot.de/#hero" class="nav-link scrollto">Home</a></li>
                <li><a href="https://astra-bot.de/#stats" class="nav-link scrollto">Stats</a></li>
                <li><a href="https://astra-bot.de/#about" class="nav-link scrollto">About</a></li>
                <li><a href="https://astra-bot.de/#features" class="nav-link scrollto">Features</a></li>
                <li><a href="https://astra-bot.de/#faq" class="nav-link scrollto">FAQ</a></li>
                <li><a href="https://astra-bot.de/commands" class="nav-link">Commands</a></li>
                <li><a href="https://astra-bot.de/invite.php" class="nav-btn">Bot einladen</a></li>
            </ul>
            <div class="astra-nav-toggle" onclick="document.body.classList.toggle('nav-open')">
                <span></span><span></span><span></span>
            </div>
        </nav>
    </div>
    <div class="astra-nav-mobile-overlay" onclick="document.body.classList.remove('nav-open')"></div>
</header>

<main>
    <!-- HERO -->
    <section id="hero" class="astra-hero-card">
        <div class="bubbles-bg">
            <svg width="100%" height="100%">
                <circle cx="18%" cy="18%" r="38" fill="#65e6ce33"/>
                <circle cx="90%" cy="25%" r="64" fill="#a7c8fd22"/>
                <circle cx="52%" cy="77%" r="44" fill="#7c41ee22"/>
                <circle cx="95%" cy="90%" r="24" fill="#7c41ee22"/>
                <circle cx="6%" cy="89%" r="41" fill="#60e9cb22"/>
            </svg>
        </div>
        <div class="astra-hero-content">
            <div>
                <div class="astra-label-row">
                    <span class="astra-label green">Level & XP</span>
                    <span class="astra-label blue">Moderation</span>
                    <span class="astra-label yellow">Economy & Games</span>
                </div>
                <h1>
                    Astra<br>
                    <span class="highlight">Discord Bot</span>
                </h1>
                <div class="astra-desc">
                    <b>Das All-in-One Toolkit für deinen Discord-Server!</b><br>
                    Level, XP, Economy, Moderation, Tools & Fun – individuell, zuverlässig, blitzschnell.
                </div>
                <div class="astra-btn-row">
                    <a href="/invite.php" class="astra-btn main">🤖 Bot einladen</a>
                    <a href="/support.php" class="astra-btn outline">Support-Server</a>
                </div>
                <div class="astra-badges-row">
                    <span class="astra-badge mint">XP & Level-System</span>
                    <span class="astra-badge violet">Casino & Mini-Games</span>
                    <span class="astra-badge yellow">Tickets & ReactionRoles</span>
                    <span class="astra-badge blue">Automod & Logging</span>
                </div>
                <div class="cta-absatz">
                    <b>Starte jetzt mit Astra auf deinem Server – und werde Teil der ersten Community!</b>
                </div>
            </div>
            <div>
                <img src="/public/favicon_transparent.png" alt="Astra Logo" class="astra-hero-logo">
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section id="stats" class="astra-stats">
        <div class="stat-card">
            <span class="stat-num" data-val="<?php echo $servercount; ?>">0</span>
            <div class="stat-title">Server</div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?php echo $usercount; ?>">0</span>
            <div class="stat-title">User</div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?php echo $commandCount; ?>">0</span>
            <div class="stat-title">Commands</div>
        </div>
        <div class="stat-card">
            <span class="stat-num" data-val="<?php echo $channelCount; ?>">0</span>
            <div class="stat-title">Channels</div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="astra-about-card">
        <div class="about-img-wrap">
            <img src="/public/favicon_transparent.png" alt="Astra About" class="about-img">
        </div>
        <div>
            <h2>Über Astra</h2>
            <p>Astra ist ein moderner, vielseitiger Discord-Bot mit vielen Features:</p>
            <ul>
                <li>Moderation, Logging & Automod</li>
                <li>Levelsystem mit Rollen</li>
                <li>Economy, Casino, Mini-Games</li>
                <li>Tickets, ReactionRole, Joinrole</li>
                <li>Willkommensnachrichten & Infos</li>
            </ul>
            <a href="https://astra-bot.de/commands" class="about-link">Alle Features entdecken</a>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="astra-features-grid">
        <div class="feature-card">
            <div class="feature-title green">Level & XP</div>
            <div>Levelsystem, XP, Rollen & coole Levelup-Nachrichten.</div>
        </div>
        <div class="feature-card">
            <div class="feature-title yellow">Economy & Games</div>
            <div>Casino, Leaderboard, Jobs, viele Games & mehr.</div>
        </div>
        <div class="feature-card">
            <div class="feature-title blue">Moderation & Automod</div>
            <div>Kick, Ban, Warn, Modlog, Logging, Automod, mehr.</div>
        </div>
        <div class="feature-card">
            <div class="feature-title violet">Tickets & Tools</div>
            <div>Ticketsystem, ReactionRoles, Reminder, globale Channel.</div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="astra-faq-section">
        <h2>FAQ & Infos</h2>
        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question">Wie bekomme ich Support?</button>
                <div class="faq-answer">Ticket im #support Channel, das Team hilft persönlich & schnell.</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Kostet Astra etwas?</button>
                <div class="faq-answer">100% kostenlos nutzbar!</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Events & Giveaways?</button>
                <div class="faq-answer">Ja, regelmäßig!</div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Wie kann ich Bugs oder Features melden?</button>
                <div class="faq-answer">Im #feedback Channel oder per Ticket.</div>
            </div>
        </div>
    </section>
</main>

<footer class="astra-footer">
    <div class="astra-footer-inner">
        <div class="footer-logo">
            <img src="/public/favicon_transparent.png" alt="Astra Logo">
            <span>Astra <span>Bot</span></span>
        </div>
        <div class="footer-links">
            <a href="https://astra-bot.de/#about">Über Astra</a>
            <a href="https://astra-bot.de/#features">Features</a>
            <a href="https://astra-bot.de/commands.php">Commands</a>
            <a href="https://astra-bot.de/#faq">FAQ</a>
            <a href="https://astra-bot.de/support">Support</a>
            <a href="https://astra-bot.de/invite" class="footer-btn">Bot einladen</a>
        </div>
        <div class="footer-social">
            <a href="https://github.com/" target="_blank" title="GitHub">
                <img src="/public/github.svg" alt="GitHub">
            </a>
            <a href="https://discord.gg/" target="_blank" title="Discord">
                <img src="/public/discord-icon.svg" alt="Discord">
            </a>
        </div>
        <div class="footer-meta">
            &copy; <?php echo date('Y'); ?> Astra Bot. Made with <span style="color:#7dfad7;">&#10084;</span> | <a href="/impressum.php">Impressum</a>
        </div>
    </div>
</footer>

<!-- FAQ Dropdown Script -->
<script>
    document.querySelectorAll('.faq-question').forEach(q =>
        q.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const answer = faqItem.querySelector('.faq-answer');
            if (faqItem.classList.contains('open')) {
                // Zu machen
                answer.style.maxHeight = null;
                faqItem.classList.remove('open');
            } else {
                // Aufmachen
                faqItem.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        })
    );
</script>
<!-- Counter Animation -->
<script>
    document.querySelectorAll('.stat-num').forEach(el => {
        const end = +el.getAttribute('data-val');
        let n = 0, step = Math.max(1, Math.floor(end / 40));
        const inc = () => {
            n += step;
            if(n >= end) { el.textContent = end; }
            else { el.textContent = n; requestAnimationFrame(inc); }
        };
        inc();
    });
</script>
<!-- Scrollto Script (smooth scroll for nav) -->
<script>
    document.querySelectorAll('.scrollto').forEach(link => {
        link.addEventListener('click', function(e) {
            const id = this.getAttribute('href').split('#')[1];
            const target = document.getElementById(id);
            if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
                document.body.classList.remove('nav-open');
            }
        });
    });
</script>


</body>
</html>
