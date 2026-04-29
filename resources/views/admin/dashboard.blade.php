@extends('admin.layout')
@section('title', 'Admin Dashboard')

@section('content')
<style>
    /* ── Hero Banner ── */
    .hero-banner {
        background: linear-gradient(135deg, #800020 0%, #5a0016 100%);
        padding: 56px 48px 64px;
        position: relative;
        overflow: hidden;
        margin: -36px -40px 0;
    }
    .hero-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 40px;
        position: relative;
        z-index: 1;
    }
    .hero-stats {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .hero-stat-pill {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 16px;
        padding: 20px 28px;
        text-align: center;
        backdrop-filter: blur(10px);
    }
    .hero-stat-pill .stat-num {
        font-size: 36px;
        font-weight: 300;
        color: #FDB813;
        margin: 0;
        line-height: 1;
    }
    .hero-stat-pill .stat-label {
        font-size: 12px;
        color: rgba(255,255,255,0.7);
        margin: 4px 0 0;
    }

    /* ── KPI Cards ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 48px;
    }
    .kpi-card {
        border-radius: 18px;
        padding: 28px 28px 24px;
        min-height: 145px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s;
    }
    .kpi-card:hover { transform: translateY(-6px); }
    .kpi-card .kpi-label {
        font-size: 13px;
        font-weight: 600;
        margin: 0;
        opacity: 0.9;
    }
    .kpi-card .kpi-value {
        font-size: 52px;
        font-weight: 300;
        line-height: 1;
        margin: 0;
        position: absolute;
        bottom: 24px;
        right: 28px;
    }
    .kpi-card .kpi-circle {
        position: absolute;
        bottom: -28px;
        right: -28px;
        width: 110px;
        height: 110px;
        border-radius: 50%;
    }

    /* ── Bottom Grid ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
    }
    .bottom-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .bottom-card:hover { box-shadow: 0 10px 35px rgba(0,0,0,0.12); }
    .bottom-card-header {
        padding: 22px 28px 18px;
        border-bottom: 1px solid rgba(128,0,32,0.07);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .bottom-card-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        font-family: 'Georgia', serif;
    }
    .bottom-card-header a {
        color: #800020;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .bottom-card-body { padding: 8px 28px 20px; }

    /* ── Main wrapper ── */
    .dash-wrapper {
        font-family: 'Segoe UI', sans-serif;
    }
    .dash-inner {
        padding: 48px 48px 60px;
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .hero-banner {
            padding: 36px 20px 44px;
            margin: -20px -16px 0;
        }
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .hero-stats {
            flex-direction: row;
            gap: 12px;
        }
        .hero-stat-pill {
            flex: 1;
            padding: 14px 12px;
        }
        .hero-stat-pill .stat-num { font-size: 26px; }

        .dash-inner {
            padding: 24px 16px 48px;
        }
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }
        .kpi-card { min-height: 120px; padding: 20px 20px 18px; }
        .kpi-card .kpi-value { font-size: 40px; bottom: 18px; right: 20px; }

        .bottom-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .bottom-card-header { padding: 18px 20px 14px; }
        .bottom-card-body { padding: 6px 20px 16px; }
    }

    @media (max-width: 480px) {
        .hero-stats { flex-direction: column; }
        .hero-stat-pill { padding: 14px 16px; }
        .kpi-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .kpi-card .kpi-label { font-size: 12px; }
        .kpi-card .kpi-value { font-size: 36px; }
    }
</style>

<div class="dash-wrapper">

    {{-- ── HERO BANNER ── --}}
    <div class="hero-banner">
        <div style="position:absolute;top:-60px;right:-60px;width:320px;height:320px;border-radius:50%;background:rgba(253,184,19,0.08);"></div>
        <div style="position:absolute;bottom:-80px;right:200px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>

        <div class="hero-inner">
            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(253,184,19,0.18);border:1px solid rgba(253,184,19,0.35);border-radius:50px;padding:6px 16px;margin-bottom:20px;">
                    <div style="width:8px;height:8px;border-radius:50%;background:#FDB813;"></div>
                    <span style="color:#FDB813;font-size:13px;font-weight:600;">Admin Portal</span>
                </div>
                <h1 style="font-size:clamp(1.8rem,4vw,3rem);font-weight:400;color:#ffffff;margin:0 0 12px;line-height:1.15;font-family:'Georgia',serif;">
                    Welcome back,<br>
                    <span style="font-weight:700;color:#FDB813;">{{ auth()->user()->name }}</span>
                </h1>
                <p style="color:rgba(255,255,255,0.72);font-size:clamp(13px,2vw,16px);margin:0;line-height:1.6;">
                    Here's what's happening in your alumni management system today.
                </p>
            </div>

            {{-- Hero Stats --}}
            <div class="hero-stats">
                <div class="hero-stat-pill">
                    <p class="stat-num">{{ $totalAlumni }}</p>
                    <p class="stat-label">Alumni Members</p>
                </div>
                <div class="hero-stat-pill">
                    <p class="stat-num">{{ $pendingApprovals }}</p>
                    <p class="stat-label">Pending Approvals</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="dash-inner">

        {{-- KPI Cards --}}
        <div class="kpi-grid">

            {{-- Card 1: Total Alumni --}}
            <div class="kpi-card"
                 onclick="openModal('modal-alumni')"
                 style="background:#800020;box-shadow:0 5px 20px rgba(128,0,32,0.2);"
                 onmouseover="this.style.boxShadow='0 12px 35px rgba(128,0,32,0.35)'"
                 onmouseout="this.style.boxShadow='0 5px 20px rgba(128,0,32,0.2)'">
                <p class="kpi-label" style="color:#ffffff;">Total Alumni</p>
                <p class="kpi-value" style="color:#ffffff;">{{ $totalAlumni }}</p>
                <div class="kpi-circle" style="background:rgba(255,255,255,0.07);"></div>
            </div>

            {{-- Card 2: Pending Approvals --}}
            <div class="kpi-card"
                 onclick="openModal('modal-pending')"
                 style="background:#FDB813;box-shadow:0 5px 20px rgba(253,184,19,0.25);"
                 onmouseover="this.style.boxShadow='0 12px 35px rgba(253,184,19,0.4)'"
                 onmouseout="this.style.boxShadow='0 5px 20px rgba(253,184,19,0.25)'">
                <p class="kpi-label" style="color:#5c3700;">Pending Approvals</p>
                <p class="kpi-value" style="color:#5c3700;">{{ $pendingApprovals }}</p>
                <div class="kpi-circle" style="background:rgba(255,255,255,0.22);"></div>
            </div>

            {{-- Card 3: Total Events --}}
            <div class="kpi-card"
                 onclick="openModal('modal-events')"
                 style="background:#9b3a54;box-shadow:0 5px 20px rgba(155,58,84,0.2);"
                 onmouseover="this.style.boxShadow='0 12px 35px rgba(155,58,84,0.35)'"
                 onmouseout="this.style.boxShadow='0 5px 20px rgba(155,58,84,0.2)'">
                <p class="kpi-label" style="color:#ffffff;">Total Events</p>
                <p class="kpi-value" style="color:#ffffff;">{{ $totalEvents }}</p>
                <div class="kpi-circle" style="background:rgba(255,255,255,0.07);"></div>
            </div>

            {{-- Card 4: Announcements --}}
            <div class="kpi-card"
                 onclick="openModal('modal-announcements')"
                 style="background:#f5c842;box-shadow:0 5px 20px rgba(245,200,66,0.25);"
                 onmouseover="this.style.boxShadow='0 12px 35px rgba(245,200,66,0.4)'"
                 onmouseout="this.style.boxShadow='0 5px 20px rgba(245,200,66,0.25)'">
                <p class="kpi-label" style="color:#5c3700;">Announcements</p>
                <p class="kpi-value" style="color:#5c3700;">{{ $totalAnnouncements }}</p>
                <div class="kpi-circle" style="background:rgba(255,255,255,0.18);"></div>
            </div>

        </div>

        {{-- Bottom Grid --}}
        <div class="bottom-grid">

            {{-- Upcoming Events --}}
            <div class="bottom-card">
                <div class="bottom-card-header">
                    <h3>Upcoming Events</h3>
                    <a href="{{ route('admin.events.index') }}">
                        See All
                        <svg width="13" height="13" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
                <div class="bottom-card-body">
                    @forelse($upcomingEvents as $event)
                    <div style="display:flex;gap:14px;padding:14px 0;border-bottom:1px solid #f5f5f5;align-items:center;">
                        <div style="width:50px;height:50px;background:#800020;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(128,0,32,0.25);">
                            <span style="font-size:9px;font-weight:700;color:#ffffff;text-transform:uppercase;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                            <span style="font-size:18px;font-weight:700;color:#ffffff;line-height:1.2;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-weight:600;color:#1a1a1a;margin:0 0 3px;font-size:14px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $event->title }}</p>
                            <p style="font-size:12px;color:#717182;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} &nbsp;·&nbsp; {{ $event->location }}</p>
                        </div>
                    </div>
                    @empty
                    <p style="color:#717182;font-size:14px;padding:20px 0;text-align:center;">No upcoming events.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Alumni --}}
            <div class="bottom-card">
                <div class="bottom-card-header">
                    <h3>Recently Joined Alumni</h3>
                    <a href="{{ route('admin.alumni-records.index') }}">
                        See All
                        <svg width="13" height="13" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
                <div class="bottom-card-body">
                    @forelse($recentAlumni as $alumni)
                    <div style="display:flex;gap:14px;padding:14px 0;border-bottom:1px solid #f5f5f5;align-items:center;">
                        <div style="width:42px;height:42px;background:#800020;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:15px;font-weight:600;color:#ffffff;">{{ strtoupper(substr($alumni->name,0,1)) }}</span>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:14px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $alumni->name }}</p>
                            <p style="font-size:12px;color:#717182;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $alumni->course ?? '—' }} &nbsp;·&nbsp; Batch {{ $alumni->batch_year ?? '—' }}</p>
                        </div>
                        <span style="font-size:11px;color:#717182;white-space:nowrap;flex-shrink:0;">{{ $alumni->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <p style="color:#717182;font-size:14px;padding:20px 0;text-align:center;">No alumni yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── MODALS ── --}}
<div id="modal-overlay" onclick="closeAllModals()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:1000;backdrop-filter:blur(3px);"></div>

{{-- Modal: Total Alumni --}}
<div id="modal-alumni" class="modal-box" style="display:none;">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;background:#800020;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <h3 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0;">Total Alumni</h3>
                <p style="color:#717182;font-size:13px;margin:0;">Approved alumni accounts</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#800020;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#ffffff;margin:0;line-height:1;">{{ $totalAlumni }}</p>
        <p style="font-size:13px;color:rgba(255,255,255,0.8);margin:8px 0 0;font-weight:500;">Active Alumni Members</p>
    </div>
    <a href="{{ route('admin.alumni-records.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">View All Alumni Records →</a>
</div>

{{-- Modal: Pending Approvals --}}
<div id="modal-pending" class="modal-box" style="display:none;">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;background:#FDB813;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <h3 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0;">Pending Approvals</h3>
                <p style="color:#717182;font-size:13px;margin:0;">Accounts awaiting review</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#FDB813;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#5c3700;margin:0;line-height:1;">{{ $pendingApprovals }}</p>
        <p style="font-size:13px;color:#5c3700;margin:8px 0 0;font-weight:500;">Awaiting Approval</p>
    </div>
    <a href="{{ route('admin.users.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">Review Pending Users →</a>
</div>

{{-- Modal: Events --}}
<div id="modal-events" class="modal-box" style="display:none;">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;background:#9b3a54;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <h3 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0;">Total Events</h3>
                <p style="color:#717182;font-size:13px;margin:0;">All active events</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#9b3a54;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#ffffff;margin:0;line-height:1;">{{ $totalEvents }}</p>
        <p style="font-size:13px;color:rgba(255,255,255,0.8);margin:8px 0 0;font-weight:500;">Total Events</p>
    </div>
    @if($upcomingEvents->count())
    <div style="margin-bottom:20px;">
        @foreach($upcomingEvents as $event)
        <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f5f5f5;align-items:center;">
            <div style="width:40px;height:40px;background:#9b3a54;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:9px;font-weight:700;color:#ffffff;text-transform:uppercase;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                <span style="font-size:15px;font-weight:700;color:#ffffff;line-height:1.2;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
            </div>
            <div style="min-width:0;">
                <p style="font-weight:600;color:#1a1a1a;margin:0;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $event->title }}</p>
                <p style="font-size:12px;color:#717182;margin:0;">{{ $event->location }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('admin.events.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">Manage Events →</a>
</div>

{{-- Modal: Announcements --}}
<div id="modal-announcements" class="modal-box" style="display:none;">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:46px;height:46px;background:#f5c842;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div>
                <h3 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0;">Announcements</h3>
                <p style="color:#717182;font-size:13px;margin:0;">Published announcements</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#f5c842;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#5c3700;margin:0;line-height:1;">{{ $totalAnnouncements }}</p>
        <p style="font-size:13px;color:#5c3700;margin:8px 0 0;font-weight:500;">Active Announcements</p>
    </div>
    @if($recentAnnouncements->count())
    <div style="margin-bottom:20px;">
        @foreach($recentAnnouncements as $ann)
        <div style="padding:10px 0;border-bottom:1px solid #f5f5f5;">
            <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:13px;">{{ $ann->title }}</p>
            <p style="font-size:12px;color:#717182;margin:0;">{{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') : '' }}</p>
        </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('admin.announcements.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">Manage Announcements →</a>
</div>

{{-- Shared modal styles --}}
<style>
.modal-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1001;
    width: 460px;
    max-width: calc(100vw - 32px);
    background: #ffffff;
    border-radius: 20px;
    padding: 36px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.18);
    font-family: 'Segoe UI', sans-serif;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.modal-close-btn {
    background: #f5f5f5;
    border: none;
    cursor: pointer;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 16px;
    color: #717182;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (max-width: 480px) {
    .modal-box { padding: 24px 20px; border-radius: 16px; }
    .modal-box .stat-big { font-size: 56px !important; }
}
</style>

<script>
function openModal(id) {
    document.getElementById('modal-overlay').style.display = 'block';
    document.getElementById(id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}
function closeAllModals() {
    document.getElementById('modal-overlay').style.display = 'none';
    document.querySelectorAll('[id^="modal-"]').forEach(function(el) {
        if (el.id !== 'modal-overlay') el.style.display = 'none';
    });
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAllModals();
});
</script>

@endsection