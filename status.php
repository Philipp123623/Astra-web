<?php
// --------- .env laden ---------
function loadEnv($path) {
    if (!file_exists($path)) {
        die(".env Datei nicht gefunden!");
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
    return $env;
}
$env = loadEnv(__DIR__ . '/.env');

$servername = $env['DB_SERVER'];
$username   = $env['DB_USER'];
$password   = $env['DB_PASS'];
$dbname     = $env['DB_NAME'];

// --------- Stats holen ---------
$conn = @new mysqli($servername, $username, $password, $dbname);

// Daten abrufen und Status prüfen
$mysql_online = ($conn && !$conn->connect_error);

$servercount = $usercount = $commandCount = $channelCount = "-";
if ($mysql_online) {
    $sql = "SELECT servercount, usercount, commandCount, channelCount FROM website_stats LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $servercount  = $row['servercount'] ?? "-";
        $usercount    = $row['usercount'] ?? "-";
        $commandCount = $row['commandCount'] ?? "-";
        $channelCount = $row['channelCount'] ?? "-";
    }
    @$conn->close();
}

// --------- Bot-Status prüfen ---------
$bot_online = false;
try {
    $json = @file_get_contents('http://127.0.0.1:5000/status');
    if ($json) {
        $data = json_decode($json, true);
        if ($data && isset($data['online']) && $data['online'] === true) {
            $bot_online = true;
        }
    }
} catch (Exception $e) {}

function agoText($ts) {
    if (!$ts) return "-";
    $diff = time() - $ts;
    if ($diff < 90) return "gerade eben";
    if ($diff < 3600) return round($diff/60) . " Min.";
    if ($diff < 86400) return round($diff/3600) . " Std.";
    return date("d.m.Y H:i", $ts);
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Status | Astra Bot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="/public/favicon_transparent.png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css?v=2.0" />
    <style>
        body, html {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(120deg, #221c50 0%, #2a2463 90%, #33ccd7 200%);
            font-family: 'Montserrat', sans-serif;
            color: #e7f8fc;
            display: flex;
            flex-direction: column;
        }
        .astra-status-main {
            flex: 1;
            min-height: 540px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .status-bubbles-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .astra-status-card {
            position: relative;
            z-index: 2;
            max-width: 510px;
            width: 97vw;
            margin: 40px auto 36px auto;
            padding: 38px 26px 30px 26px;
            border-radius: 38px;
            background: linear-gradient(135deg, #241d50 0%, #2e265a 78%, #3fd6dd 230%);
            box-shadow: 0 8px 44px 0 #21303f22, 0 2px 20px 0 #65e6ce11;
            text-align: center;
            overflow: hidden;
        }
        .astra-status-card h1 {
            font-size: 2.13rem;
            font-weight: 800;
            color: #65e6ce;
            margin-bottom: 22px;
            text-shadow: 0 1px 16px #251f5b33;
            letter-spacing: 0.03em;
        }
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 0 19px 0;
            padding: 0 5px;
            font-size: 1.14rem;
            font-weight: 600;
        }
        .status-label {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-badge {
            display: inline-block;
            min-width: 92px;
            font-weight: bold;
            padding: 9px 0;
            border-radius: 18px;
            font-size: 1.09rem;
            letter-spacing: 0.03em;
            box-shadow: 0 1px 12px 0 #42eaaf22;
            background: #292659;
            color: #d8ffef;
            border: 2.3px solid #65e6ce38;
            transition: background .15s, color .17s, border .17s;
            position: relative;
        }
        .status-badge.ok {
            background: linear-gradient(93deg,#65e6ce 0%, #54fdbe 110%);
            color: #223254;
            border-color: #60e9cb77;
            box-shadow: 0 0 0 3px #54fdbe11;
            font-weight: 800;
        }
        .status-badge.err {
            background: linear-gradient(93deg, #ff7272 0%, #ffb3b3 110%);
            color: #481d24;
            border-color: #ff727266;
            font-weight: 800;
            box-shadow: 0 0 0 3px #ff72721d;
        }
        .status-badge.warn {
            background: linear-gradient(93deg, #ffe479 0%, #ffbd34 110%);
            color: #553a10;
            border-color: #ffe47966;
            font-weight: 800;
            box-shadow: 0 0 0 3px #ffe4792e;
        }
        .status-icon {
            font-size: 1.24em;
            margin-right: 7px;
        }
        .stats-box-row {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            margin: 27px 0 0 0;
        }
        .stat-box {
            flex: 1 1 25%;
            background: linear-gradient(127deg, #262364 0%, #23354b 100%);
            border-radius: 18px;
            padding: 16px 7px 13px 7px;
            color: #c5fffd;
            font-size: 1.02rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 13px 0 #3fd6dd0e;
        }
        .stat-head {
            font-size: 0.96rem;
            color: #9cecff;
            margin-bottom: 2px;
        }
        .stat-num {
            font-size: 1.43rem;
            color: #65e6ce;
            font-weight: 800;
            letter-spacing: 0.04em;
            margin-bottom: 2px;
            margin-top: 4px;
        }
        @media (max-width: 700px) {
            .astra-status-card { padding: 7vw 2vw 7vw 2vw; border-radius: 18px; }
            .astra-status-card h1 { font-size: 1.13rem; }
            .status-row { font-size: 1.02rem; }
            .status-badge { min-width: 65px; font-size: 0.92rem; }
            .stats-box-row { flex-direction: column; gap: 9px;}
            .stat-box { padding: 13px 2px 10px 2px; border-radius: 14px;}
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<main class="astra-status-main">
    <div class="status-bubbles-bg">
        <svg width="100%" height="100%">
            <circle cx="12%" cy="18%" r="43" fill="#65e6ce33"/>
            <circle cx="98%" cy="18%" r="58" fill="#a7c8fd22"/>
            <circle cx="50%" cy="95%" r="32" fill="#7c41ee22"/>
            <circle cx="6%" cy="89%" r="41" fill="#60e9cb22"/>
        </svg>
    </div>
    <section class="astra-status-card">
        <h1>Service Status</h1>
        <div class="status-row">
            <span class="status-label"><span class="status-icon">🤖</span> Bot</span>
            <span class="status-badge <?php echo $bot_online ? 'ok' : 'err'; ?>">
                <?php echo $bot_online ? 'Online' : 'Offline'; ?>
            </span>
        </div>
        <div class="status-row">
            <span class="status-label"><span class="status-icon">🗄️</span> MySQL</span>
            <span class="status-badge <?php echo $mysql_online ? 'ok' : 'err'; ?>">
                <?php echo $mysql_online ? 'Online' : 'Offline'; ?>
            </span>
        </div>
        <!-- Weitere Checks wie API, Discord, Webserver... -->

        <div class="stats-box-row">
            <div class="stat-box">
                <div class="stat-head">Server</div>
                <div class="stat-num"><?php echo $servercount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">User</div>
                <div class="stat-num"><?php echo $usercount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">Commands</div>
                <div class="stat-num"><?php echo $commandCount; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-head">Channels</div>
                <div class="stat-num"><?php echo $channelCount; ?></div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
