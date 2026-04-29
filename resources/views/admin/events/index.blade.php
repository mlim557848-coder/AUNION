@extends('admin.layout')
@section('page-title', 'Event Management')
@section('page-subtitle', 'Create and manage alumni events')
@section('title', 'Event Management')

@section('content')
<style>
/* ── Base wrapper ── */
.ev-wrap {
    padding: 32px 32px 60px;
    max-width: 1280px;
    margin: 0 auto;
    font-family: 'Segoe UI', sans-serif;
}

/* ── Summary bar ── */
/* ── Summary bar ── */
.ev-summary-bar {
    background: #ffffff;
    border: 1px solid rgba(128,0,32,0.08);
    border-radius: 14px;
    padding: 14px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 0;
}
.ev-sum-item {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    padding: 0 24px;
}
.ev-sum-item:first-child { padding-left: 0; }
.ev-sum-item:last-child  { padding-right: 0; }
.ev-sum-divider { width: 1px; height: 36px; background: rgba(128,0,32,0.08); flex-shrink: 0; }
.ev-sum-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ev-sum-label {
    font-size: 11px; font-weight: 600; color: #717182;
    text-transform: uppercase; letter-spacing: 0.05em; margin: 0;
    font-family: 'Segoe UI', sans-serif;
}
.ev-sum-value {
    font-size: 20px; font-weight: 700; margin: 0 0 0 auto; line-height: 1;
    font-family: 'Segoe UI', sans-serif;
}

.ev-sum-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

/* ── Filters ── */
.ev-filter-form {
    display: flex; gap: 12px; flex-wrap: wrap;
    align-items: center; margin-bottom: 20px;
}
.ev-search-wrap { position: relative; flex: 1; min-width: 220px; }
.ev-search-wrap svg {
    position: absolute; left: 12px; top: 50%;
    transform: translateY(-50%);
}
.ev-search-input {
    width: 100%; background: #f8f8f8;
    border: 1px solid rgba(128,0,32,0.15); border-radius: 12px;
    padding: 10px 14px 10px 36px; font-size: 13px; color: #1a1a1a;
    outline: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;
}
.ev-select {
    background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15);
    border-radius: 12px; padding: 10px 14px; font-size: 13px;
    color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif;
}
.ev-btn-search {
    background: #800020; color: #ffffff; border: none;
    border-radius: 12px; padding: 10px 20px; font-size: 13px;
    font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif;
}

/* ── Desktop table ── */
.ev-table-card {
    background: #ffffff; border-radius: 18px;
    border: 1px solid rgba(128,0,32,0.08); overflow: hidden;
}
.ev-table { width: 100%; border-collapse: collapse; }
.ev-table thead tr { background: #800020; }
.ev-table th {
    padding: 14px 18px; text-align: left; font-size: 12px;
    font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;
}
.ev-table th.center { text-align: center; }
.ev-table th.right  { text-align: right; }
.ev-table td {
    padding: 16px 18px;
    border-bottom: 1px solid rgba(128,0,32,0.06);
    font-family: 'Segoe UI', sans-serif;
}
.ev-table tbody tr { background: #ffffff; }
.ev-table tbody tr:hover { background: #fafafa; }

/* ── Mobile event cards (hidden on desktop) ── */
.ev-mobile-list { display: none; padding: 12px 16px; }
.ev-mobile-card {
    border: 1px solid rgba(128,0,32,0.08); border-radius: 14px;
    padding: 16px; margin-bottom: 12px; background: #ffffff;
}
.ev-mobile-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; margin-bottom: 12px; gap: 10px;
}
.ev-mobile-title {
    font-size: 15px; font-weight: 600; color: #1a1a1a;
    margin: 0 0 3px; font-family: 'Segoe UI', sans-serif;
}
.ev-mobile-desc {
    font-size: 12px; color: #717182; margin: 0;
    font-family: 'Segoe UI', sans-serif;
}
.ev-mobile-meta {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px; margin-bottom: 14px;
}
.ev-mobile-meta-label {
    font-size: 10px; font-weight: 700; color: #717182;
    text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 2px;
    font-family: 'Segoe UI', sans-serif;
}
.ev-mobile-meta-value {
    font-size: 13px; color: #1a1a1a; font-weight: 500; margin: 0;
    font-family: 'Segoe UI', sans-serif;
}
.ev-mobile-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 12px; border-top: 1px solid rgba(128,0,32,0.07);
    flex-wrap: wrap; gap: 8px;
}
.ev-mobile-actions {
    display: flex; gap: 6px; flex-wrap: wrap;
}

/* ── Action buttons ── */
.btn-view   { background: rgba(128,0,32,0.07); border: 1px solid rgba(128,0,32,0.15); color: #800020; }
.btn-budget { background: rgba(253,184,19,0.13); border: 1px solid rgba(253,184,19,0.4); color: #5c3700; }
.btn-edit   { background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); color: #1a1a1a; }
.btn-cancel { background: #fff1f2; border: 1px solid rgba(220,38,38,0.15); color: #dc2626; }
.ev-action-btn {
    font-size: 12px; font-weight: 500; padding: 6px 12px;
    border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;
    display: inline-flex; align-items: center; gap: 5px;
}

/* ── Pagination ── */
.ev-pagination {
    display: flex; justify-content: center; gap: 8px;
    flex-wrap: wrap; margin-top: 24px;
}
.pag-num-active {
    padding: 8px 14px; border-radius: 10px; background: #800020;
    color: #ffffff; font-size: 13px; font-family: 'Segoe UI', sans-serif; font-weight: 600;
}
.pag-num {
    padding: 8px 14px; border-radius: 10px; background: #ffffff;
    border: 1px solid rgba(128,0,32,0.15); color: #1a1a1a;
    font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none;
}
.pag-arrow {
    padding: 8px 16px; border-radius: 10px; background: #ffffff;
    border: 1px solid rgba(128,0,32,0.15); color: #800020;
    font-size: 13px; font-family: 'Segoe UI', sans-serif;
    text-decoration: none; font-weight: 500;
}
.pag-arrow-disabled {
    padding: 8px 16px; border-radius: 10px; background: #f3f4f6;
    color: #9ca3af; font-size: 13px; font-family: 'Segoe UI', sans-serif;
}

/* ── Empty state ── */
.ev-empty {
    background: #ffffff; border-radius: 18px;
    border: 1px solid rgba(128,0,32,0.07);
    padding: 60px 40px; text-align: center;
}

/* ════════════════════════════════
   RESPONSIVE
════════════════════════════════ */
 @media (max-width: 768px) {
    .ev-wrap { padding: 20px 16px 80px; }
    .ev-summary-bar { flex-direction: column; padding: 16px; gap: 0; }
    .ev-sum-item { padding: 10px 0 !important; width: 100%; }
    .ev-sum-divider { width: 100%; height: 1px; }
    .ev-filter-form { flex-direction: column; align-items: stretch; }
    .ev-search-wrap { min-width: 0; }
    .ev-select, .ev-btn-search { width: 100%; }
    .ev-table-card { display: none; }
    .ev-mobile-list { display: block; }
    .ev-pagination { margin-top: 16px; }
    .ev-summary-bar > div:last-child { padding-left: 0 !important; width: 100%; }
    .ev-create-btn { width: 100%; justify-content: center; }
}

@media (max-width: 480px) {
    .ev-mobile-meta { grid-template-columns: 1fr; gap: 8px; }
}
</style>

<div class="ev-wrap">


    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span style="font-size: 14px; color: #15803d; font-family: 'Segoe UI', sans-serif;">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size: 14px; color: #dc2626; font-family: 'Segoe UI', sans-serif;">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Summary Bar + Create Button --}}
{{-- Summary Bar + Create Button --}}
<div class="ev-summary-bar">
    <div class="ev-sum-item">
        <div class="ev-sum-icon" style="background: rgba(128,0,32,0.07);">
            <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <p class="ev-sum-label">Total Events</p>
        <p class="ev-sum-value" style="color:#800020;">{{ $totalEvents }}</p>
    </div>
    <div class="ev-sum-divider"></div>
    <div class="ev-sum-item">
        <div class="ev-sum-icon" style="background: rgba(253,184,19,0.15);">
            <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="#7a5500" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <p class="ev-sum-label">Upcoming</p>
        <p class="ev-sum-value" style="color:#7a5500;">{{ $upcomingEvents }}</p>
    </div>
    <div class="ev-sum-divider"></div>
    <div class="ev-sum-item">
        <div class="ev-sum-icon" style="background: rgba(155,58,84,0.09);">
            <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="#9b3a54" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <p class="ev-sum-label">This Month</p>
        <p class="ev-sum-value" style="color:#9b3a54;">{{ $thisMonthEvents }}</p>
    </div>
    <div class="ev-sum-divider"></div>
    <div class="ev-sum-item">
        <div class="ev-sum-icon" style="background: rgba(245,200,66,0.18);">
            <svg style="width:15px;height:15px;" viewBox="0 0 24 24" fill="none" stroke="#7a5500" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <p class="ev-sum-label">Total RSVPs</p>
        <p class="ev-sum-value" style="color:#7a5500;">{{ $totalAttendees }}</p>
    </div>
 </div>   

{{-- Create Button --}}
<div style="display: flex; justify-content: flex-end; margin-bottom: 20px; margin-top: -12px;">
    <button onclick="document.getElementById('createModal').style.display='flex'"
            class="ev-create-btn"
            style="background: #800020; color: #ffffff; border: none; border-radius: 12px; padding: 10px 20px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; gap: 7px; white-space: nowrap;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Create Event
    </button>
</div>


    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.events.index') }}">
        <div class="ev-filter-form">
            <div class="ev-search-wrap">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search events by title..."
                    class="ev-search-input">
            </div>
            <select name="status" class="ev-select">
                <option value="">All Statuses</option>
                <option value="upcoming"  {{ request('status') === 'upcoming'  ? 'selected' : '' }}>Upcoming</option>
                <option value="ongoing"   {{ request('status') === 'ongoing'   ? 'selected' : '' }}>Ongoing</option>
                <option value="past"      {{ request('status') === 'past'      ? 'selected' : '' }}>Past</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="ev-btn-search">Search</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.events.index') }}" style="color:#717182;font-size:13px;text-decoration:none;font-family:'Segoe UI',sans-serif;">Clear</a>
            @endif
        </div>
    </form>

    <p style="font-size: 12px; color: #717182; margin: 0 0 14px; font-family: 'Segoe UI', sans-serif;">
        Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events
    </p>

    @if($events->count() > 0)

    {{-- ── DESKTOP TABLE ── --}}
    <div class="ev-table-card">
        <table class="ev-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th class="center">RSVPs</th>
                    <th class="center">Status</th>
                    <th class="right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                @php
                    $statusStyle = match($event->status ?? 'upcoming') {
                        'upcoming'  => 'background:#f0fdf4;color:#15803d;',
                        'ongoing'   => 'background:#eff6ff;color:#1d4ed8;',
                        'past'      => 'background:#f9fafb;color:#6b7280;',
                        'cancelled' => 'background:#fff1f2;color:#dc2626;',
                        default     => 'background:#fef9ec;color:#92400e;',
                    };
                    $attendeesData = $event->attendees->map(function($a) {
                        $u = $a->user;
                        return ['name' => $u->name ?? 'Unknown', 'student_id' => $u->student_id ?? '—', 'status' => 'Attending'];
                    })->values()->toArray();
                @endphp
                <tr onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#ffffff'">
                    <td>
                        <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin:0 0 3px;">{{ $event->title }}</p>
                        @if($event->description)
                            <p style="font-size:12px;color:#717182;margin:0;">{{ Str::limit($event->description,55) }}</p>
                        @endif
                    </td>
                    <td>
                        <p style="font-size:13px;color:#1a1a1a;margin:0 0 2px;font-weight:500;">{{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }}</p>
                        @if($event->event_time)
                            <p style="font-size:12px;color:#717182;margin:0;">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                        @endif
                    </td>
                    <td style="font-size:13px;color:#717182;">{{ $event->location ?? '—' }}</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.events.attendees', $event) }}"
                           style="display:inline-flex;align-items:center;gap:5px;background:rgba(128,0,32,0.07);color:#800020;font-size:13px;font-weight:600;padding:5px 12px;border-radius:20px;text-decoration:none;font-family:'Segoe UI',sans-serif;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            {{ $event->attendees->count() }}
                        </a>
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;{{ $statusStyle }}">
                            {{ ucfirst($event->status ?? 'upcoming') }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:8px;justify-content:flex-end;align-items:center;">
                            <button type="button" class="ev-action-btn btn-view"
                                    onclick="openAttendeesModal({{ $event->id }},'{{ addslashes($event->title) }}',{{ json_encode($attendeesData) }})">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                View
                            </button>
                            <button type="button" class="ev-action-btn btn-budget"
                                    onclick="openBudgetModal({{ $event->id }},'{{ addslashes($event->title) }}')">
                                Budget
                            </button>
                            <button type="button" class="ev-action-btn btn-edit"
                                    onclick="openEditModal({{ $event->id }},'{{ addslashes($event->title) }}','{{ $event->event_date }}','{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('H:i') : '' }}','{{ addslashes($event->location ?? '') }}','{{ addslashes($event->description ?? '') }}','{{ $event->status ?? 'upcoming' }}')">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Cancel this event?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="ev-action-btn btn-cancel">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="ev-mobile-list">
        @foreach($events as $event)
        @php
            $statusStyle = match($event->status ?? 'upcoming') {
                'upcoming'  => 'background:#f0fdf4;color:#15803d;',
                'ongoing'   => 'background:#eff6ff;color:#1d4ed8;',
                'past'      => 'background:#f9fafb;color:#6b7280;',
                'cancelled' => 'background:#fff1f2;color:#dc2626;',
                default     => 'background:#fef9ec;color:#92400e;',
            };
            $attendeesData = $event->attendees->map(function($a) {
                $u = $a->user;
                return ['name' => $u->name ?? 'Unknown', 'student_id' => $u->student_id ?? '—', 'status' => 'Attending'];
            })->values()->toArray();
        @endphp
        <div class="ev-mobile-card">
            {{-- Title + Status --}}
            <div class="ev-mobile-header">
                <div style="flex:1;min-width:0;">
                    <p class="ev-mobile-title">{{ $event->title }}</p>
                    @if($event->description)
                        <p class="ev-mobile-desc">{{ Str::limit($event->description, 60) }}</p>
                    @endif
                </div>
                <span style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;white-space:nowrap;flex-shrink:0;{{ $statusStyle }}">
                    {{ ucfirst($event->status ?? 'upcoming') }}
                </span>
            </div>

            {{-- Meta grid --}}
            <div class="ev-mobile-meta">
                <div>
                    <p class="ev-mobile-meta-label">Date</p>
                    <p class="ev-mobile-meta-value">{{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }}</p>
                </div>
                <div>
                    <p class="ev-mobile-meta-label">Time</p>
                    <p class="ev-mobile-meta-value">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('g:i A') : '—' }}</p>
                </div>
                <div>
                    <p class="ev-mobile-meta-label">Location</p>
                    <p class="ev-mobile-meta-value">{{ $event->location ?? '—' }}</p>
                </div>
                <div>
                    <p class="ev-mobile-meta-label">RSVPs</p>
                    <p class="ev-mobile-meta-value" style="color:#800020;font-weight:600;">{{ $event->attendees->count() }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="ev-mobile-footer">
                <div class="ev-mobile-actions">
                    <button type="button" class="ev-action-btn btn-view"
                            onclick="openAttendeesModal({{ $event->id }},'{{ addslashes($event->title) }}',{{ json_encode($attendeesData) }})">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        View
                    </button>
                    <button type="button" class="ev-action-btn btn-budget"
                            onclick="openBudgetModal({{ $event->id }},'{{ addslashes($event->title) }}')">
                        Budget
                    </button>
                    <button type="button" class="ev-action-btn btn-edit"
                            onclick="openEditModal({{ $event->id }},'{{ addslashes($event->title) }}','{{ $event->event_date }}','{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('H:i') : '' }}','{{ addslashes($event->location ?? '') }}','{{ addslashes($event->description ?? '') }}','{{ $event->status ?? 'upcoming' }}')">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </button>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Cancel this event?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="ev-action-btn btn-cancel">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($events->hasPages())
    <div class="ev-pagination">
        @if($events->onFirstPage())
            <span class="pag-arrow-disabled">← Prev</span>
        @else
            <a href="{{ $events->previousPageUrl() }}" class="pag-arrow">← Prev</a>
        @endif
        @foreach($events->getUrlRange(1, $events->lastPage()) as $page => $url)
            @if($page == $events->currentPage())
                <span class="pag-num-active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="pag-num">{{ $page }}</a>
            @endif
        @endforeach
        @if($events->hasMorePages())
            <a href="{{ $events->nextPageUrl() }}" class="pag-arrow">Next →</a>
        @else
            <span class="pag-arrow-disabled">Next →</span>
        @endif
    </div>
    @endif

    @else
    <div class="ev-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity:0.3;display:block;margin:0 auto 16px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <p style="font-size:15px;color:#717182;margin:0 0 6px;font-family:'Segoe UI',sans-serif;font-weight:600;">No events found</p>
        <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">Create your first event using the button above.</p>
    </div>
    @endif

</div>

{{-- ==================== ATTENDEES MODAL ==================== --}}
<div id="attendeesModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:1000;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#ffffff;border-radius:20px;width:100%;max-width:580px;position:relative;max-height:88vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="padding:24px 28px 20px;border-bottom:1px solid rgba(128,0,32,0.08);flex-shrink:0;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h2 id="modalEventTitle" style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0 0 4px;font-family:'Segoe UI',sans-serif;">Event Attendees</h2>
                    <p id="modalEventSubtitle" style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;"></p>
                </div>
                <button onclick="closeAttendeesModal()" style="background:#f8f8f8;border:1px solid rgba(128,0,32,0.12);cursor:pointer;color:#717182;padding:6px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>
        <div style="overflow-y:auto;flex:1;padding:0;">
            <div id="modalEmpty" style="display:none;padding:50px 28px;text-align:center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity:0.3;display:block;margin:0 auto 12px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <p style="font-size:14px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;font-weight:600;">No attendees yet</p>
                <p style="font-size:12px;color:#717182;margin:6px 0 0;font-family:'Segoe UI',sans-serif;">No alumni have RSVP'd to this event.</p>
            </div>
            <div id="modalList" style="display:none;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#fafafa;border-bottom:1px solid rgba(128,0,32,0.08);position:sticky;top:0;">
                            <th style="padding:11px 28px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">#</th>
                            <th style="padding:11px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Student ID</th>
                            <th style="padding:11px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Name</th>
                            <th style="padding:11px 14px;text-align:center;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody"></tbody>
                </table>
            </div>
        </div>
        <div style="padding:16px 28px;border-top:1px solid rgba(128,0,32,0.08);flex-shrink:0;display:flex;justify-content:space-between;align-items:center;">
            <p id="modalCount" style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;"></p>
            <button onclick="closeAttendeesModal()" style="background:#800020;color:#ffffff;border:none;border-radius:10px;padding:9px 20px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Segoe UI',sans-serif;">Close</button>
        </div>
    </div>
</div>

{{-- ==================== EDIT MODAL ==================== --}}
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#ffffff;border-radius:20px;padding:32px;width:100%;max-width:540px;position:relative;max-height:92vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div>
                <h2 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0 0 2px;font-family:'Segoe UI',sans-serif;">Edit Event</h2>
                <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">Update the event details below</p>
            </div>
            <button onclick="closeEditModal()" style="background:#f8f8f8;border:1px solid rgba(128,0,32,0.12);cursor:pointer;color:#717182;padding:6px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="editForm" method="POST" action="">
            @csrf @method('PUT')
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Event Title <span style="color:#800020;">*</span></label>
                <input type="text" id="editTitle" name="title" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                <div>
                    <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Date <span style="color:#800020;">*</span></label>
                    <input type="date" id="editDate" name="event_date" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Time <span style="color:#800020;">*</span></label>
                    <input type="time" id="editTime" name="event_time" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Location <span style="color:#800020;">*</span></label>
                <input type="text" id="editLocation" name="location" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
            </div>
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Status</label>
                <select id="editStatus" name="status" style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
                    <option value="upcoming">Upcoming</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Description</label>
                <textarea id="editDescription" name="description" rows="3" style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;resize:vertical;box-sizing:border-box;"></textarea>
            </div>
            <div style="display:flex;gap:12px;">
                <button type="button" onclick="closeEditModal()" style="flex:1;padding:12px;background:#ffffff;color:#717182;border:1px solid rgba(128,0,32,0.15);border-radius:12px;font-size:14px;font-weight:500;cursor:pointer;font-family:'Segoe UI',sans-serif;">Cancel</button>
                <button type="submit" style="flex:2;padding:12px;background:#800020;color:#ffffff;border:none;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Segoe UI',sans-serif;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== CREATE MODAL ==================== --}}
<div id="createModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1000;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#ffffff;border-radius:20px;padding:32px;width:100%;max-width:540px;position:relative;max-height:92vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div>
                <h2 style="font-size:20px;font-weight:700;color:#1a1a1a;margin:0 0 2px;font-family:'Segoe UI',sans-serif;">Create New Event</h2>
                <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">Fill in the details below</p>
            </div>
            <button onclick="document.getElementById('createModal').style.display='none'" style="background:none;border:none;cursor:pointer;color:#717182;padding:4px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.events.store') }}">
            @csrf
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Event Title <span style="color:#800020;">*</span></label>
                <input type="text" name="title" required placeholder="e.g. Alumni Homecoming 2026" style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:18px;">
                <div>
                    <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Date <span style="color:#800020;">*</span></label>
                    <input type="date" name="event_date" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Time <span style="color:#800020;">*</span></label>
                    <input type="time" name="event_time" required style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom:18px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Location <span style="color:#800020;">*</span></label>
                <input type="text" name="location" required placeholder="e.g. University Auditorium, Manila" style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;box-sizing:border-box;">
            </div>
            <div style="margin-bottom:24px;">
                <label style="font-size:13px;font-weight:600;color:#1a1a1a;display:block;margin-bottom:6px;font-family:'Segoe UI',sans-serif;">Description</label>
                <textarea name="description" rows="3" placeholder="Describe the event..." style="width:100%;background:#f8f8f8;border:1px solid rgba(128,0,32,0.15);border-radius:10px;padding:11px 14px;font-size:14px;color:#1a1a1a;outline:none;font-family:'Segoe UI',sans-serif;resize:vertical;box-sizing:border-box;"></textarea>
            </div>
            <div style="display:flex;gap:12px;">
                <button type="button" onclick="document.getElementById('createModal').style.display='none'" style="flex:1;padding:12px;background:#ffffff;color:#717182;border:1px solid rgba(128,0,32,0.15);border-radius:12px;font-size:14px;font-weight:500;cursor:pointer;font-family:'Segoe UI',sans-serif;">Cancel</button>
                <button type="submit" style="flex:2;padding:12px;background:#800020;color:#ffffff;border:none;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:'Segoe UI',sans-serif;">Create Event</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== BUDGET MODAL ==================== --}}
<div id="budgetModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:1100;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#ffffff;border-radius:20px;width:100%;max-width:600px;position:relative;max-height:88vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="padding:24px 28px 18px;border-bottom:1px solid rgba(128,0,32,0.08);flex-shrink:0;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0 0 3px;font-family:'Segoe UI',sans-serif;">Event Budget</h2>
                    <p id="budgetEventTitle" style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;"></p>
                </div>
                <button onclick="closeBudgetModal()" style="background:#f8f8f8;border:1px solid rgba(128,0,32,0.12);cursor:pointer;color:#717182;padding:6px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>
        <div style="overflow-y:auto;flex:1;padding:24px 28px;">
            <div id="budgetLoading" style="text-align:center;padding:40px;">
                <p style="color:#717182;font-size:14px;font-family:'Segoe UI',sans-serif;">Loading...</p>
            </div>
            <div id="budgetContent" style="display:none;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">
                    <div style="background:#800020;border-radius:14px;padding:16px 18px;position:relative;overflow:hidden;">
                        <div style="position:absolute;bottom:-16px;right:-16px;width:70px;height:70px;border-radius:50%;background:rgba(255,255,255,0.07);"></div>
                        <p style="font-size:12px;color:rgba(255,255,255,0.8);margin:0 0 6px;font-family:'Segoe UI',sans-serif;">Admin Allocated</p>
                        <p id="budgetStatTarget" style="font-size:22px;font-weight:700;color:#ffffff;margin:0;font-family:'Segoe UI',sans-serif;">₱0.00</p>
                        <p style="font-size:11px;color:rgba(255,255,255,0.6);margin:4px 0 0;font-family:'Segoe UI',sans-serif;">From approved donations</p>
                    </div>
                    <div style="background:#FDB813;border-radius:14px;padding:16px 18px;position:relative;overflow:hidden;">
                        <div style="position:absolute;bottom:-16px;right:-16px;width:70px;height:70px;border-radius:50%;background:rgba(255,255,255,0.18);"></div>
                        <p style="font-size:12px;color:rgba(92,55,0,0.8);margin:0 0 6px;font-family:'Segoe UI',sans-serif;">Event Donations</p>
                        <p id="budgetStatDonated" style="font-size:22px;font-weight:700;color:#5c3700;margin:0;font-family:'Segoe UI',sans-serif;">₱0.00</p>
                        <p style="font-size:11px;color:rgba(92,55,0,0.6);margin:4px 0 0;font-family:'Segoe UI',sans-serif;">Direct event donations</p>
                    </div>
                </div>
                <div style="background:rgba(128,0,32,0.04);border:1px solid rgba(128,0,32,0.1);border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p style="font-size:12px;color:#800020;margin:0;font-family:'Segoe UI',sans-serif;line-height:1.5;">Budget is allocated from approved donations in the <strong>Donations</strong> module. To allocate funds, go to Admin → Donations and click <strong>Allocate to Event</strong>.</p>
                </div>
                <div style="margin-bottom:20px;">
                    <p style="font-size:13px;font-weight:700;color:#1a1a1a;margin:0 0 10px;font-family:'Segoe UI',sans-serif;">Budget Allocations</p>
                    <div id="budgetAllocEmpty" style="display:none;text-align:center;padding:24px;background:#fafafa;border-radius:12px;border:1px solid rgba(128,0,32,0.07);">
                        <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">No budget has been allocated to this event yet.</p>
                    </div>
                    <div id="budgetAllocTable" style="display:none;border-radius:12px;overflow:hidden;border:1px solid rgba(128,0,32,0.08);">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#fafafa;border-bottom:1px solid rgba(128,0,32,0.08);">
                                    <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Allocated By</th>
                                    <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Note</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Amount</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Date</th>
                                </tr>
                            </thead>
                            <tbody id="budgetAllocBody"></tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <p style="font-size:13px;font-weight:700;color:#1a1a1a;margin:0 0 10px;font-family:'Segoe UI',sans-serif;">Direct Event Donors</p>
                    <div id="budgetDonorEmpty" style="display:none;text-align:center;padding:24px;background:#fafafa;border-radius:12px;border:1px solid rgba(128,0,32,0.07);">
                        <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">No direct donations to this event yet.</p>
                    </div>
                    <div id="budgetDonorTable" style="display:none;border-radius:12px;overflow:hidden;border:1px solid rgba(128,0,32,0.08);">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#fafafa;border-bottom:1px solid rgba(128,0,32,0.08);">
                                    <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Donor</th>
                                    <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Note</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Amount</th>
                                    <th style="padding:10px 14px;text-align:right;font-size:11px;font-weight:700;color:#717182;font-family:'Segoe UI',sans-serif;text-transform:uppercase;letter-spacing:0.05em;">Date</th>
                                </tr>
                            </thead>
                            <tbody id="budgetDonorBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding:16px 28px;border-top:1px solid rgba(128,0,32,0.08);flex-shrink:0;display:flex;justify-content:flex-end;">
            <button onclick="closeBudgetModal()" style="background:#800020;color:#ffffff;border:none;border-radius:10px;padding:9px 24px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Segoe UI',sans-serif;">Close</button>
        </div>
    </div>
</div>

<script>
// ── ATTENDEES MODAL ──
function openAttendeesModal(eventId, eventTitle, attendees) {
    document.getElementById('modalEventTitle').textContent   = eventTitle;
    document.getElementById('modalEventSubtitle').textContent = attendees.length + ' ' + (attendees.length === 1 ? 'attendee' : 'attendees');
    document.getElementById('modalCount').textContent         = attendees.length + " alumni RSVP'd";
    var tbody = document.getElementById('modalTableBody');
    tbody.innerHTML = '';
    if (attendees.length === 0) {
        document.getElementById('modalEmpty').style.display = 'block';
        document.getElementById('modalList').style.display  = 'none';
    } else {
        document.getElementById('modalEmpty').style.display = 'none';
        document.getElementById('modalList').style.display  = 'block';
        attendees.forEach(function(a, i) {
            var sc = a.status === 'Attending' ? 'background:#f0fdf4;color:#15803d;' : 'background:#fff1f2;color:#dc2626;';
            tbody.innerHTML += '<tr style="border-bottom:1px solid rgba(128,0,32,0.05);">'
                + '<td style="padding:13px 28px;font-size:13px;color:#717182;font-family:Segoe UI,sans-serif;">' + (i+1) + '</td>'
                + '<td style="padding:13px 14px;font-family:Segoe UI,sans-serif;"><span style="font-size:13px;font-weight:600;color:#800020;background:rgba(128,0,32,0.07);padding:3px 10px;border-radius:20px;">' + a.student_id + '</span></td>'
                + '<td style="padding:13px 14px;font-family:Segoe UI,sans-serif;"><div style="display:flex;align-items:center;gap:9px;"><div style="width:30px;height:30px;border-radius:50%;background:#800020;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;">' + a.name.charAt(0).toUpperCase() + '</div><span style="font-size:14px;font-weight:600;color:#1a1a1a;">' + a.name + '</span></div></td>'
                + '<td style="padding:13px 14px;text-align:center;font-family:Segoe UI,sans-serif;"><span style="font-size:11px;font-weight:600;padding:4px 12px;border-radius:20px;' + sc + '">' + a.status + '</span></td>'
                + '</tr>';
        });
    }
    document.getElementById('attendeesModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeAttendeesModal() {
    document.getElementById('attendeesModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('attendeesModal').addEventListener('click', function(e) { if (e.target === this) closeAttendeesModal(); });

// ── EDIT MODAL ──
function openEditModal(id, title, date, time, location, description, status) {
    document.getElementById('editForm').action            = '{{ url("admin/events") }}/' + id;
    document.getElementById('editTitle').value            = title;
    document.getElementById('editDate').value             = date;
    document.getElementById('editTime').value             = time;
    document.getElementById('editLocation').value         = location;
    document.getElementById('editDescription').value      = description;
    document.getElementById('editStatus').value           = status;
    document.getElementById('editModal').style.display    = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('editModal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });

// ── BUDGET MODAL ──
function openBudgetModal(eventId, eventTitle) {
    document.getElementById('budgetEventTitle').textContent = eventTitle;
    document.getElementById('budgetLoading').style.display  = 'block';
    document.getElementById('budgetContent').style.display  = 'none';
    document.getElementById('budgetModal').style.display    = 'flex';
    document.body.style.overflow = 'hidden';

    fetch('/admin/events/' + eventId + '/budget', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        var allocated = parseFloat(data.allocated_budget) || 0;
        var donated   = parseFloat(data.total_donated)   || 0;
        document.getElementById('budgetStatTarget').textContent  = '₱' + allocated.toLocaleString('en-PH', {minimumFractionDigits:2});
        document.getElementById('budgetStatDonated').textContent = '₱' + donated.toLocaleString('en-PH',   {minimumFractionDigits:2});

        var allocBody = document.getElementById('budgetAllocBody');
        allocBody.innerHTML = '';
        if (!data.allocations || data.allocations.length === 0) {
            document.getElementById('budgetAllocEmpty').style.display = 'block';
            document.getElementById('budgetAllocTable').style.display = 'none';
        } else {
            document.getElementById('budgetAllocEmpty').style.display = 'none';
            document.getElementById('budgetAllocTable').style.display = 'block';
            data.allocations.forEach(function(a) {
                allocBody.innerHTML += '<tr style="border-bottom:1px solid rgba(128,0,32,0.05);">'
                    + '<td style="padding:11px 14px;font-size:13px;font-weight:600;color:#1a1a1a;font-family:Segoe UI,sans-serif;">' + a.allocated_by + '</td>'
                    + '<td style="padding:11px 14px;font-size:12px;color:#717182;font-family:Segoe UI,sans-serif;">' + (a.note||'—') + '</td>'
                    + '<td style="padding:11px 14px;text-align:right;font-size:14px;font-weight:700;color:#800020;font-family:Segoe UI,sans-serif;">₱' + parseFloat(a.amount).toLocaleString('en-PH',{minimumFractionDigits:2}) + '</td>'
                    + '<td style="padding:11px 14px;text-align:right;font-size:12px;color:#717182;font-family:Segoe UI,sans-serif;">' + a.date + '</td>'
                    + '</tr>';
            });
        }

        var tbody = document.getElementById('budgetDonorBody');
        tbody.innerHTML = '';
        if (!data.donations || data.donations.length === 0) {
            document.getElementById('budgetDonorEmpty').style.display = 'block';
            document.getElementById('budgetDonorTable').style.display = 'none';
        } else {
            document.getElementById('budgetDonorEmpty').style.display = 'none';
            document.getElementById('budgetDonorTable').style.display = 'block';
            data.donations.forEach(function(d) {
                tbody.innerHTML += '<tr style="border-bottom:1px solid rgba(128,0,32,0.05);">'
                    + '<td style="padding:11px 14px;font-family:Segoe UI,sans-serif;"><div style="display:flex;align-items:center;gap:8px;"><div style="width:28px;height:28px;border-radius:50%;background:#800020;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0;">' + d.name.charAt(0).toUpperCase() + '</div><div><p style="font-size:13px;font-weight:600;color:#1a1a1a;margin:0;font-family:Segoe UI,sans-serif;">' + d.name + '</p><p style="font-size:11px;color:#717182;margin:0;font-family:Segoe UI,sans-serif;">' + d.student_id + '</p></div></div></td>'
                    + '<td style="padding:11px 14px;font-size:12px;color:#717182;font-family:Segoe UI,sans-serif;">' + (d.note||'—') + '</td>'
                    + '<td style="padding:11px 14px;text-align:right;font-size:14px;font-weight:700;color:#800020;font-family:Segoe UI,sans-serif;">₱' + parseFloat(d.amount).toLocaleString('en-PH',{minimumFractionDigits:2}) + '</td>'
                    + '<td style="padding:11px 14px;text-align:right;font-size:12px;color:#717182;font-family:Segoe UI,sans-serif;">' + d.date + '</td>'
                    + '</tr>';
            });
        }
        document.getElementById('budgetLoading').style.display = 'none';
        document.getElementById('budgetContent').style.display = 'block';
    })
    .catch(function() {
        document.getElementById('budgetLoading').innerHTML = '<p style="color:#dc2626;font-family:Segoe UI,sans-serif;font-size:14px;">Failed to load data.</p>';
    });
}
function closeBudgetModal() {
    document.getElementById('budgetModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('budgetModal').addEventListener('click', function(e) { if (e.target === this) closeBudgetModal(); });
</script>
@endsection     