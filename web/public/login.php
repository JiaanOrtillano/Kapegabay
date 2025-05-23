<?php
// session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #f5ede3;
            font-family: 'Montserrat', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #7b5434;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            width: 350px;
            padding: 2.5rem 2rem 2rem 2rem;
            position: relative;
            color: #fff;
        }
        .back-btn {
            position: absolute;
            top: 1.2rem;
            left: 1.2rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #fff;
            z-index: 2;
        }
        .login-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2.2rem;
            letter-spacing: 0.03em;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #7b5434;
            opacity: 0.7;
        }
        .login-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: none;
            border-radius: 0.8rem;
            background: #fff;
            color: #7b5434;
            font-size: 1rem;
            font-family: inherit;
            outline: none;
            box-sizing: border-box;
        }
        .login-input:focus {
            box-shadow: 0 0 0 2px #bfa07a;
        }
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #7b5434;
            font-size: 1.2rem;
            opacity: 0.7;
        }
        .forgot {
            display: block;
            text-align: right;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            color: #fff;
            text-decoration: none;
            opacity: 0.85;
        }
        .forgot:hover {
            text-decoration: underline;
        }
        .login-btn {
            width: 100%;
            background: #fff;
            color: #7b5434;
            border: none;
            border-radius: 2rem;
            padding: 0.9rem 0;
            font-size: 1.1rem;
            font-weight: 700;
            margin-top: 0.5rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .login-btn:hover {
            background: #e6d3c0;
            color: #5a3a1a;
        }
        .signup-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 1rem;
            color: #fff;
            opacity: 0.9;
        }
        .signup-link a {
            color: #fff;
            text-decoration: underline;
            margin-left: 0.2rem;
        }
        .signup-link a:hover {
            color: #e6d3c0;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <button class="back-btn" onclick="window.history.back()" aria-label="Back">
            &#8592;
        </button>
        <div class="login-title">Login</div>
        <?php if (isset($_SESSION['error'])): ?>
            <div style="background:#c0392b;color:#fff;padding:0.7rem 1rem;border-radius:0.5rem;margin-bottom:1rem;text-align:center;">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div style="background:#27ae60;color:#fff;padding:0.7rem 1rem;border-radius:0.5rem;margin-bottom:1rem;text-align:center;">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <form action="/login" method="POST" autocomplete="off">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <!-- Email SVG icon -->
                        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="20" rx="4" fill="none"/><path d="M3 6.5A2.5 2.5 0 0 1 5.5 4h9A2.5 2.5 0 0 1 17 6.5v7A2.5 2.5 0 0 1 14.5 16h-9A2.5 2.5 0 0 1 3 13.5v-7Zm1.6.4 5.4 4.2 5.4-4.2" stroke="#7b5434" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <input type="email" name="email" id="email" required class="login-input" placeholder="florianlaika@gmail.com" />
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <!-- Lock SVG icon -->
                        <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="20" rx="4" fill="none"/><path d="M6 9V7a4 4 0 1 1 8 0v2" stroke="#7b5434" stroke-width="1.5" stroke-linecap="round"/><rect x="4.75" y="9" width="10.5" height="7" rx="2.25" stroke="#7b5434" stroke-width="1.5"/><circle cx="10" cy="12.5" r="1" fill="#7b5434"/></svg>
                    </span>
                    <input type="password" name="password" id="password" required class="login-input" placeholder="Password" />
                    <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1" aria-label="Show/Hide Password">
                        <span id="eye-icon">
                            <!-- Eye SVG icon (show) -->
                            <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.458 10.5C2.733 6.942 6.09 4.5 10 4.5c3.91 0 7.267 2.442 8.542 6-.7 2.058-2.13 3.79-4.042 4.87C13.13 16.058 11.6 16.5 10 16.5c-1.6 0-3.13-.442-4.5-1.13C3.588 14.29 2.158 12.558 1.458 10.5Z" stroke="#7b5434" stroke-width="1.5"/><circle cx="10" cy="10.5" r="2.5" stroke="#7b5434" stroke-width="1.5"/></svg>
                        </span>
                    </button>
                </div>
            </div>
            <a href="/forget-password" class="forgot">Forgot password</a>
            <button type="submit" class="login-btn">LOGIN</button>
        </form>
        <div class="signup-link">
            Dont have an account? <a href="/register">sign up</a>
        </div>
    </div>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eye-icon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.innerHTML = `<svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.458 10.5C2.733 6.942 6.09 4.5 10 4.5c3.91 0 7.267 2.442 8.542 6-.7 2.058-2.13 3.79-4.042 4.87C13.13 16.058 11.6 16.5 10 16.5c-1.6 0-3.13-.442-4.5-1.13C3.588 14.29 2.158 12.558 1.458 10.5Z" stroke="#7b5434" stroke-width="1.5"/><circle cx="10" cy="10.5" r="2.5" stroke="#7b5434" stroke-width="1.5"/><line x1="5" y1="15" x2="15" y2="6" stroke="#7b5434" stroke-width="1.5"/></svg>`;
            } else {
                pwd.type = 'password';
                eye.innerHTML = `<svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.458 10.5C2.733 6.942 6.09 4.5 10 4.5c3.91 0 7.267 2.442 8.542 6-.7 2.058-2.13 3.79-4.042 4.87C13.13 16.058 11.6 16.5 10 16.5c-1.6 0-3.13-.442-4.5-1.13C3.588 14.29 2.158 12.558 1.458 10.5Z" stroke="#7b5434" stroke-width="1.5"/><circle cx="10" cy="10.5" r="2.5" stroke="#7b5434" stroke-width="1.5"/></svg>`;
            }
        }
    </script>
</body>
</html>
