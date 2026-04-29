<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aunion – @yield('title', 'Alumni')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fafafa; color: #1a1a1a; overflow-x: hidden; }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(128,0,32,0.97);
            padding: 0 5%;
            position: sticky; top: 0; z-index: 1000;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(128,0,32,0.2);
        }
        .navbar-row1 {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 1280px; margin: 0 auto; height: 60px;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo-box {
            width: 32px; height: 32px; background: #FDB813;
            border-radius: 8px; display: flex; align-items: center;
            justify-content: center; font-size: 15px; font-weight: 800; color: #5c3700;
        }
        .nav-logo-text { font-size: 18px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }

        .nav-links { display: flex; gap: 0; list-style: none; }
        .nav-links a {
            display: flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 999px;
            color: rgba(255,255,255,0.72); text-decoration: none;
            font-size: 14px; transition: all 0.25s ease; white-space: nowrap;
            position: relative;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: 2px; left: 50%;
            transform: translateX(-50%); width: 0; height: 2px;
            background: #FDB813; border-radius: 2px; transition: width 0.3s ease;
        }
        .nav-links a:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-links a:hover::after { width: 60%; }
        .nav-links a.active {
            background: #FDB813; color: #5c3700; font-weight: 600;
        }
        .nav-links a.active::after { display: none; }
        .nav-links svg { width: 15px; height: 15px; flex-shrink: 0; }

        /* ── PROFILE DROPDOWN ── */
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .profile-dropdown { position: relative; }
        .profile-btn {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 999px; padding: 5px 14px 5px 5px;
            cursor: pointer; transition: all 0.25s;
        }
        .profile-btn:hover { background: rgba(255,255,255,0.18); }
        .profile-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: #FDB813; color: #5c3700;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; overflow: hidden; flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .profile-name { font-size: 13.5px; font-weight: 500; color: #fff; }
        .dropdown-menu {
            display: none; position: absolute; top: calc(100% + 10px); right: 0;
            background: #fff; border-radius: 14px;
            border: 1px solid rgba(128,0,32,0.1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.13);
            min-width: 190px; overflow: hidden; z-index: 300;
        }
        .dropdown-menu.open { display: block; }
        .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 18px; color: #1a1a1a; text-decoration: none;
            font-size: 13.5px; transition: background 0.15s; cursor: pointer;
            border: none; background: none; width: 100%; text-align: left;
            font-family: 'Segoe UI', sans-serif;
        }
        .dropdown-item:hover { background: #fdf0f3; color: #800020; }
        .dropdown-item svg { width: 15px; height: 15px; stroke: #800020; flex-shrink: 0; }
        .dropdown-divider { border: none; border-top: 1px solid rgba(128,0,32,0.08); margin: 4px 0; }

        /* ── HAMBURGER ── */
        .hamburger { display: none; background: none; border: none; cursor: pointer; padding: 6px; }
        .hamburger svg { width: 22px; height: 22px; stroke: #fff; }

        /* ── MOBILE SLIDE MENU ── */
        .mobile-nav {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(90,0,22,0.98); z-index: 2000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .mobile-nav.active { opacity: 1; visibility: visible; }
        .mobile-nav a {
            color: rgba(255,255,255,0.85); text-decoration: none;
            font-size: 1.4rem; margin: 0.9rem 0; transition: color 0.25s;
            display: flex; align-items: center; gap: 12px;
        }
        .mobile-nav a:hover, .mobile-nav a.active { color: #FDB813; }
        .mobile-nav-close {
            position: absolute; top: 24px; right: 24px;
            font-size: 2rem; color: #fff; cursor: pointer; background: none; border: none;
        }

        /* ── BOTTOM TAB BAR ── */
        .bottom-tab-bar {
            display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(128,0,32,0.97);
            border-top: 1px solid rgba(255,255,255,0.12);
            padding: 6px 0 max(6px, env(safe-area-inset-bottom));
            box-shadow: 0 -4px 20px rgba(128,0,32,0.2);
        }
        .tab-bar-inner { display: flex; justify-content: space-around; align-items: center; }
        .tab-item {
            display: flex; flex-direction: column; align-items: center; gap: 3px;
            padding: 6px 10px; border-radius: 12px; color: rgba(255,255,255,0.55);
            text-decoration: none; font-size: 10px; transition: all 0.2s; min-width: 52px;
        }
        .tab-item svg { width: 22px; height: 22px; }
        .tab-item.active { color: #FDB813; }
        .tab-item span { font-weight: 500; }

        /* ── PAGE CONTENT ── */
        .page-wrapper {
            max-width: 1280px; margin: 0 auto;
            padding: 40px 5% 80px;
        }

        /* ── ALERTS ── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px;
            padding: 13px 18px; margin-bottom: 24px; color: #166534;
            font-size: 14px; display: flex; align-items: center; gap: 8px;
        }
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px;
            padding: 13px 18px; margin-bottom: 24px; color: #991b1b;
            font-size: 14px; display: flex; align-items: center; gap: 8px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .nav-links { display: none; }
            .hamburger { display: flex; }
            .profile-name { display: none; }
            .bottom-tab-bar { display: block; }
            .page-wrapper { padding: 28px 5% 90px; }
        }
        @media (max-width: 480px) {
            .navbar { padding: 0 4%; }
            .page-wrapper { padding: 20px 4% 90px; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="navbar">
    <div class="navbar-row1">
        <div style="display:flex;align-items:center;gap:14px;">
            <button class="hamburger" onclick="toggleMobileMenu()" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <a href="{{ route('alumni.dashboard') }}" class="nav-logo">
                <div class="nav-logo-box">A</div>
                <span class="nav-logo-text">Aunion</span>
            </a>
        </div>

        @php $cr = request()->route()->getName(); @endphp
        <ul class="nav-links">
            <li><a href="{{ route('alumni.dashboard') }}" class="{{ $cr === 'alumni.dashboard' ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a></li>
            <li><a href="{{ route('alumni.events') }}" class="{{ str_starts_with($cr, 'alumni.events') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Events
            </a></li>
            <li><a href="{{ route('alumni.network') }}" class="{{ $cr === 'alumni.network' ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="5" r="3"/><circle cx="5" cy="19" r="3"/><circle cx="19" cy="19" r="3"/><line x1="12" y1="8" x2="5" y2="16"/><line x1="12" y1="8" x2="19" y2="16"/></svg>
                Network
            </a></li>
            <li><a href="{{ route('alumni.announcements') }}" class="{{ $cr === 'alumni.announcements' ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Announcements
            </a></li>
            <li><a href="{{ route('alumni.donations') }}" class="{{ $cr === 'alumni.donations' ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    Donate
</a></li>

            <li><a href="{{ route('alumni.profile') }}" class="{{ str_starts_with($cr, 'alumni.profile') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Profile
            </a></li>
        </ul>

        <div class="nav-right">
            <div class="profile-dropdown">
                <button class="profile-btn" onclick="toggleDropdown()" type="button">
                    <div class="profile-avatar">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('profile_photos/' . auth()->user()->profile_photo) }}" alt="">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <span class="profile-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="2" width="12" height="12"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="dropdown-menu" id="profileDropdown">
                    <a href="{{ route('alumni.profile') }}" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        My Profile
                    </a>
                    <a href="{{ route('alumni.profile.edit') }}" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Profile
                    </a>
                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ══ MOBILE FULL-SCREEN NAV ══ --}}
<div class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-close" onclick="toggleMobileMenu()">✕</button>
    @php $r = request()->route()->getName(); @endphp
    <a href="{{ route('alumni.dashboard') }}" class="{{ $r === 'alumni.dashboard' ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('alumni.events') }}" class="{{ str_starts_with($r, 'alumni.events') ? 'active' : '' }}">Events</a>
    <a href="{{ route('alumni.network') }}" class="{{ $r === 'alumni.network' ? 'active' : '' }}">Network</a>
    <a href="{{ route('alumni.announcements') }}" class="{{ $r === 'alumni.announcements' ? 'active' : '' }}">Announcements</a>
    <a href="{{ route('alumni.donations') }}" class="{{ $r === 'alumni.donations' ? 'active' : '' }}">Donate</a>
    <a href="{{ route('alumni.profile') }}" class="{{ str_starts_with($r, 'alumni.profile') ? 'active' : '' }}">Profile</a>
</div>

{{-- ══ PAGE CONTENT ══ --}}
<main class="page-wrapper">
    @if(session('success'))
        <div class="alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</main>

{{-- ══ BOTTOM TAB BAR ══ --}}
<nav class="bottom-tab-bar">
    <div class="tab-bar-inner">
        @php $cr2 = request()->route()->getName(); @endphp
        <a href="{{ route('alumni.dashboard') }}" class="tab-item {{ $cr2 === 'alumni.dashboard' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <span>Home</span>
        </a>
        <a href="{{ route('alumni.events') }}" class="tab-item {{ str_starts_with($cr2, 'alumni.events') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>Events</span>
        </a>
        <a href="{{ route('alumni.network') }}" class="tab-item {{ $cr2 === 'alumni.network' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="5" r="3"/><circle cx="5" cy="19" r="3"/><circle cx="19" cy="19" r="3"/><line x1="12" y1="8" x2="5" y2="16"/><line x1="12" y1="8" x2="19" y2="16"/></svg>
            <span>Network</span>
        </a>
        <a href="{{ route('alumni.announcements') }}" class="tab-item {{ $cr2 === 'alumni.announcements' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span>News</span>
        </a>
        <a href="{{ route('alumni.donations') }}" class="tab-item {{ $cr2 === 'alumni.donations' ? 'active' : '' }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    <span>Donate</span>
</a>
        <a href="{{ route('alumni.profile') }}" class="tab-item {{ str_starts_with($cr2, 'alumni.profile') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            <span>Profile</span>
        </a>
    </div>
</nav>

<script>
function toggleDropdown() {
    document.getElementById('profileDropdown').classList.toggle('open');
}
function toggleMobileMenu() {
    document.getElementById('mobileNav').classList.toggle('active');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.profile-dropdown')) document.getElementById('profileDropdown').classList.remove('open');
});
// Close mobile nav on link click
document.querySelectorAll('.mobile-nav a').forEach(link => {
    link.addEventListener('click', () => document.getElementById('mobileNav').classList.remove('active'));
});
</script>

@stack('scripts')
</body>
</html>