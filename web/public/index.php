<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAPEGABAY</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5ede3;
            font-family: 'Montserrat', Arial, sans-serif;
            color: #333;
        }
        .navbar {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 2rem 3rem 0 0;
            box-sizing: border-box;
        }
        .navbar a {
            color: #222;
            text-decoration: none;
            margin-left: 2rem;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            transition: color 0.2s;
        }
        .navbar a:hover {
            color: #7c6a4d;
        }
        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .left {
            flex: 1.2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .bg-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Playfair Display', serif;
            font-size: 5vw;
            color: #f3e7d3;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-align: center;
            z-index: 1;
            user-select: none;
            pointer-events: none;
            line-height: 0.9;
        }
        .coffee-svg {
            position: relative;
            z-index: 2;
            width: 320px;
            height: 320px;
            margin-top: 2rem;
        }
        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 2rem;
        }
        .brand-title {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            color: #4b5a2a;
            margin-bottom: 1.5rem;
        }
        .desc {
            font-size: 1.05rem;
            color: #444;
            margin-bottom: 2.5rem;
            max-width: 420px;
            line-height: 1.6;
        }
        .get-started-btn {
            background: #8ca178;
            color: #fff;
            border: none;
            border-radius: 2rem;
            padding: 0.85rem 2.2rem;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .get-started-btn:hover {
            background: #6d8357;
        }
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                padding: 2rem 1rem;
            }
            .right {
                padding-left: 0;
                align-items: center;
                text-align: center;
            }
            .left {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#about">ABOUT</a>
        <a href="/login">LOGIN</a>
    </div>
    <div class="container">
        <div class="left">
            <div class="bg-text">KAPE<br>GABAY</div>
            <svg class="coffee-svg" viewBox="0 0 320 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="160" cy="250" rx="120" ry="35" fill="none" stroke="#9c6b53" stroke-width="7"/>
                <ellipse cx="160" cy="160" rx="80" ry="55" fill="none" stroke="#9c6b53" stroke-width="7"/>
                <ellipse cx="160" cy="160" rx="60" ry="35" fill="none" stroke="#9c6b53" stroke-width="4"/>
                <path d="M220 160c30 30 30 70-30 90" stroke="#9c6b53" stroke-width="7" fill="none"/>
                <path d="M120 120c-10-30 40-40 20-80" stroke="#9c6b53" stroke-width="7" fill="none"/>
                <path d="M160 110c-10-20 30-30 10-60" stroke="#9c6b53" stroke-width="7" fill="none"/>
                <path d="M200 100c-10-20 20-30 0-50" stroke="#9c6b53" stroke-width="7" fill="none"/>
            </svg>
        </div>
        <div class="right">
            <div class="brand-title">KAPEGABAY</div>
            <div class="desc">
                KapeGabay equips farmers with sustainable practices, climate adaptation, and post-harvest techniques to improve yield and quality. Through education and collaboration, we build a resilient coffee community driven by innovation and shared expertise.
            </div>
            <button class="get-started-btn" onclick="window.location.href='/login'">Get Started</button>
        </div>
    </div>
</body>
</html>