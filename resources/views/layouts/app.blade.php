<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Nepal News Australia')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <meta name="description" content="@yield('description','Nepal News Australia — Latest news for the Nepalese-Australian community.')">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
    @stack('styles')
</head>
<body class="{{ request()->routeIs('home') ? '' : 'inner-page' }}">

{{-- Scroll progress bar --}}
<div id="scroll-progress"></div>
{{-- Page transition overlay --}}
<div id="page-transition"></div>

@if(!request()->routeIs('home'))
<div class="bg-orb bg-orb-1"></div>
<div class="bg-orb bg-orb-2"></div>
<div class="bg-orb bg-orb-3"></div>
@endif

{{-- TOP BAR --}}
<div class="top-bar">
    <div class="container">
        <div class="top-bar-inner">
            <div class="top-left">
                <span><i class="fa-regular fa-calendar"></i> {{ now()->format('l, d F Y') }}</span>
                <span class="sep">|</span>
                <span><i class="fa-solid fa-location-dot"></i> Sydney, Australia</span>
            </div>
            <div class="top-right">
                <div class="lang-btns">
                    <button class="lang-btn" data-lang="en">English</button>
                    <button class="lang-btn" data-lang="ne">नेपाली</button>
                </div>
                <div class="top-socials">
                    <a href="https://www.facebook.com/nepalnewsaustralia" target="_blank" rel="noopener" title="Facebook">f</a>
                    <a href="https://www.youtube.com/@nepalnewsaustralia" target="_blank" rel="noopener" title="YouTube">▶</a>
                    <a href="https://twitter.com/nepalnewsaus" target="_blank" rel="noopener" title="Twitter/X">𝕏</a>
                    <a href="https://www.instagram.com/nepalnewsaustralia" target="_blank" rel="noopener" title="Instagram">◉</a>
                </div>
                @auth
                <span class="top-user">
                    <a href="{{ route('dashboard') }}"><i class="fa-regular fa-user"></i> {{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf <button type="submit" class="top-logout">Sign Out</button>
                    </form>
                </span>
                @else
                <a href="{{ route('login') }}" class="top-login">Sign In</a>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- HEADER --}}
<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="site-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Nepal News Australia" style="height:58px;width:58px;object-fit:cover;border-radius:50%;border:2px solid rgba(192,57,43,0.2);box-shadow:0 2px 12px rgba(192,57,43,0.15)">
                <div class="logo-text">
                    <h1>Nepal News Australia</h1>
                    <p>Your Bridge Between Nepal &amp; Australia</p>
                </div>
            </a>
            <div class="header-right">
                <form action="{{ route('search') }}" method="GET" class="header-search">
                    <input type="text" name="search" placeholder="Search news, articles..." value="{{ request('search') }}">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <button class="mobile-search-btn" id="mobileSearchBtn" onclick="toggleMobileSearch()" aria-label="Search" title="Search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
    {{-- MOBILE SEARCH BAR — inside header so it stays sticky --}}
    <div class="mobile-search-bar" id="mobileSearchBar">
        <div class="container">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="search" placeholder="Search news, articles..." value="{{ request('search') }}" autocomplete="off">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
</header>

{{-- DESKTOP NAV --}}
<nav class="site-nav">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home')?'active':'' }}"><i class="fa-solid fa-house"></i> Home</a>
            @foreach(['nepal','australia','community','business','sports','entertainment','opinion','culture'] as $navCat)
            <a href="{{ route('category',$navCat) }}" class="{{ request()->route('cat')===$navCat?'active':'' }}">{{ ucfirst($navCat) }}</a>
            @endforeach
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*')?'active':'' }}">Events</a>
            @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('ads.index') }}" style="color:#f1c40f!important"><i class="fa-solid fa-bullhorn"></i> Ads</a>
            @endif
            @if(auth()->user()->isContributor())
            <a href="{{ route('articles.create') }}" class="nav-write">+ Write</a>
            @endif
            @endauth
        </div>
    </div>
</nav>

{{-- MOBILE OVERLAY --}}
<div class="mobile-overlay" id="mobileOverlay" onclick="toggleMobileMenu()"></div>

{{-- MOBILE MENU --}}
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <img src="{{ asset('assets/img/logo.png') }}" alt="NNA" style="height:38px;width:38px;border-radius:50%;object-fit:cover">
        <span style="font-family:Georgia,serif;font-size:15px;font-weight:700;color:#1d1d1f;flex:1;margin-left:10px">Nepal News Australia</span>
        <button onclick="toggleMobileMenu()" style="background:rgba(0,0,0,0.06);border:none;border-radius:4px;width:32px;height:32px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="mobile-menu-section">
        <div class="mobile-menu-label"><i class="fa-solid fa-newspaper"></i> News Sections</div>
        <a href="{{ route('home') }}" onclick="toggleMobileMenu()" class="mobile-menu-item {{ request()->routeIs('home')?'active':'' }}"><i class="fa-solid fa-house"></i> Home</a>
        @foreach(['nepal'=>'fa-mountain-sun','australia'=>'fa-globe','community'=>'fa-users','business'=>'fa-briefcase','sports'=>'fa-trophy','entertainment'=>'fa-film','opinion'=>'fa-comment','culture'=>'fa-masks-theater'] as $mc => $icon)
        <a href="{{ route('category',$mc) }}" onclick="toggleMobileMenu()" class="mobile-menu-item {{ request()->route('cat')===$mc?'active':'' }}"><i class="fa-solid {{ $icon }}"></i> {{ ucfirst($mc) }}</a>
        @endforeach
    </div>

    <div class="mobile-menu-section">
        <div class="mobile-menu-label"><i class="fa-solid fa-link"></i> Quick Links</div>
        <a href="{{ route('events.index') }}" onclick="toggleMobileMenu()" class="mobile-menu-item"><i class="fa-regular fa-calendar"></i> Community Events</a>
        <a href="https://www.hamropatro.com/" target="_blank" rel="noopener" class="mobile-menu-item"><i class="fa-regular fa-calendar-days"></i> Hamro Patro</a>
        @auth
        <a href="{{ route('dashboard') }}" onclick="toggleMobileMenu()" class="mobile-menu-item"><i class="fa-solid fa-bolt"></i> Dashboard</a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('ads.index') }}" onclick="toggleMobileMenu()" class="mobile-menu-item" style="color:#C0392B;font-weight:600"><i class="fa-solid fa-bullhorn"></i> Manage Ads</a>
        @endif
        @if(auth()->user()->isContributor())
        <a href="{{ route('articles.create') }}" onclick="toggleMobileMenu()" class="mobile-menu-item" style="color:#C0392B;font-weight:600"><i class="fa-solid fa-pen"></i> Write Article</a>
        @endif
        @else
        <a href="{{ route('login') }}" onclick="toggleMobileMenu()" class="mobile-menu-item"><i class="fa-solid fa-key"></i> Sign In</a>
        <a href="{{ route('register') }}" onclick="toggleMobileMenu()" class="mobile-menu-item"><i class="fa-solid fa-pen-to-square"></i> Register</a>
        @endauth
    </div>

    @auth
    <div style="padding:12px 16px 20px">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;background:rgba(192,57,43,0.08);border:1.5px solid rgba(192,57,43,0.2);color:#C0392B;border-radius:12px;padding:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit">
                Sign Out
            </button>
        </form>
    </div>
    @endauth
</div>

{{-- FLASH --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif

<main>@yield('content')</main>

{{-- FOOTER --}}
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="NNA" style="height:50px;width:50px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,0.12)">
                    <div>
                        <div style="color:white;font-family:Georgia,serif;font-size:17px;font-weight:700">Nepal News Australia</div>
                        <div style="color:rgba(255,255,255,0.3);font-size:10px;text-transform:uppercase;margin-top:2px">Est. 2024</div>
                    </div>
                </div>
                <p>Australia's leading Nepali news platform serving the diaspora across Sydney, Melbourne, Brisbane, Perth and Adelaide.</p>
                <div class="footer-socials" style="margin-top:16px">
                    <a href="https://www.facebook.com/nepalnewsaustralia" target="_blank" rel="noopener" title="Facebook">f</a>
                    <a href="https://www.youtube.com/@nepalnewsaustralia" target="_blank" rel="noopener" title="YouTube">▶</a>
                    <a href="https://twitter.com/nepalnewsaus" target="_blank" rel="noopener" title="Twitter/X">𝕏</a>
                    <a href="https://www.instagram.com/nepalnewsaustralia" target="_blank" rel="noopener" title="Instagram">◉</a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Sections</h4>
                <ul>
                    <li><a href="{{ route('category','nepal') }}">Nepal</a></li>
                    <li><a href="{{ route('category','australia') }}">Australia</a></li>
                    <li><a href="{{ route('category','community') }}">Community</a></li>
                    <li><a href="{{ route('category','business') }}">Business</a></li>
                    <li><a href="{{ route('category','sports') }}">Sports</a></li>
                    <li><a href="{{ route('category','entertainment') }}">Entertainment</a></li>
                    <li><a href="{{ route('category','opinion') }}">Opinion</a></li>
                    <li><a href="{{ route('category','culture') }}">Culture</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('events.index') }}">Community Events</a></li>
                    <li><a href="#newsletter">Newsletter</a></li>
                    <li><a href="{{ route('ads.index') }}">Advertise With Us</a></li>
                    <li>
                        @auth
                        <a href="{{ route('articles.create') }}">Submit Story</a>
                        @else
                        <a href="{{ route('register') }}">Submit Story</a>
                        @endauth
                    </li>
                    <li><a href="https://www.hamropatro.com/" target="_blank" rel="noopener">Hamro Patro</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    @auth
                    @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('ads.index') }}" style="color:#f1c40f!important">Ad Manager</a></li>
                    <li><a href="{{ route('dashboard') }}" style="color:#f1c40f!important">Admin Panel</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
        </div>

        {{-- Newsletter --}}
        <div style="border-top:1px solid rgba(255,255,255,0.07);padding:28px 0;margin-top:8px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px" id="newsletter">
            <div>
                <div style="color:white;font-size:17px;font-weight:700;font-family:Georgia,serif;margin-bottom:5px">Stay Informed — Free Daily Newsletter</div>
                <div style="color:rgba(255,255,255,0.4);font-size:13px">Join 18,000+ Nepali-Australians who read us every morning</div>
            </div>
            <form id="footerNlForm" onsubmit="submitFooterNewsletter(event)" style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="email" placeholder="your@email.com" required
                    style="padding:11px 18px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.06);border-radius:24px;color:white;font-size:13px;outline:none;min-width:220px;font-family:inherit;transition:all .2s"
                    onfocus="this.style.borderColor='rgba(192,57,43,0.5)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                <button type="submit" style="padding:11px 24px;background:linear-gradient(135deg,#C0392B,#96281B);border:none;border-radius:24px;color:white;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 4px 16px rgba(192,57,43,0.4);font-family:inherit;transition:all .2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Subscribe Free →</button>
            </form>
            <div id="footerNlMsg" style="display:none;color:#4ade80;font-weight:600;font-size:14px"><i class="fa-solid fa-circle-check"></i> Subscribed! Welcome to the community.</div>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} Nepal News Australia. All rights reserved. Built for the Nepali-Australian community.</p>
        </div>
    </div>
</footer>

<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fa-solid fa-chevron-up"></i></button>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/lang.js') }}"></script>
<script src="{{ asset('assets/js/animations.js') }}"></script>
<script>
function toggleMobileMenu() {
    const menu    = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileOverlay');
    const btn     = document.getElementById('hamburgerBtn');
    const isOpen  = menu.classList.contains('open');
    menu.classList.toggle('open',!isOpen);
    overlay.classList.toggle('open',!isOpen);
    btn.classList.toggle('open',!isOpen);
    document.body.style.overflow = isOpen ? '' : 'hidden';
    // Always collapse the mobile search bar when the menu toggles
    const sb = document.getElementById('mobileSearchBar');
    const sbBtn = document.getElementById('mobileSearchBtn');
    if (sb) { sb.classList.remove('open'); }
    if (sbBtn) { sbBtn.classList.remove('active'); }
}
function toggleMobileSearch() {
    const bar = document.getElementById('mobileSearchBar');
    const btn = document.getElementById('mobileSearchBtn');
    if (!bar) return;
    const isOpen = bar.classList.contains('open');
    bar.classList.toggle('open', !isOpen);
    btn && btn.classList.toggle('active', !isOpen);
    if (!isOpen) {
        // Focus the search input when opening
        setTimeout(() => {
            const input = bar.querySelector('input');
            if (input) input.focus();
        }, 320);
    }
}
function submitFooterNewsletter(e) {
    e.preventDefault();
    document.getElementById('footerNlForm').style.display = 'none';
    document.getElementById('footerNlMsg').style.display  = 'block';
}
</script>
@stack('scripts')
    @include('components.guru-chat')
</body>
</html>
