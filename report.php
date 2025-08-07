<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ======= ENV LADEN =======
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    if (isset($env['DISCORD_WEBHOOK'])) {
        $webhook_url = trim($env['DISCORD_WEBHOOK']);
    } else {
        die('DISCORD_WEBHOOK nicht in .env gefunden.');
    }
} else {
    die('.env Datei nicht gefunden.');
}

// ======= PHP HANDLING =======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="report-page">
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

    // Standardmäßig Webseite vorauswählen
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

    // Chips bleiben nach Senden auswählbar
    document.querySelectorAll('.astra-problem-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            let form = document.getElementById('astra-report-form');
            let succ = document.getElementById('astra-report-success');
            if (form.style.display === 'none') {
                form.reset();
                form.style.display = 'flex';
                succ.style.display = 'none';
                document.getElementById('astra-report-type').value = chip.getAttribute('data-type');
            }
        });
    });
</script>
</body>
</html>
