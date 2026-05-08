<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','Nepal News Australia') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body {
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 24px;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f5f7 0%, #ede8f0 100%);
            position: relative;
            
        }
        /* Background orbs */
        .orb { position:fixed; border-radius:50%; pointer-events:none; filter:blur(60px); }
        .orb1 { width:500px;height:500px; background:radial-gradient(circle,rgba(192,57,43,0.14),transparent 70%); top:-150px;left:-150px; animation:orb1 9s ease-in-out infinite; }
        .orb2 { width:400px;height:400px; background:radial-gradient(circle,rgba(21,67,96,0.1),transparent 70%);  bottom:-100px;right:-100px; animation:orb2 11s ease-in-out infinite; }
        .orb3 { width:300px;height:300px; background:radial-gradient(circle,rgba(212,172,13,0.08),transparent 70%); bottom:20%;left:-50px; animation:orb3 13s ease-in-out infinite; }
        @keyframes orb1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(40px,30px)} }
        @keyframes orb2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-30px,-40px)} }
        @keyframes orb3 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(25px,-25px)} }

        /* Card */
        .auth-card {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 28px;
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.12), 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid rgba(255,255,255,0.85);
            animation: slideUp 0.5s cubic-bezier(0.4,0,0.2,1) both;
            position: relative; z-index: 10;
        }
        @keyframes slideUp {
            from { opacity:0; transform:translateY(28px) scale(0.97); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        /* Logo */
        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-ring-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }
        /* Spinning gradient ring */
        .logo-ring-wrap::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, #C0392B 0%, #e74c3c 25%, #f39c12 40%, #154360 60%, #2E86C1 75%, #C0392B 100%);
            animation: spinRing 3.5s linear infinite;
            z-index: 0;
        }
        /* White gap between ring and image */
        .logo-ring-wrap::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            background: white;
            z-index: 1;
        }
        @keyframes spinRing {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }
        .logo-img {
            width: 90px; height: 90px;
            border-radius: 50%;
            object-fit: cover;
            position: relative; z-index: 2;
            display: block;
        }
        .logo-title {
            font-family: 'Merriweather', Georgia, serif;
            font-size: 22px;
            font-weight: 900;
            color: #C0392B;
            margin-bottom: 5px;
            animation: fadeIn 0.5s ease 0.15s both;
        }
        .logo-sub {
            font-size: 10px;
            color: #bbb;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: fadeIn 0.5s ease 0.25s both;
        }
        @keyframes fadeIn {
            from { opacity:0; transform:translateY(6px); }
            to   { opacity:1; transform:translateY(0); }
        }

        @media(max-width:480px){
            .auth-card { padding:28px 20px; border-radius:20px; }
            .logo-img  { width:74px; height:74px; }
            .logo-title{ font-size:19px; }
        }
    </style>
</head>
<body>
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>

<div class="auth-card">
    <div class="logo-wrap">
        <a href="{{ route('home') }}" style="text-decoration:none;display:flex;flex-direction:column;align-items:center">
            <div class="logo-ring-wrap">
                <img src="{{ asset('assets/img/logo.png') }}"
                     alt="Nepal News Australia"
                     class="logo-img">
            </div>
            <div class="logo-title">Nepal News Australia</div>
            <div class="logo-sub">Your Bridge Between Nepal &amp; Australia</div>
        </a>
    </div>

    {{ $slot }}
</div>

</body>
</html>
