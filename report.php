<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ======= PHP HANDLING =======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Discord Webhook ---
    $webhook_url = "https://discord.com/api/webhooks/1400866398799925280/J30DU8hDmaMbH2eCYz5dn_Se-Z4sEBRleJj-jRYe9AJSVQBRaDjMU4bYK4RE67O_iQ-t";

    // --- Daten aus POST holen ---
    $type    = $_POST['type'] ?? 'Unbekannt';
    $desc    = trim($_POST['desc'] ?? '');
    $discord = trim($_POST['discord'] ?? '');
    $email   = trim($_POST['email'] ?? '');

    // Validierung
    if (!$desc) {
        http_response_code(400);
        echo json_encode(['success'=>false, 'msg'=>'Bitte beschreibe das Problem.']);
        exit;
    }

    // --- Discord Embed Daten je nach Typ ---
    $embed_config = [
        "Nutzer" => [
            "color" => 0x8858fa,
            "icon"  => "👤",
            "title" => "Problem mit einem Nutzer",
        ],
        "Webseite" => [
            "color" => 0x3ddbf7,
            "icon"  => "💻",
            "title" => "Fehler auf der Webseite",
        ],
        "Discord" => [
            "color" => 0xff4f6d,
            "icon"  => "🐞",
            "title" => "Fehler auf Discord",
        ],
        "Unbekannt" => [
            "color" => 0x3dfbcd,
            "icon"  => "❓",
            "title" => "Unbekannter Meldungstyp",
        ]
    ];
    $embed = $embed_config[$type] ?? $embed_config["Unbekannt"];

    $fields = [
        [
            "name" => "Beschreibung",
            "value" => $desc
        ]
    ];
    if ($discord) $fields[] = ["name"=>"Discord", "value"=>$discord];
    if ($email)   $fields[] = ["name"=>"E-Mail", "value"=>$email];

    // --- Embed Payload bauen ---
    $payload = json_encode([
        "embeds" => [[
            "title"      => "{$embed['icon']} {$embed['title']}",
            "fields"     => $fields,
            "color"      => $embed["color"],
            "footer"     => [
                "text" => "Gesendet am " . date("d.m.Y H:i")
            ]
        ]]
    ]);

    // --- Curl senden ---
    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 204) {
        echo json_encode(['success'=>true]);
    } else {
        http_response_code(500);
        echo json_encode(['success'=>false, 'msg'=>'Discord Webhook Fehler.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Problem melden | Astra Bot</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="icon" href="/public/favicon_transparent.png">
    <link rel="stylesheet" href="/css/style.css?v=2.0" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap" rel="stylesheet" />
    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(ellipse at 40% 40%, #252159 65%, #14103a 100%);
            background-attachment: fixed;
        }
        .astra-form-wrap {
            max-width: 520px;
            margin: 62px auto 48px auto;
            background: radial-gradient(ellipse at 60% 40%, #22235d 90%, #1a153b 120%);
            border-radius: 34px;
            box-shadow: 0 12px 64px #05e6fc44, 0 2px 12px #221c504a;
            padding: 42px 40px 32px 40px;
            color: #f4faff;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .astra-form-wrap h1 {
            color: #67e8fa;
            font-size: 2.15em;
            font-weight: 900;
            letter-spacing: -0.5px;
            margin-bottom: 0.28em;
            text-align: center;
            text-shadow: 0 3px 18px #33baff2c;
        }
        .astra-form-wrap p {
            color: #c0e9fa;
            font-size: 1.13em;
            font-weight: 500;
            margin-bottom: 28px;
            text-align: center;
            text-shadow: 0 2px 9px #21f4c522;
        }
        .astra-problem-types {
            display: flex;
            gap: 20px;
            margin-bottom: 34px;
            justify-content: center;
        }
        .astra-problem-chip {
            min-width: 108px;
            padding: 0.56em 1.5em;
            background: #322c6c;
            color: #9cf7ff;
            font-weight: 900;
            font-size: 1.07em;
            border-radius: 30px;
            cursor: pointer;
            border: 3px solid transparent;
            box-shadow: 0 2px 18px #5ce4ff2d, 0 0px 7px #4a40c017;
            display: flex;
            align-items: center;
            gap: 9px;
            user-select: none;
            transition: all .20s cubic-bezier(.45,.14,.21,.92);
            opacity: 0.82;
            filter: blur(0);
        }
        .astra-problem-chip.selected, .astra-problem-chip:focus, .astra-problem-chip:hover {
            background: linear-gradient(90deg,#3ad3f8 25%,#59f5e7 100%);
            color: #2a1b48;
            border: 3px solid #66f7e7;
            box-shadow: 0 5px 34px #70ffe72a, 0 0px 13px #4a40c037;
            opacity: 1;
            filter: brightness(1.13) blur(0);
            transform: scale(1.09);
            outline: none;
        }
        .astra-problem-chip.selected[data-type="Nutzer"] { background: linear-gradient(90deg,#6f48e3 15%,#59f5e7 100%);}
        .astra-problem-chip.selected[data-type="Webseite"] { background: linear-gradient(90deg,#3ad3f8 25%,#5ef6ff 100%);}
        .astra-problem-chip.selected[data-type="Discord"] { background: linear-gradient(90deg,#ff6c94 18%,#62d7e3 100%);}
        .astra-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 0;
        }
        .astra-form label {
            font-weight: 800;
            color: #98e6fa;
            margin-bottom: 6px;
            margin-top: 14px;
            font-size: 1.12em;
        }
        .astra-form textarea, .astra-form input[type="text"], .astra-form input[type="email"] {
            background: #231e4d;
            border: 1.7px solid #3ef0e7;
            color: #e0f7ff;
            font-size: 1.13em;
            border-radius: 14px;
            padding: 13px;
            margin-bottom: 16px;
            margin-top: 5px;
            transition: border .15s;
            resize: vertical;
        }
        .astra-form textarea:focus, .astra-form input:focus {
            border-color: #70e6ff;
            outline: none;
        }
        .astra-form textarea {
            min-height: 74px;
        }
        .astra-form button[type="submit"] {
            margin-top: 14px;
            padding: 13px 0;
            font-size: 1.19em;
            font-weight: 900;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            background: linear-gradient(90deg,#52ebf6 15%,#7356f7 80%);
            color: #19143d;
            box-shadow: 0 2px 18px #51e3fe3b;
            transition: filter .13s, background .13s;
            letter-spacing: .2px;
        }
        .astra-form button[type="submit"]:hover {
            filter: brightness(0.93);
            background: linear-gradient(90deg,#45d3ec 20%,#9a9fff 90%);
        }
        .astra-msg-success, .astra-msg-error {
            font-size: 1.15em;
            font-weight: 800;
            padding: 15px 0;
            margin: 29px 0 0 0;
            border-radius: 13px;
            display: none;
            text-align: center;
            transition: all 0.25s cubic-bezier(.34,.95,.56,.99);
            letter-spacing: .05em;
        }
        .astra-msg-success {
            color: #15e592;
            background: #063837d6;
        }
        .astra-msg-error {
            color: #ff7a7a;
            background: #5b1c2f6e;
        }
        @media (max-width: 700px) {
            .astra-form-wrap { padding: 18px 3vw 20px 3vw; }
        }
    </style>
</head>
<body>
<?php include "includes/header.php"; ?>

<main>
    <div class="astra-form-wrap">
        <h1>Problem melden</h1>
        <p>Dein Anliegen wird vertraulich und direkt an das Astra-Team weitergeleitet.</p>
        <div class="astra-problem-types">
            <div class="astra-problem-chip" data-type="Nutzer" title="Problem mit einem Nutzer">👤 <span>Nutzer</span></div>
            <div class="astra-problem-chip" data-type="Webseite" title="Fehler auf der Webseite">💻 <span>Webseite</span></div>
            <div class="astra-problem-chip" data-type="Discord" title="Fehler auf Discord">🐞 <span>Discord</span></div>
        </div>
        <form id="astra-report-form" class="astra-form" autocomplete="off" method="POST">
            <input type="hidden" name="type" id="astra-report-type" required value="">
            <label for="astra-desc">Beschreibung des Problems*:</label>
            <textarea name="desc" id="astra-desc" required placeholder="Beschreibe das Problem möglichst genau..."></textarea>
            <label for="astra-discord">Dein Discord-Name (optional):</label>
            <input type="text" name="discord" id="astra-discord" maxlength="32" placeholder="z.B. User#1234">
            <label for="astra-email">E-Mail (optional, falls Rückfrage):</label>
            <input type="email" name="email" id="astra-email" maxlength="60" placeholder="Optional">
            <button type="submit">Absenden</button>
        </form>
        <div class="astra-msg-success" id="astra-report-success">Danke, deine Meldung wurde gesendet! ✨</div>
        <div class="astra-msg-error" id="astra-report-error">Fehler beim Senden. Bitte später erneut versuchen.</div>
    </div>
</main>

<?php include "includes/footer.php"; ?>

<script>
    // Chip-Auswahl
    let lastChipType = '';
    document.querySelectorAll('.astra-problem-chip').forEach(chip => {
        chip.onclick = () => {
            document.querySelectorAll('.astra-problem-chip').forEach(c => c.classList.remove('selected'));
            chip.classList.add('selected');
            document.getElementById('astra-report-type').value = chip.getAttribute('data-type');
            lastChipType = chip.getAttribute('data-type');
            document.getElementById('astra-report-error').style.display = 'none';
        }
    });

    // Standardmäßig Webseite vorauswählen (wie in deinem Screenshot)
    window.addEventListener('DOMContentLoaded', function() {
        let def = document.querySelector('.astra-problem-chip[data-type="Webseite"]');
        if(def) {
            def.click();
        }
    });

    // Absenden mit Fehler-Handling & UX
    document.getElementById('astra-report-form').onsubmit = async function(e) {
        e.preventDefault();
        const type = document.getElementById('astra-report-type').value;
        if (!type) {
            document.getElementById('astra-report-error').innerText = "Bitte wähle einen Meldungstyp aus.";
            document.getElementById('astra-report-error').style.display = 'block';
            return;
        }
        const formData = new FormData(this);
        try {
            const res = await fetch(location.href, {method:'POST', body:formData});
            const result = await res.json();
            if (result.success) {
                this.style.display = 'none';
                document.getElementById('astra-report-success').style.display = 'block';
                document.getElementById('astra-report-error').style.display = 'none';
            } else {
                document.getElementById('astra-report-success').style.display = 'none';
                document.getElementById('astra-report-error').innerText = result.msg || "Fehler beim Senden. Bitte später erneut versuchen.";
                document.getElementById('astra-report-error').style.display = 'block';
            }
        } catch (err) {
            document.getElementById('astra-report-success').style.display = 'none';
            document.getElementById('astra-report-error').innerText = "Verbindung fehlgeschlagen. Bitte später erneut versuchen.";
            document.getElementById('astra-report-error').style.display = 'block';
        }
    };

    // Chips bleiben nach Senden auswählbar: Meldung zurücksetzen wenn wieder Chips angeklickt werden (optional!)
    document.querySelectorAll('.astra-problem-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            // Wenn das Formular schon ausgeblendet ist, kann man wieder einen neuen Typ auswählen und Formular anzeigen
            let form = document.getElementById('astra-report-form');
            let succ = document.getElementById('astra-report-success');
            if (form.style.display === 'none') {
                // Reset
                form.reset();
                form.style.display = 'flex';
                succ.style.display = 'none';
                // Typ setzen
                document.getElementById('astra-report-type').value = chip.getAttribute('data-type');
            }
        });
    });
</script>
<script>
    document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
        var toggle = dropdown.querySelector('.dropdown-toggle');
        var menu = dropdown.querySelector('.dropdown-menu');
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    });
</script>

</body>
</html>
