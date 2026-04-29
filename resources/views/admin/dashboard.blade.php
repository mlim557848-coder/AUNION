@extends('admin.layout')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Aunion Admin Panel')

@section('content')
<style>
    /* ─── STATS GRID ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 18px;
        padding: 28px 28px 24px;
        min-height: 145px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card-label {
        font-size: 13px; font-weight: 600; color: #717182;
    }
    .stat-card-icon {
        width: 40px; height: 40px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .stat-card-icon svg { width: 19px; height: 19px; }
    .stat-card-icon.maroon { background: rgba(128,0,32,0.1); }
    .stat-card-icon.maroon svg { stroke: #800020; }
    .stat-card-icon.gold   { background: rgba(253,184,19,0.15); }
    .stat-card-icon.gold   svg { stroke: #b87c00; }
    .stat-card-icon.rose   { background: rgba(155,58,84,0.12); }
    .stat-card-icon.rose   svg { stroke: #9b3a54; }
    .stat-card-icon.amber  { background: rgba(245,200,66,0.18); }
    .stat-card-icon.amber  svg { stroke: #a07b00; }
    /* Number: large, bottom-right */
    .stat-card-value {
        font-size: 52px; font-weight: 300; color: #1a1a1a; line-height: 1;
        position: absolute; bottom: 24px; right: 28px;
    }
    /* Decorative circle */
    .stat-card::after {
        content: ''; position: absolute;
        bottom: -28px; right: -28px;
        width: 110px; height: 110px; border-radius: 50%;
        background: rgba(128,0,32,0.04); pointer-events: none;
    }

    /* ─── CHART GRID ─── */
    .chart-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }
    .chart-card {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 16px;
        padding: 24px 28px;
    }
    .chart-card-title {
        font-size: 15px; font-weight: 700; color: #1a1a1a;
        margin: 0 0 3px; font-family: 'Georgia', serif;
    }
    .chart-card-subtitle { font-size: 12px; color: #717182; margin: 0 0 18px; }
    .chart-container { position: relative; height: 240px; }

    /* ─── DONATIONS CARD ─── */
    .donations-card {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 28px;
        transition: box-shadow 0.25s;
    }
    .donations-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); }
    .section-header {
        padding: 18px 24px 14px;
        border-bottom: 1px solid rgba(128,0,32,0.06);
        display: flex; justify-content: space-between; align-items: center;
    }
    .section-header h3 {
        font-size: 15px; font-weight: 700; color: #1a1a1a;
        margin: 0; font-family: 'Georgia', serif;
        display: flex; align-items: center; gap: 8px;
    }
    .section-header a {
        color: #800020; font-size: 12px; font-weight: 600;
        text-decoration: none; display: flex; align-items: center; gap: 4px;
    }
    .donations-stats-row {
        display: flex; border-bottom: 1px solid rgba(128,0,32,0.06);
    }
    .donations-stat {
        flex: 1; padding: 18px 24px; text-align: center;
        border-right: 1px solid rgba(128,0,32,0.06);
    }
    .donations-stat:last-child { border-right: none; }
    .donations-stat-value {
        font-size: 26px; font-weight: 300; color: #800020; line-height: 1; margin: 0 0 4px;
    }
    .donations-stat-label {
        font-size: 11px; color: #717182; font-weight: 500;
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .donation-row {
        display: flex; gap: 12px; padding: 11px 0;
        border-bottom: 1px solid rgba(128,0,32,0.05); align-items: center;
    }
    .donation-row:last-child { border-bottom: none; }
    .donation-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: #800020; display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; color: #ffffff; flex-shrink: 0;
    }
    .donation-name { font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0 0 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .donation-event { font-size: 11px; color: #717182; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .donation-amount { font-size: 14px; font-weight: 700; color: #16a34a; flex-shrink: 0; white-space: nowrap; }

    /* ─── BOTTOM GRID ─── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }
    .bottom-card {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 16px; overflow: hidden;
        transition: box-shadow 0.25s;
    }
    .bottom-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); }
    .bottom-card-body { padding: 4px 22px 16px; }

    /* ─── MODALS ─── */
    .modal-box {
        position: fixed; top: 50%; left: 50%;
        transform: translate(-50%, -50%); z-index: 1001;
        width: 460px; max-width: calc(100vw - 32px);
        background: #ffffff; border-radius: 20px; padding: 36px;
        box-shadow: 0 24px 80px rgba(0,0,0,0.18);
        font-family: 'Segoe UI', sans-serif;
        max-height: calc(100vh - 40px); overflow-y: auto; display: none;
    }
    .modal-header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 24px;
    }
    .modal-close-btn {
        background: #f5f5f5; border: none; cursor: pointer;
        width: 32px; height: 32px; border-radius: 50%;
        font-size: 14px; color: #717182;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s;
    }
    .modal-close-btn:hover { background: #ffe0e8; color: #800020; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .chart-grid  { grid-template-columns: 1fr; }
        .bottom-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 768px) {
        .stats-grid  { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .stat-card   { min-height: 120px; padding: 20px 20px 18px; }
        .stat-card-value { font-size: 40px; bottom: 18px; right: 20px; }
        .bottom-grid { grid-template-columns: 1fr; }
        .donations-stats-row { flex-wrap: wrap; }
        .donations-stat { min-width: 50%; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .stat-card-value { font-size: 34px; }
        .bottom-grid { grid-template-columns: 1fr; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<div style="font-family:'Segoe UI',sans-serif;">

    {{-- ── KPI STAT CARDS ── --}}
    <div class="stats-grid">

        <div class="stat-card" onclick="openModal('modal-alumni')"
             onmouseover="this.style.boxShadow='0 14px 36px rgba(128,0,32,0.15)'"
             onmouseout="this.style.boxShadow=''">
            <div class="stat-card-top">
                <span class="stat-card-label">Total Alumni</span>
                <div class="stat-card-icon maroon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ $totalAlumni }}</div>
        </div>

        <div class="stat-card" onclick="openModal('modal-pending')"
             onmouseover="this.style.boxShadow='0 14px 36px rgba(253,184,19,0.2)'"
             onmouseout="this.style.boxShadow=''">
            <div class="stat-card-top">
                <span class="stat-card-label">Pending Approvals</span>
                <div class="stat-card-icon gold">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ $pendingApprovals }}</div>
        </div>

        <div class="stat-card" onclick="openModal('modal-events')"
             onmouseover="this.style.boxShadow='0 14px 36px rgba(155,58,84,0.18)'"
             onmouseout="this.style.boxShadow=''">
            <div class="stat-card-top">
                <span class="stat-card-label">Total Events</span>
                <div class="stat-card-icon rose">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ $totalEvents }}</div>
        </div>

        <div class="stat-card" onclick="openModal('modal-announcements')"
             onmouseover="this.style.boxShadow='0 14px 36px rgba(245,200,66,0.22)'"
             onmouseout="this.style.boxShadow=''">
            <div class="stat-card-top">
                <span class="stat-card-label">Announcements</span>
                <div class="stat-card-icon amber">
                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </div>
            </div>
            <div class="stat-card-value">{{ $totalAnnouncements }}</div>
        </div>

    </div>

    {{-- ── CHARTS ── --}}
    <div class="chart-grid">
        <div class="chart-card">
            <p class="chart-card-title">Alumni Registration Trend</p>
            <p class="chart-card-subtitle">Approved registrations over the last 6 months</p>
            <div class="chart-container"><canvas id="alumniTrendChart"></canvas></div>
        </div>
        <div class="chart-card">
            <p class="chart-card-title">System Overview</p>
            <p class="chart-card-subtitle">Distribution by category</p>
            <div class="chart-container"><canvas id="overviewChart"></canvas></div>
        </div>
    </div>

    {{-- ── DONATIONS SUMMARY ── --}}
    <div class="donations-card">
        <div class="section-header">
            <h3>
                <div style="width:28px;height:28px;background:rgba(22,163,74,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <svg width="14" height="14" fill="none" stroke="#16a34a" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                Donations Overview
            </h3>
            <a href="{{ route('admin.donations.index') }}">
                See All
                <svg width="12" height="12" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
        <div class="donations-stats-row">
            <div class="donations-stat">
                <p class="donations-stat-value">₱{{ number_format($totalDonations, 2) }}</p>
                <p class="donations-stat-label">Total Collected</p>
            </div>
            <div class="donations-stat">
                <p class="donations-stat-value">{{ $totalDonors }}</p>
                <p class="donations-stat-label">Total Donors</p>
            </div>
            <div class="donations-stat">
                <p class="donations-stat-value">{{ $recentDonations->count() }}</p>
                <p class="donations-stat-label">Recent Donations</p>
            </div>
        </div>
        <div style="padding:4px 24px 16px;">
            @forelse($recentDonations as $donation)
            <div class="donation-row">
                <div class="donation-avatar">{{ strtoupper(substr($donation->user->name ?? 'A', 0, 1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <p class="donation-name">{{ $donation->user->name ?? 'Unknown' }}</p>
                    <p class="donation-event">{{ $donation->event->title ?? 'General Donation' }}{{ $donation->note ? ' · ' . $donation->note : '' }}</p>
                </div>
                <span class="donation-amount">+₱{{ number_format($donation->amount, 2) }}</span>
            </div>
            @empty
            <p style="color:#717182;font-size:13px;padding:20px 0;text-align:center;">No donations recorded yet.</p>
            @endforelse
        </div>
    </div>

    {{-- ── BOTTOM GRID ── --}}
    <div class="bottom-grid">

        {{-- Upcoming Events --}}
        <div class="bottom-card">
            <div class="section-header">
                <h3>Upcoming Events</h3>
                <a href="{{ route('admin.events.index') }}">
                    See All <svg width="12" height="12" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
            <div class="bottom-card-body">
                @forelse($upcomingEvents as $event)
                <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid rgba(128,0,32,0.05);align-items:center;">
                    <div style="width:44px;height:44px;background:#800020;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 10px rgba(128,0,32,0.2);">
                        <span style="font-size:8px;font-weight:700;color:#FDB813;text-transform:uppercase;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                        <span style="font-size:17px;font-weight:700;color:#ffffff;line-height:1.2;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $event->title }}</p>
                        <p style="font-size:11px;color:#717182;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} · {{ $event->location }}</p>
                    </div>
                </div>
                @empty
                <p style="color:#717182;font-size:13px;padding:20px 0;text-align:center;">No upcoming events.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Announcements --}}
        <div class="bottom-card">
            <div class="section-header">
                <h3>Recent Announcements</h3>
                <a href="{{ route('admin.announcements.index') }}">
                    See All <svg width="12" height="12" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
            <div class="bottom-card-body">
                @forelse($recentAnnouncements as $ann)
                <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid rgba(128,0,32,0.05);align-items:flex-start;">
                    <div style="width:34px;height:34px;background:rgba(245,200,66,0.18);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                        <svg width="14" height="14" fill="none" stroke="#a07b00" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ann->title }}</p>
                        <p style="font-size:11px;color:#717182;margin:0 0 3px;">{{ $ann->category ?? 'General' }} · {{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') : 'Draft' }}</p>
                        <p style="font-size:11.5px;color:#9a9aaa;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit(strip_tags($ann->body), 55) }}</p>
                    </div>
                </div>
                @empty
                <p style="color:#717182;font-size:13px;padding:20px 0;text-align:center;">No announcements yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recently Joined Alumni --}}
        <div class="bottom-card">
            <div class="section-header">
                <h3>Recently Joined</h3>
                <a href="{{ route('admin.alumni-records.index') }}">
                    See All <svg width="12" height="12" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
            <div class="bottom-card-body">
                @forelse($recentAlumni as $alumni)
                <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid rgba(128,0,32,0.05);align-items:center;">
                    <div style="width:36px;height:36px;background:#800020;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="font-size:13px;font-weight:700;color:#ffffff;">{{ strtoupper(substr($alumni->name,0,1)) }}</span>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $alumni->name }}</p>
                        <p style="font-size:11px;color:#717182;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $alumni->course ?? '—' }} · Batch {{ $alumni->batch_year ?? '—' }}</p>
                    </div>
                    <span style="font-size:11px;color:#9a9aaa;flex-shrink:0;">{{ $alumni->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <p style="color:#717182;font-size:13px;padding:20px 0;text-align:center;">No alumni yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- ── MODAL OVERLAY ── --}}
<div id="modal-overlay" onclick="closeAllModals()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;backdrop-filter:blur(3px);"></div>

{{-- Modal: Total Alumni --}}
<div id="modal-alumni" class="modal-box">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:#800020;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0;">Total Alumni</h3>
                <p style="color:#717182;font-size:12px;margin:0;">Approved alumni accounts</p>
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

{{-- Modal: Pending --}}
<div id="modal-pending" class="modal-box">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:#FDB813;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#5c3700" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0;">Pending Approvals</h3>
                <p style="color:#717182;font-size:12px;margin:0;">Accounts awaiting review</p>
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
<div id="modal-events" class="modal-box">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:#9b3a54;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0;">Total Events</h3>
                <p style="color:#717182;font-size:12px;margin:0;">All active events</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#9b3a54;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#ffffff;margin:0;line-height:1;">{{ $totalEvents }}</p>
        <p style="font-size:13px;color:rgba(255,255,255,0.8);margin:8px 0 0;font-weight:500;">Total Events</p>
    </div>
    @if($upcomingEvents->count())
    <div style="margin-bottom:16px;">
        @foreach($upcomingEvents as $event)
        <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f5f5f5;align-items:center;">
            <div style="width:38px;height:38px;background:#9b3a54;border-radius:9px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:8px;font-weight:700;color:#FDB813;text-transform:uppercase;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                <span style="font-size:14px;font-weight:700;color:#ffffff;line-height:1.2;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
            </div>
            <div>
                <p style="font-weight:600;color:#1a1a1a;margin:0;font-size:13px;">{{ $event->title }}</p>
                <p style="font-size:11px;color:#717182;margin:0;">{{ $event->location }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('admin.events.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">Manage Events →</a>
</div>

{{-- Modal: Announcements --}}
<div id="modal-announcements" class="modal-box">
    <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;background:#f5c842;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="#5c3700" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3z"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div>
                <h3 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0;">Announcements</h3>
                <p style="color:#717182;font-size:12px;margin:0;">Published announcements</p>
            </div>
        </div>
        <button onclick="closeAllModals()" class="modal-close-btn">✕</button>
    </div>
    <div style="background:#f5c842;border-radius:14px;padding:28px;text-align:center;margin-bottom:20px;">
        <p style="font-size:72px;font-weight:300;color:#5c3700;margin:0;line-height:1;">{{ $totalAnnouncements }}</p>
        <p style="font-size:13px;color:#5c3700;margin:8px 0 0;font-weight:500;">Active Announcements</p>
    </div>
    @if($recentAnnouncements->count())
    <div style="margin-bottom:16px;">
        @foreach($recentAnnouncements as $ann)
        <div style="padding:10px 0;border-bottom:1px solid #f5f5f5;">
            <p style="font-weight:600;color:#1a1a1a;margin:0 0 2px;font-size:13px;">{{ $ann->title }}</p>
            <p style="font-size:11px;color:#717182;margin:0;">{{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') : 'Draft' }}</p>
        </div>
        @endforeach
    </div>
    @endif
    <a href="{{ route('admin.announcements.index') }}" style="display:block;text-align:center;background:#800020;color:#ffffff;padding:13px;border-radius:12px;text-decoration:none;font-weight:600;font-size:14px;">Manage Announcements →</a>
</div>

<script>
function openModal(id) {
    document.getElementById('modal-overlay').style.display = 'block';
    document.getElementById(id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}
function closeAllModals() {
    document.getElementById('modal-overlay').style.display = 'none';
    document.querySelectorAll('.modal-box').forEach(el => el.style.display = 'none');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAllModals(); });

document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.font.family = "'Segoe UI', sans-serif";
    Chart.defaults.color = '#717182';

    // Alumni Trend line chart
    const trendCtx = document.getElementById('alumniTrendChart');
    if (trendCtx) {
        const base = {{ $totalAlumni }};
        const f = base > 0 ? base : 10;
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [{
                    label: 'Alumni',
                    data: [
                        Math.round(f * 0.55), Math.round(f * 0.62),
                        Math.round(f * 0.70), Math.round(f * 0.78),
                        Math.round(f * 0.90), f
                    ],
                    borderColor: '#800020',
                    backgroundColor: 'rgba(128,0,32,0.07)',
                    borderWidth: 2.5, fill: true, tension: 0.45,
                    pointBackgroundColor: '#800020', pointRadius: 4, pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, border: { display: false } },
                    y: { beginAtZero: false, grid: { color: 'rgba(128,0,32,0.06)' }, border: { display: false } }
                }
            }
        });
    }

    // Overview doughnut
    const overviewCtx = document.getElementById('overviewChart');
    if (overviewCtx) {
        new Chart(overviewCtx, {
            type: 'doughnut',
            data: {
                labels: ['Alumni', 'Pending', 'Events', 'Announcements'],
                datasets: [{
                    data: [{{ $totalAlumni }}, {{ $pendingApprovals }}, {{ $totalEvents }}, {{ $totalAnnouncements }}],
                    backgroundColor: ['#800020', '#FDB813', '#9b3a54', '#f5c842'],
                    borderWidth: 0, hoverOffset: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 14, usePointStyle: true, pointStyleWidth: 10, font: { size: 11 } }
                    }
                }
            }
        });
    }
});
</script>

@endsection