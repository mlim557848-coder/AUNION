<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Aunion – Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fafafa;
            color: #1a1a1a;
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            width: 260px;
            background: #800020;
            display: flex;
            flex-direction: column;
            z-index: 200;
            transition: width 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        #sidebar.collapsed { width: 68px; }

        /* ── Brand row — toggle lives here now ── */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 12px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
            flex-shrink: 0;
            min-height: 72px;
        }

        .brand-logo {
            height: 36px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-text {
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s, max-width 0.3s;
            max-width: 160px;
        }

        .brand-text h2 {
            font-size: 18px; font-weight: 800;
            color: #ffffff; line-height: 1;
        }

        .brand-text span {
            font-size: 11px; color: rgba(255,255,255,0.65);
            font-weight: 400; letter-spacing: 0.04em;
        }

        #sidebar.collapsed .brand-text {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        /* ── Toggle button — inline in brand row ── */
        .sidebar-toggle {
            background: rgba(255,255,255,0.10);
            border: none;
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            transition: background 0.18s;
            flex-shrink: 0;
            margin-left: auto;
        }
        .sidebar-toggle:hover { background: rgba(255,255,255,0.22); }

        /* When collapsed: logo + toggle only, centered nicely */
        #sidebar.collapsed .sidebar-brand {
            justify-content: center;
            gap: 0;
            padding: 18px 0;
        }
        #sidebar.collapsed .brand-logo {
            display: none; /* hide logo, show only toggle */
        }
        #sidebar.collapsed .sidebar-toggle {
            margin-left: 0;
        }

        /* ── User info ── */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            flex-shrink: 0;
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: #FDB813;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #5c3700;
            flex-shrink: 0;
        }

        .user-info {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s, max-width 0.3s;
            max-width: 160px;
        }
        .user-info p { font-size: 13px; font-weight: 600; color: #ffffff; }
        .user-info span { font-size: 11px; color: rgba(255,255,255,0.6); }

        #sidebar.collapsed .user-info {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }
        #sidebar.collapsed .sidebar-user {
            justify-content: center;
            padding: 14px 0;
        }

        /* ── Nav links ── */
        .sidebar-nav {
            flex: 1;
            padding: 8px 10px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Section labels — collapse to zero height, no gap */
        .nav-section-label {
            font-size: 10px; font-weight: 700;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 10px 10px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s, max-height 0.3s, padding 0.3s;
            max-height: 40px;
        }
        #sidebar.collapsed .nav-section-label {
            opacity: 0;
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 10px;
            border-radius: 10px;
            color: rgba(255,255,255,0.78);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: background 0.16s, color 0.16s;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-link i {
            font-size: 20px;
            flex-shrink: 0;
            width: 24px;
            text-align: center;
        }

        .nav-link .link-label {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s, max-width 0.3s;
            max-width: 160px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.10);
            color: #ffffff;
        }

        .nav-link.active {
            background: #FDB813;
            color: #5c3700;
            font-weight: 700;
        }

        #sidebar.collapsed .nav-link .link-label {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 10px 0;
        }

        /* Tooltip on collapsed */
        #sidebar.collapsed .nav-link::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1a1a1a;
            color: #fff;
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 7px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 300;
        }
        #sidebar.collapsed .nav-link:hover::after { opacity: 1; }

        /* ── Footer / Sign out ── */
        .sidebar-footer {
            padding: 10px 10px 18px;
            border-top: 1px solid rgba(255,255,255,0.10);
            flex-shrink: 0;
        }

        .exit-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 10px;
            border-radius: 10px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            white-space: nowrap;
            transition: background 0.16s, color 0.16s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
        }
        .exit-btn i { font-size: 20px; flex-shrink: 0; width: 24px; text-align: center; }
        .exit-btn .link-label {
            overflow: hidden;
            transition: opacity 0.2s, max-width 0.3s;
            max-width: 160px;
        }
        .exit-btn:hover { background: rgba(255,0,0,0.15); color: #ffaaaa; }

        #sidebar.collapsed .exit-btn .link-label { opacity: 0; max-width: 0; pointer-events: none; }
        #sidebar.collapsed .exit-btn { justify-content: center; padding: 10px 0; }

        /* ═══════════════════════════════════════
           MOBILE OVERLAY
        ═══════════════════════════════════════ */
        #mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 150;
            backdrop-filter: blur(2px);
        }
        #mobile-overlay.active { display: block; }

        /* ═══════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════ */
        #main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
            display: flex;
            flex-direction: column;
        }

        #main-content.shifted { margin-left: 68px; }

        /* ── Top bar ── */
        .topbar {
            position: sticky;
            top: 0;
            background: #ffffff;
            border-bottom: 1px solid rgba(128,0,32,0.08);
            padding: 0 40px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(128,0,32,0.05);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            width: 36px; height: 36px;
            border-radius: 8px;
            align-items: center; justify-content: center;
            color: #800020;
            flex-shrink: 0;
            transition: background 0.16s;
        }
        .mobile-menu-btn:hover { background: rgba(128,0,32,0.07); }
        .mobile-menu-btn i { font-size: 22px; }

        .topbar-titles h1 { font-size: 17px; font-weight: 700; color: #1a1a1a; }
        .topbar-titles p  { font-size: 12px; color: #717182; margin-top: 1px; }

        .topbar-right { display: flex; align-items: center; gap: 14px; }

        .topbar-badge {
            background: #fef3f3;
            border: 1px solid rgba(128,0,32,0.12);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            color: #800020;
            font-weight: 600;
            white-space: nowrap;
        }

        .page-content { padding: 36px 40px 60px; flex: 1; }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

        /* ═══════════════════════════════════════
           RESPONSIVE — MOBILE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            #sidebar {
                width: 260px !important;
                transform: translateX(-100%);
            }
            #sidebar.mobile-open { transform: translateX(0); }

            .sidebar-toggle { display: none; }

            /* Undo collapsed styles on mobile */
            #sidebar.collapsed .brand-text,
            #sidebar.collapsed .user-info,
            #sidebar.collapsed .nav-link .link-label,
            #sidebar.collapsed .exit-btn .link-label {
                opacity: 1 !important;
                max-width: 160px !important;
                pointer-events: auto !important;
            }
            #sidebar.collapsed .nav-section-label {
                opacity: 1 !important;
                max-height: 40px !important;
                padding: 10px 10px 6px !important;
            }
            #sidebar.collapsed .brand-logo { display: block !important; }
            #sidebar.collapsed .sidebar-brand { justify-content: flex-start !important; gap: 10px !important; padding: 18px 12px 18px 16px !important; }
            #sidebar.collapsed .sidebar-user { justify-content: flex-start !important; padding: 14px 16px !important; }
            #sidebar.collapsed .nav-link { justify-content: flex-start !important; padding: 10px 10px !important; }
            #sidebar.collapsed .exit-btn { justify-content: flex-start !important; padding: 10px 10px !important; }

            #main-content,
            #main-content.shifted { margin-left: 0 !important; }

            .topbar { padding: 0 16px; }
            .mobile-menu-btn { display: flex; }
            .topbar-titles h1 { font-size: 15px; }
            .topbar-titles p { display: none; }
            .page-content { padding: 20px 16px 48px; }
        }

        @media (max-width: 480px) {
            .topbar-badge span.badge-label { display: none; }
        }
    </style>
</head>
<body>

<div id="mobile-overlay" onclick="closeMobileSidebar()"></div>

<aside id="sidebar">

    {{-- Brand row: logo + name + toggle all inline --}}
    <div class="sidebar-brand">
        <img src="{{ asset('images/AUNIONLOGO.png') }}"
             alt="Aunion"
             class="brand-logo">
        <div class="brand-text">
            <h2>Aunion</h2>
            <span>Admin Portal</span>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()" id="toggleBtn" title="Toggle sidebar">
            <i class='bx bx-menu' id="toggleIcon" style="font-size:18px;"></i>
        </button>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="user-info">
            <p>{{ auth()->user()->name ?? 'Admin' }}</p>
            <span>Administrator</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        <div class="nav-section-label">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           data-label="Dashboard"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-dashboard'></i>
            <span class="link-label">Dashboard</span>
        </a>

        <div class="nav-section-label">Management</div>

        <a href="{{ route('admin.users.index') }}"
           data-label="User Approvals"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-user-check'></i>
            <span class="link-label">User Approvals</span>
        </a>

        <a href="{{ route('admin.alumni-records.index') }}"
           data-label="Alumni Records"
           class="nav-link {{ request()->routeIs('admin.alumni-records.*') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-graduation'></i>
            <span class="link-label">Alumni Records</span>
        </a>

        <a href="{{ route('admin.events.index') }}"
           data-label="Events"
           class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-calendar-event'></i>
            <span class="link-label">Events</span>
        </a>

        <a href="{{ route('admin.announcements.index') }}"
           data-label="Announcements"
           class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-megaphone'></i>
            <span class="link-label">Announcements</span>
        </a>

        <a href="{{ route('admin.donations.index') }}"
           data-label="Donations"
           class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}"
           onclick="closeMobileSidebar()">
            <i class='bx bxs-donate-heart'></i>
            <span class="link-label">Donations</span>
        </a>

    </nav>

    {{-- Footer / Sign Out --}}
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="exit-btn">
                <i class='bx bx-log-out'></i>
                <span class="link-label">Sign Out</span>
            </button>
        </form>
    </div>

</aside>

<div id="main-content">

    <div class="topbar">
        <div class="topbar-left">
            <button class="mobile-menu-btn" onclick="openMobileSidebar()" aria-label="Open menu">
                <i class='bx bx-menu'></i>
            </button>
            <div class="topbar-titles">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-subtitle', 'Aunion Admin Panel')</p>
            </div>
        </div>
        <div class="topbar-right">
            <span class="topbar-badge">
                <i class='bx bxs-shield' style="font-size:13px; vertical-align:-1px;"></i>
                <span class="badge-label"> Admin</span>
            </span>
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>

</div>

<script>
    const sidebar     = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const toggleIcon  = document.getElementById('toggleIcon');

    const isMobile = () => window.innerWidth <= 768;

    // Restore desktop collapsed state
    if (!isMobile() && localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('shifted');
        toggleIcon.className = 'bx bx-menu-alt-right';
        toggleIcon.style.fontSize = '18px';
    }

    function toggleSidebar() {
        if (isMobile()) return;
        const isCollapsed = sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('shifted', isCollapsed);
        toggleIcon.className = isCollapsed ? 'bx bx-menu-alt-right' : 'bx bx-menu';
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    function openMobileSidebar() {
        sidebar.classList.add('mobile-open');
        document.getElementById('mobile-overlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
        if (!isMobile()) return;
        sidebar.classList.remove('mobile-open');
        document.getElementById('mobile-overlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            sidebar.classList.remove('mobile-open');
            document.getElementById('mobile-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    });
</script>

</body>
</html>