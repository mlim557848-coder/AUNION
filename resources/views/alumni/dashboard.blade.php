@extends('alumni.layout')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Hero ── */
.hero-banner {
    background: linear-gradient(135deg, #800020 0%, #5a0016 100%);
    border-radius: 20px; padding: 40px;
    position: relative; overflow: hidden;
    margin-bottom: 36px; color: #fff;
    box-shadow: 0 8px 32px rgba(128,0,32,0.22);
}
.hero-deco { position:absolute; border-radius:50%; background:rgba(253,184,19,0.08); }
.hero-inner { display:flex; align-items:center; justify-content:space-between; gap:24px; position:relative; z-index:1; flex-wrap:wrap; }
.hero-avatar {
    width:68px; height:68px; border-radius:50%; background:#FDB813;
    display:flex; align-items:center; justify-content:center;
    font-size:22px; font-weight:800; color:#5c3700;
    border:3px solid rgba(255,255,255,0.3); overflow:hidden; flex-shrink:0;
}
.hero-avatar img { width:100%; height:100%; object-fit:cover; }
.hero-stat-pill {
    background:rgba(255,255,255,0.13); border:1px solid rgba(255,255,255,0.18);
    border-radius:999px; padding:8px 18px; font-size:13px; color:#fff;
    display:flex; align-items:center; gap:7px; white-space:nowrap;
    transition:background 0.25s;
}
.hero-stat-pill:hover { background:rgba(255,255,255,0.2); }

/* ── KPI Cards ── */
.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:36px; }
.kpi-card {
    border-radius:18px; padding:28px 24px 24px;
    min-height:148px; position:relative; overflow:hidden;
    cursor:pointer; transition:transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}
.kpi-card:hover { transform:translateY(-6px); box-shadow:0 12px 32px rgba(0,0,0,0.18); }
.kpi-deco {
    position:absolute; bottom:-28px; right:-28px;
    width:110px; height:110px; border-radius:50%;
    background:rgba(255,255,255,0.07);
}

/* ── Section Cards ── */
.section-card {
    background:#fff; border-radius:18px;
    border:1px solid rgba(128,0,32,0.08);
    padding:28px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
    transition:box-shadow 0.3s;
}
.section-card:hover { box-shadow:0 8px 30px rgba(128,0,32,0.1); }
.section-header-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; }
.section-title { font-size:17px; font-weight:700; color:#1a1a1a; margin:0; font-family:'Georgia',serif; }
.see-all {
    color:#800020; text-decoration:none; font-size:13px; font-weight:600;
    display:flex; align-items:center; gap:5px; transition:gap 0.25s;
}
.see-all:hover { gap:8px; }

/* ── Event Items ── */
.event-item {
    display:flex; gap:16px; padding:15px 0;
    border-bottom:1px solid rgba(128,0,32,0.07); align-items:flex-start;
    transition:background 0.2s; border-radius:8px;
}
.event-item:last-child { border-bottom:none; padding-bottom:0; }
.event-date-box {
    background:#fdf0f3; border-radius:12px;
    padding:10px 13px; text-align:center; min-width:54px; flex-shrink:0;
    border:1px solid rgba(128,0,32,0.1);
}

/* ── Activity ── */
.activity-dot {
    width:9px; height:9px; border-radius:50%;
    background:#800020; flex-shrink:0; margin-top:5px;
}

/* ── Modal ── */
.modal-overlay {
    display:none; position:fixed; inset:0; z-index:2000;
    background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:16px;
}
.modal-overlay.open { display:flex; }
.modal-box {
    background:#fff; border-radius:22px; padding:32px;
    width:100%; max-width:480px; max-height:88vh; overflow-y:auto;
    box-shadow:0 20px 60px rgba(0,0,0,0.18);
}
.modal-stat-row {
    display:flex; justify-content:space-between; align-items:center;
    padding:13px 0; border-bottom:1px solid rgba(128,0,32,0.07);
}
.modal-stat-row:last-child { border-bottom:none; }
.modal-empty { color:#717182; font-size:14px; text-align:center; padding:28px 0; }

@media (max-width:1024px) { .kpi-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:768px) {
    .hero-banner { padding:26px 22px; }
    .hero-inner { flex-direction:column; align-items:flex-start; }
    .kpi-grid { grid-template-columns:repeat(2,1fr); gap:12px; }
    .kpi-card { padding:20px 18px; min-height:120px; }
    .section-card { padding:20px 16px; }
    .bottom-grid { grid-template-columns:1fr !important; }
    .modal-box { padding:24px 18px; }
}
@media (max-width:480px) {
    .kpi-grid { gap:10px; }
    .hero-stat-pill { font-size:12px; padding:6px 13px; }
}
</style>
@endpush

@section('content')
@php $user = auth()->user(); $initials = strtoupper(substr($user->name,0,2)); @endphp

{{-- ── HERO ── --}}
<div class="hero-banner">
    <div class="hero-deco" style="width:280px;height:280px;top:-100px;right:-80px;"></div>
    <div class="hero-deco" style="width:140px;height:140px;bottom:-50px;left:35%;opacity:0.6;background:rgba(255,255,255,0.05);"></div>
    <div class="hero-inner">
        <div style="display:flex;align-items:center;gap:18px;">
            <div class="hero-avatar">
                @if($user->profile_photo)
                    <img src="{{ asset('profile_photos/'.$user->profile_photo) }}" alt="">
                @else {{ $initials }} @endif
            </div>
            <div>
                <p style="color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:4px;">Welcome back 👋</p>
                <h1 style="font-size:24px;font-weight:800;color:#fff;margin:0;line-height:1.2;font-family:'Georgia',serif;">{{ $user->name }}</h1>
                <p style="color:rgba(255,255,255,0.7);font-size:13.5px;margin:5px 0 0;">{{ $user->course ?? 'Alumni Member' }} · Batch {{ $user->batch_year ?? 'N/A' }}</p>
            </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <div class="hero-stat-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                {{ $connectionsCount ?? 0 }} Connections
            </div>
            <div class="hero-stat-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $eventsAttended ?? 0 }} Events
            </div>
            @if($user->current_position)
            <div class="hero-stat-pill">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                {{ $user->current_position }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── KPI CARDS ── --}}
<div class="kpi-grid">
    <div class="kpi-card" style="background:#800020;" onclick="openModal('modal-connections')">
        <div class="kpi-deco"></div>
        <div style="font-size:12.5px;color:rgba(255,255,255,0.8);position:relative;">My Connections</div>
        <div style="position:absolute;bottom:24px;right:24px;font-size:44px;font-weight:800;color:#fff;line-height:1;">{{ $connectionsCount ?? 0 }}</div>
    </div>
    <div class="kpi-card" style="background:#FDB813;" onclick="openModal('modal-events')">
        <div class="kpi-deco"></div>
        <div style="font-size:12.5px;color:rgba(92,55,0,0.8);position:relative;">Events Joined</div>
        <div style="position:absolute;bottom:24px;right:24px;font-size:44px;font-weight:800;color:#5c3700;line-height:1;">{{ $eventsAttended ?? 0 }}</div>
    </div>
    <div class="kpi-card" style="background:#9b3a54;" onclick="openModal('modal-announcements')">
        <div class="kpi-deco"></div>
        <div style="font-size:12.5px;color:rgba(255,255,255,0.8);position:relative;">Announcements</div>
        <div style="position:absolute;bottom:24px;right:24px;font-size:44px;font-weight:800;color:#fff;line-height:1;">{{ $announcementsCount ?? 0 }}</div>
    </div>
    <div class="kpi-card" style="background:#f5c842;" onclick="openModal('modal-profile')">
        <div class="kpi-deco"></div>
        <div style="font-size:12.5px;color:rgba(92,55,0,0.8);position:relative;">Profile Views</div>
        <div style="position:absolute;bottom:24px;right:24px;font-size:44px;font-weight:800;color:#5c3700;line-height:1;">{{ $profileViews ?? 0 }}</div>
    </div>
</div>

{{-- ── BOTTOM GRID ── --}}
<div class="bottom-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    <div class="section-card">
        <div class="section-header-row">
            <h2 class="section-title">Upcoming Events</h2>
            <a href="{{ route('alumni.events') }}" class="see-all">View all <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
        @forelse($upcomingEvents ?? [] as $event)
        <div class="event-item">
            <div class="event-date-box">
                <div style="font-size:19px;font-weight:800;color:#800020;line-height:1;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                <div style="font-size:10px;color:#717182;text-transform:uppercase;font-weight:600;margin-top:2px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:14px;font-weight:600;color:#1a1a1a;margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $event->title }}</div>
                <div style="font-size:12px;color:#717182;display:flex;align-items:center;gap:4px;">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $event->location }}
                </div>
            </div>
        </div>
        @empty
        <p style="color:#717182;font-size:14px;text-align:center;padding:24px 0;">No upcoming events</p>
        @endforelse
    </div>

    <div class="section-card">
        <h2 class="section-title" style="margin-bottom:22px;">Recent Activity</h2>
        @forelse($recentActivity ?? [] as $activity)
        <div style="display:flex;gap:13px;padding:11px 0;border-bottom:1px solid rgba(128,0,32,0.07);">
            <div class="activity-dot"></div>
            <div>
                <div style="font-size:13.5px;color:#1a1a1a;">{{ $activity['text'] }}</div>
                <div style="font-size:12px;color:#717182;margin-top:2px;">{{ $activity['time'] }}</div>
            </div>
        </div>
        @empty
        <p style="color:#717182;font-size:14px;text-align:center;padding:24px 0;">No recent activity</p>
        @endforelse
    </div>
</div>

{{-- ── MODALS ── --}}

{{-- CONNECTIONS MODAL --}}
<div class="modal-overlay" id="modal-connections" onclick="closeModalOnOverlay(event,'modal-connections')">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:19px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">My Connections</h3>
            <button onclick="closeModal('modal-connections')" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        {{-- Summary stat --}}
        <div style="background:#fdf0f3;border-radius:14px;padding:20px;text-align:center;margin-bottom:20px;">
            <div style="font-size:48px;font-weight:800;color:#800020;line-height:1;">{{ $connectionsCount ?? 0 }}</div>
            <div style="font-size:13px;color:#717182;margin-top:6px;">Total Accepted Connections</div>
        </div>
        <div style="font-size:13px;color:#717182;text-align:center;">
            Connect with more alumni on the
            <a href="{{ route('alumni.network') }}" style="color:#800020;font-weight:600;text-decoration:none;">Network</a> page.
        </div>
    </div>
</div>

{{-- EVENTS MODAL --}}
<div class="modal-overlay" id="modal-events" onclick="closeModalOnOverlay(event,'modal-events')">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:19px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Events Attended</h3>
            <button onclick="closeModal('modal-events')" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div style="background:#fffbea;border-radius:14px;padding:20px;text-align:center;margin-bottom:20px;">
            <div style="font-size:48px;font-weight:800;color:#5c3700;line-height:1;">{{ $eventsAttended ?? 0 }}</div>
            <div style="font-size:13px;color:#717182;margin-top:6px;">Events You've RSVP'd To</div>
        </div>
        @if(($upcomingEvents ?? collect())->count())
            <div style="font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:12px;">Upcoming Events</div>
            @foreach($upcomingEvents as $event)
            <div class="modal-stat-row">
                <div>
                    <div style="font-size:13.5px;font-weight:600;color:#1a1a1a;">{{ $event->title }}</div>
                    <div style="font-size:12px;color:#717182;margin-top:2px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }} · {{ $event->location }}</div>
                </div>
                <span style="background:#fdf0f3;color:#800020;font-size:11px;font-weight:700;padding:4px 10px;border-radius:999px;white-space:nowrap;">Upcoming</span>
            </div>
            @endforeach
        @else
            <p class="modal-empty">No upcoming events at the moment.</p>
        @endif
        <a href="{{ route('alumni.events') }}" style="display:block;text-align:center;margin-top:18px;color:#800020;font-size:13px;font-weight:600;text-decoration:none;">Browse all events →</a>
    </div>
</div>

{{-- ANNOUNCEMENTS MODAL --}}
<div class="modal-overlay" id="modal-announcements" onclick="closeModalOnOverlay(event,'modal-announcements')">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:19px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Announcements</h3>
            <button onclick="closeModal('modal-announcements')" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div style="background:#f5eaf0;border-radius:14px;padding:20px;text-align:center;margin-bottom:20px;">
            <div style="font-size:48px;font-weight:800;color:#9b3a54;line-height:1;">{{ $announcementsCount ?? 0 }}</div>
            <div style="font-size:13px;color:#717182;margin-top:6px;">Published Announcements</div>
        </div>
        @if(($announcements ?? collect())->count())
            <div style="font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:12px;">Latest Announcements</div>
            @foreach($announcements as $ann)
            <div class="modal-stat-row">
                <div style="flex:1;min-width:0;">
                    <div style="font-size:13.5px;font-weight:600;color:#1a1a1a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $ann->title }}</div>
                    <div style="font-size:12px;color:#717182;margin-top:2px;">{{ $ann->category }} · {{ \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') }}</div>
                </div>
            </div>
            @endforeach
        @else
            <p class="modal-empty">No announcements yet.</p>
        @endif
        <a href="{{ route('alumni.announcements') }}" style="display:block;text-align:center;margin-top:18px;color:#800020;font-size:13px;font-weight:600;text-decoration:none;">View all announcements →</a>
    </div>
</div>

{{-- PROFILE VIEWS MODAL --}}
<div class="modal-overlay" id="modal-profile" onclick="closeModalOnOverlay(event,'modal-profile')">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:19px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Profile Views</h3>
            <button onclick="closeModal('modal-profile')" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div style="background:#fffdf0;border-radius:14px;padding:20px;text-align:center;margin-bottom:20px;">
            <div style="font-size:48px;font-weight:800;color:#5c3700;line-height:1;">{{ $profileViews ?? 0 }}</div>
            <div style="font-size:13px;color:#717182;margin-top:6px;">Alumni Viewed Your Profile</div>
        </div>
        <div style="font-size:13px;color:#717182;text-align:center;line-height:1.6;">
            Keep your profile updated to attract more views.<br>
            <a href="{{ route('alumni.profile.edit') }}" style="color:#800020;font-weight:600;text-decoration:none;">Edit your profile →</a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
function closeModalOnOverlay(e,id) { if(e.target.id===id) closeModal(id); }
</script>
@endpush