<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// =============== PHP HANDLING ===============
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Config: Deine Discord Webhook URL ---
    $webhook_url = "https://discord.com/api/webhooks/1400866398799925280/J30DU8hDmaMbH2eCYz5dn_Se-Z4sEBRleJj-jRYe9AJSVQBRaDjMU4bYK4RE67O_iQ-t";

    // --- Eingaben abholen und prüfen ---
    $type    = $_POST['type'] ?? 'Unbekannt';
    $desc    = trim($_POST['desc'] ?? '');
    $discord = trim($_POST['discord'] ?? '');
    $email   = trim($_POST['email'] ?? '');

    if (!$desc) {
        http_response_code(400);
        echo json_encode(['success'=>false, 'msg'=>'Bitte beschreibe das Problem.']);
        exit;
    }

    // --- Nachricht bauen ---
    $content = "**Meldungstyp:** $type\n";
    $content .= "**Beschreibung:**\n$desc\n";
    if ($discord) $content .= "**Discord:** $discord\n";
    if ($email)   $content .= "**E-Mail:** $email\n";
    $content .= "*Gesendet am " . date("d.m.Y H:i") . "*";

    // --- Senden an Discord Webhook ---
    $payload = json_encode(['content' => $content]);
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
    <meta charset="UTF-8">
    <title>Problem melden | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(120deg, #19143d 0%, #23215a 100%);
            color: #f4faff;
            font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .astra-card {
            max-width: 480px;
            margin: 72px auto 0 auto;
            padding: 36px 38px 24px 38px;
            background: linear-gradient(115deg, #241c4d 0%, #202a64 95%);
            border-radius: 36px;
            box-shadow: 0 8px 48px #09e6fc36, 0 2px 12px #221c504a;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .astra-card h1 {
            color: #72e6ff;
            font-size: 2.15em;
            font-weight: 900;
            margin-bottom: 0.32em;
            letter-spacing: -0.5px;
        }
        .astra-card p {
            color: #c0e9fa;
            font-size: 1.07em;
            font-weight: 500;
            margin-bottom: 26px;
            text-align: center;
        }
        .problem-types {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .problem-chip {
            padding: 0.45em 1.2em;
            background: #2e2d86;
            color: #70e6ff;
            font-weight: 700;
            border-radius: 999px;
            font-size: 1em;
            cursor: pointer;
            border: 2px solid transparent;
            box-shadow: 0 2px 10px #11f4f626;
            transition: background .17s, color .15s, border .17s, transform .15s;
            display: flex;
            align-items: center;
            gap: 7px;
            user-select: none;
        }
        .problem-chip.selected,
        .problem-chip:hover {
            background: linear-gradient(93deg,#31c6e8 65%,#7557f7 130%);
            color: #fff;
            border: 2px solid #3ef0e7;
            transform: translateY(-2px) scale(1.05);
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: 700;
            color: #95e2fd;
            margin-bottom: 6px;
            margin-top: 10px;
            font-size: 1.09em;
        }
        textarea, input[type="text"], input[type="email"] {
            background: #231e4d;
            border: 1.3px solid #3ef0e7;
            color: #e0f7ff;
            font-size: 1.07em;
            border-radius: 12px;
            padding: 11px;
            margin-bottom: 13px;
            margin-top: 4px;
            transition: border .17s;
            resize: vertical;
        }
        textarea:focus, input:focus {
            border-color: #70e6ff;
            outline: none;
        }
        textarea {
            min-height: 70px;
        }
        button[type="submit"] {
            margin-top: 8px;
            padding: 11px 0;
            font-size: 1.18em;
            font-weight: 800;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            background: linear-gradient(90deg,#52ebf6 15%,#7356f7 80%);
            color: #19143d;
            box-shadow: 0 2px 18px #51e3fe3b;
            transition: filter .13s, background .13s;
        }
        button[type="submit"]:hover {
            filter: brightness(0.93);
            background: linear-gradient(90deg,#45d3ec 20%,#9a9fff 90%);
        }
        .msg-success {
            color: #23ffc7;
            background: #1d463a70;
            font-weight: 700;
            padding: 11px 0;
            margin: 23px 0 0 0;
            border-radius: 11px;
            display: none;
            text-align: center;
        }
        .msg-error {
            color: #ff7a7a;
            background: #5b1c2f6e;
            font-weight: 700;
            padding: 11px 0;
            margin: 23px 0 0 0;
            border-radius: 11px;
            display: none;
            text-align: center;
        }
        @media (max-width: 650px) {
            .astra-card {
                padding: 17px 7vw 18px 7vw;
                border-radius: 19px;
            }
        }
    </style>
</head>
<body>
<div class="astra-card">
    <h1>Problem melden</h1>
    <p>Dein Anliegen wird vertraulich und direkt an das Astra-Team weitergeleitet.</p>
    <div class="problem-types">
        <div class="problem-chip" data-type="Nutzer" title="Problem mit einem Nutzer">
            👤 Nutzer
        </div>
        <div class="problem-chip" data-type="Webseite" title="Fehler auf der Webseite">
            💻 Webseite
        </div>
        <div class="problem-chip" data-type="Discord" title="Fehler auf Discord">
            🐞 Discord
        </div>
    </div>
    <form id="report-form" autocomplete="off" method="POST">
        <input type="hidden" name="type" id="report-type" required value="">
        <label for="desc">Beschreibung des Problems*:</label>
        <textarea name="desc" id="desc" required placeholder="Beschreibe das Problem möglichst genau..."></textarea>
        <label for="discord">Dein Discord-Name (optional):</label>
        <input type="text" name="discord" id="discord" maxlength="32" placeholder="z.B. User#1234">
        <label for="email">E-Mail (optional, falls Rückfrage):</label>
        <input type="email" name="email" id="email" maxlength="60" placeholder="Optional">
        <button type="submit">Absenden</button>
    </form>
    <div class="msg-success" id="report-success">Danke, deine Meldung wurde gesendet! ✨</div>
    <div class="msg-error" id="report-error">Fehler beim Senden. Bitte später erneut versuchen.</div>
</div>
<script>
    // Chip-Auswahl: Meldungstyp
    document.querySelectorAll('.problem-chip').forEach(chip => {
        chip.onclick = () => {
            document.querySelectorAll('.problem-chip').forEach(c => c.classList.remove('selected'));
            chip.classList.add('selected');
            document.getElementById('report-type').value = chip.getAttribute('data-type');
            document.getElementById('report-error').style.display = 'none';
        }
    });

    // Absenden mit Fehler-Handling & UX
    document.getElementById('report-form').onsubmit = async function(e) {
        e.preventDefault();
        const type = document.getElementById('report-type').value;
        if (!type) {
            document.getElementById('report-error').innerText = "Bitte wähle einen Meldungstyp aus.";
            document.getElementById('report-error').style.display = 'block';
            return;
        }
        const formData = new FormData(this);
        try {
            const res = await fetch(location.href, {method:'POST', body:formData});
            const result = await res.json();
            if (result.success) {
                this.style.display = 'none';
                document.getElementById('report-success').style.display = 'block';
                document.getElementById('report-error').style.display = 'none';
            } else {
                document.getElementById('report-success').style.display = 'none';
                document.getElementById('report-error').innerText = result.msg || "Fehler beim Senden. Bitte später erneut versuchen.";
                document.getElementById('report-error').style.display = 'block';
            }
        } catch (err) {
            document.getElementById('report-success').style.display = 'none';
            document.getElementById('report-error').innerText = "Verbindung fehlgeschlagen. Bitte später erneut versuchen.";
            document.getElementById('report-error').style.display = 'block';
        }
    };
</script>
</body>
</html>
