<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Nepal News Australia')</title>
    <meta name="description" content="@yield('description','Nepal News Australia — Latest news for the Nepalese-Australian community.')">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>
<body class="{{ request()->routeIs('home') ? '' : 'inner-page' }}">

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
                <span>📅 {{ now()->format('l, d F Y') }}</span>
                <span class="sep">|</span>
                <span>📍 Sydney, Australia</span>
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
                    <a href="{{ route('dashboard') }}">👤 {{ auth()->user()->name }}</a>
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
            <div style="display:flex;align-items:center;gap:12px">
                <form action="{{ route('search') }}" method="GET" class="header-search">
                    <input type="text" name="search" placeholder="Search news, articles..." value="{{ request('search') }}">
                    <button type="submit">🔍</button>
                </form>
                <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- DESKTOP NAV --}}
<nav class="site-nav">
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home')?'active':'' }}">🏠 Home</a>
            @foreach(['nepal','australia','community','business','sports','entertainment','opinion','culture'] as $navCat)
            <a href="{{ route('category',$navCat) }}" class="{{ request()->route('cat')===$navCat?'active':'' }}">{{ ucfirst($navCat) }}</a>
            @endforeach
            <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*')?'active':'' }}">Events</a>
            @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('ads.index') }}" style="color:#f1c40f!important">📢 Ads</a>
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
        <button onclick="toggleMobileMenu()" style="background:rgba(0,0,0,0.06);border:none;border-radius:50%;width:32px;height:32px;cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;flex-shrink:0">✕</button>
    </div>

    <div class="mobile-menu-section">
        <div class="mobile-menu-label">📰 News Sections</div>
        <a href="{{ route('home') }}" class="mobile-menu-item {{ request()->routeIs('home')?'active':'' }}">🏠 Home</a>
        @foreach(['nepal'=>'🇳🇵','australia'=>'🇦🇺','community'=>'👥','business'=>'💼','sports'=>'🏏','entertainment'=>'🎬','opinion'=>'💬','culture'=>'🎭'] as $mc => $icon)
        <a href="{{ route('category',$mc) }}" class="mobile-menu-item {{ request()->route('cat')===$mc?'active':'' }}">{{ $icon }} {{ ucfirst($mc) }}</a>
        @endforeach
    </div>

    <div class="mobile-menu-section">
        <div class="mobile-menu-label">🔗 Quick Links</div>
        <a href="{{ route('events.index') }}" class="mobile-menu-item">📅 Community Events</a>
        <a href="https://www.hamropatro.com/" target="_blank" rel="noopener" class="mobile-menu-item">🗓️ Hamro Patro</a>
        @auth
        <a href="{{ route('dashboard') }}" class="mobile-menu-item">⚡ Dashboard</a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('ads.index') }}" class="mobile-menu-item" style="color:#C0392B;font-weight:600">📢 Manage Ads</a>
        @endif
        @if(auth()->user()->isContributor())
        <a href="{{ route('articles.create') }}" class="mobile-menu-item" style="color:#C0392B;font-weight:600">✏️ Write Article</a>
        @endif
        @else
        <a href="{{ route('login') }}" class="mobile-menu-item">🔑 Sign In</a>
        <a href="{{ route('register') }}" class="mobile-menu-item">📝 Register</a>
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
                        <div style="color:rgba(255,255,255,0.3);font-size:10px;letter-spacing:2px;text-transform:uppercase;margin-top:2px">Est. 2024</div>
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
                    <li><a href="{{ route('category','nepal') }}">🇳🇵 Nepal</a></li>
                    <li><a href="{{ route('category','australia') }}">🇦🇺 Australia</a></li>
                    <li><a href="{{ route('category','community') }}">👥 Community</a></li>
                    <li><a href="{{ route('category','business') }}">💼 Business</a></li>
                    <li><a href="{{ route('category','sports') }}">🏏 Sports</a></li>
                    <li><a href="{{ route('category','entertainment') }}">🎬 Entertainment</a></li>
                    <li><a href="{{ route('category','opinion') }}">💬 Opinion</a></li>
                    <li><a href="{{ route('category','culture') }}">🎭 Culture</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('events.index') }}">📅 Community Events</a></li>
                    <li><a href="#newsletter">✉️ Newsletter</a></li>
                    <li><a href="{{ route('ads.index') }}">📢 Advertise With Us</a></li>
                    <li>
                        @auth
                        <a href="{{ route('articles.create') }}">📝 Submit Story</a>
                        @else
                        <a href="{{ route('register') }}">📝 Submit Story</a>
                        @endauth
                    </li>
                    <li><a href="https://www.hamropatro.com/" target="_blank" rel="noopener">🗓️ Hamro Patro</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">ℹ️ About Us</a></li>
                    <li><a href="#">📞 Contact</a></li>
                    <li><a href="#">🔒 Privacy Policy</a></li>
                    <li><a href="#">📄 Terms of Use</a></li>
                    @auth
                    @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('ads.index') }}" style="color:#f1c40f!important">📢 Ad Manager</a></li>
                    <li><a href="{{ route('dashboard') }}" style="color:#f1c40f!important">⚡ Admin Panel</a></li>
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
            <div id="footerNlMsg" style="display:none;color:#4ade80;font-weight:600;font-size:14px">✅ Subscribed! Welcome to the community.</div>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} Nepal News Australia. All rights reserved. Built with ❤️ for the Nepali-Australian community.</p>
        </div>
    </div>
</footer>

<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/lang.js') }}"></script>
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
}
function submitFooterNewsletter(e) {
    e.preventDefault();
    document.getElementById('footerNlForm').style.display = 'none';
    document.getElementById('footerNlMsg').style.display  = 'block';
}
</script>
@stack('scripts')
</body>
</html>
