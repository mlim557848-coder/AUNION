@extends('admin.layout')

@section('title', 'Alumni Profile')
@section('page-title', 'Alumni Profile')
@section('page-subtitle', 'Detailed alumni information')

@section('content')
<style>
    .ap-wrap {
        padding: 40px 48px 60px;
        max-width: 1280px;
        margin: 0 auto;
        font-family: 'Segoe UI', sans-serif;
    }

    /* ── Breadcrumb ── */
    .ap-breadcrumb {
        display: flex; align-items: center; gap: 8px; margin-bottom: 28px;
    }
    .ap-breadcrumb a {
        color: #717182; font-size: 13px; text-decoration: none;
        display: flex; align-items: center; gap: 6px;
        transition: color 0.2s;
    }
    .ap-breadcrumb a:hover { color: #800020; }
    .ap-breadcrumb .sep   { color: #d0d0d8; font-size: 13px; }
    .ap-breadcrumb .cur   { color: #1a1a1a; font-size: 13px; font-weight: 600; overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:200px; }

    /* ── Hero ── */
    .ap-hero {
        background: linear-gradient(135deg, #800020 0%, #5a0016 100%);
        border-radius: 20px;
        padding: 40px 44px;
        position: relative; overflow: hidden;
        margin-bottom: 28px;
    }
    .ap-hero-inner {
        display: flex; align-items: center; gap: 36px;
        position: relative; z-index: 1;
    }
    .ap-hero-body { flex: 1; min-width: 0; }
    .ap-hero-actions {
        display: flex; flex-direction: column; gap: 10px; flex-shrink: 0;
    }
    .ap-hero-pills { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }
    .ap-hero-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 50px; padding: 6px 14px;
    }
    .ap-hero-pill span { font-size: 12px; color: rgba(255,255,255,0.85); font-weight: 500; }

    /* Hero action buttons */
    .btn-hero-pdf {
        display: inline-flex; align-items: center; gap: 8px;
        background: #FDB813; color: #5c3700;
        padding: 11px 22px; border-radius: 8px;
        text-decoration: none; font-weight: 700; font-size: 13px;
        box-shadow: 0 4px 14px rgba(253,184,19,0.4);
        white-space: nowrap;
    }
    .btn-hero-back {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.12); color: #ffffff;
        padding: 11px 22px; border-radius: 8px;
        text-decoration: none; font-weight: 600; font-size: 13px;
        border: 1.5px solid rgba(255,255,255,0.25);
        white-space: nowrap;
    }

    /* ── KPI Strip ── */
    .ap-kpi-strip {
        display: grid; grid-template-columns: repeat(4,1fr);
        gap: 16px; margin-bottom: 32px;
    }
    .ap-kpi-mini {
        border-radius: 14px; padding: 20px 22px;
        position: relative; overflow: hidden;
    }
    .ap-kpi-mini-circle {
        position: absolute; bottom: -14px; right: -14px;
        width: 60px; height: 60px; border-radius: 50%;
    }
    .ap-kpi-mini-label { font-size: 12px; font-weight: 600; margin: 0 0 8px; }
    .ap-kpi-mini-value { font-size: 18px; font-weight: 700; margin: 0; }
    .ap-kpi-mini-value-lg { font-size: 28px; font-weight: 300; line-height: 1; margin: 0; }

    /* ── Main grid ── */
    .ap-main-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 24px;
    }
    .ap-col { display: flex; flex-direction: column; gap: 24px; }

    /* ── Detail cards ── */
    .ap-detail-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(128,0,32,0.08);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .ap-detail-card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid rgba(128,0,32,0.07);
        display: flex; align-items: center; gap: 10px;
    }
    .ap-detail-card-icon {
        width: 34px; height: 34px;
        background: rgba(128,0,32,0.08); border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ap-detail-card-header h3 { font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0; }
    .ap-detail-card-body { padding: 20px 24px; }

    /* ── Info row item ── */
    .ap-info-item {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 16px;
        background: #fafafa; border-radius: 10px;
        border: 1px solid rgba(128,0,32,0.06);
        margin-bottom: 12px;
    }
    .ap-info-item:last-child { margin-bottom: 0; }
    .ap-info-icon {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }
    .ap-info-label {
        font-size: 11px; color: #717182; margin: 0 0 3px;
        text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;
    }
    .ap-info-value { font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0; }

    /* ── Academic row ── */
    .ap-acad-item {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 16px;
        background: #fafafa; border-radius: 10px;
        border: 1px solid rgba(128,0,32,0.06);
        margin-bottom: 12px;
    }
    .ap-acad-item:last-child { margin-bottom: 0; }
    .ap-acad-icon {
        width: 38px; height: 38px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    /* ── System info ── */
    .ap-sys-card {
        background: #fafafa; border-radius: 14px;
        border: 1px solid rgba(128,0,32,0.07); padding: 18px 22px;
    }
    .ap-sys-label { font-size: 11px; font-weight: 700; color: #717182; text-transform: uppercase; letter-spacing: 0.7px; margin: 0 0 14px; }
    .ap-sys-row { display: flex; justify-content: space-between; align-items: center; }
    .ap-sys-row span:first-child { font-size: 12px; color: #717182; }
    .ap-sys-row span:last-child  { font-size: 12px; font-weight: 700; color: #1a1a1a; }
    .ap-sys-divider { height: 1px; background: rgba(128,0,32,0.05); margin: 10px 0; }

    /* ── Admin action buttons ── */
    .btn-approve-full {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #800020; color: #ffffff; padding: 12px 20px;
        border-radius: 10px; border: none; cursor: pointer;
        font-size: 14px; font-weight: 700; font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 4px 14px rgba(128,0,32,0.25);
        margin-bottom: 10px;
    }
    .btn-reject-full {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #fff; color: #800020; padding: 12px 20px;
        border-radius: 10px; border: 2px solid rgba(128,0,32,0.25); cursor: pointer;
        font-size: 14px; font-weight: 700; font-family: 'Segoe UI', sans-serif;
        margin-bottom: 10px;
    }
    .btn-action-gold {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #FDB813; color: #5c3700; padding: 12px 20px;
        border-radius: 10px; text-decoration: none;
        font-size: 14px; font-weight: 700; font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 4px 14px rgba(253,184,19,0.3);
        margin-bottom: 10px;
    }
    .btn-action-ghost {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #fafafa; color: #1a1a1a; padding: 12px 20px;
        border-radius: 10px; text-decoration: none;
        font-size: 14px; font-weight: 600; font-family: 'Segoe UI', sans-serif;
        border: 1px solid rgba(128,0,32,0.1);
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 900px) {
        .ap-main-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .ap-wrap { padding: 20px 16px 48px; }

        /* Hero stacks vertically */
        .ap-hero { padding: 28px 20px; border-radius: 16px; }
        .ap-hero-inner { flex-direction: column; align-items: flex-start; gap: 20px; }
        .ap-hero-actions {
            flex-direction: row; flex-wrap: wrap; width: 100%;
        }
        .btn-hero-pdf, .btn-hero-back { flex: 1; justify-content: center; }

        /* Hero name */
        .ap-hero-inner h1 { font-size: 22px !important; }

        /* KPI strip: 2×2 grid */
        .ap-kpi-strip { grid-template-columns: repeat(2,1fr); gap: 12px; margin-bottom: 24px; }
        .ap-kpi-mini { padding: 16px 18px; }

        /* Main grid single column */
        .ap-main-grid { grid-template-columns: 1fr; gap: 16px; }

        /* Detail cards */
        .ap-detail-card-body { padding: 16px; }
        .ap-detail-card-header { padding: 16px 16px 12px; }

        /* Breadcrumb */
        .ap-breadcrumb { margin-bottom: 16px; }
        .ap-breadcrumb .cur { max-width: 140px; }
    }

    @media (max-width: 480px) {
        .ap-kpi-strip { grid-template-columns: 1fr 1fr; gap: 10px; }
        .ap-kpi-mini-value-lg { font-size: 22px; }
        .ap-hero-pills .ap-hero-pill { padding: 5px 10px; }
        .ap-hero-pill span { font-size: 11px; }
    }
</style>

<div class="ap-wrap">

    {{-- Breadcrumb --}}
    <div class="ap-breadcrumb">
        <a href="{{ route('admin.alumni-records.index') }}">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Alumni Records
        </a>
        <span class="sep">/</span>
        <span class="cur">{{ $user->name }}</span>
    </div>

    {{-- Hero Banner --}}
    <div class="ap-hero">
        <div style="position:absolute;top:-60px;right:-40px;width:280px;height:280px;border-radius:50%;background:rgba(253,184,19,0.07);"></div>
        <div style="position:absolute;bottom:-80px;right:200px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>

        <div class="ap-hero-inner">
            {{-- Avatar --}}
            @if($user->profile_photo)
                <img src="{{ asset('profile_photos/' . $user->profile_photo) }}"
                     alt="{{ $user->name }}"
                     style="width:96px;height:96px;border-radius:50%;object-fit:cover;border:3px solid rgba(253,184,19,0.5);flex-shrink:0;">
            @else
                <div style="width:96px;height:96px;border-radius:50%;background:rgba(253,184,19,0.2);border:3px solid rgba(253,184,19,0.5);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="font-size:36px;font-weight:700;color:#FDB813;line-height:1;">
                        {{ strtoupper(substr($user->name,0,1)) }}{{ strtoupper(substr(strstr($user->name,' ') ?: ' ',1,1)) }}
                    </span>
                </div>
            @endif

            {{-- Name + meta --}}
            <div class="ap-hero-body">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;flex-wrap:wrap;">
                    <h1 style="font-size:28px;font-weight:700;color:#ffffff;margin:0;line-height:1.2;">{{ $user->name }}</h1>
                    @if($user->is_archived)
                        <span style="background:rgba(113,113,130,0.25);border:1px solid rgba(113,113,130,0.4);color:#d0d0d8;font-size:11px;font-weight:700;padding:4px 14px;border-radius:50px;text-transform:uppercase;">Archived</span>
                    @elseif($user->is_approved)
                        <span style="background:rgba(253,184,19,0.2);border:1px solid rgba(253,184,19,0.4);color:#FDB813;font-size:11px;font-weight:700;padding:4px 14px;border-radius:50px;text-transform:uppercase;">Active</span>
                    @else
                        <span style="background:rgba(255,200,0,0.15);border:1px solid rgba(255,200,0,0.3);color:#ffd970;font-size:11px;font-weight:700;padding:4px 14px;border-radius:50px;text-transform:uppercase;">Pending</span>
                    @endif
                </div>
                <p style="color:rgba(255,255,255,0.7);font-size:15px;margin:0 0 0;line-height:1.5;">
                    @if($user->current_position){{ $user->current_position }}@if($user->industry) &bull; {{ $user->industry }}@endif<br>@endif
                    Class of {{ $user->batch_year ?? '—' }} &bull; {{ $user->course ?? 'No course on file' }}
                </p>
                <div class="ap-hero-pills">
                    @if($user->student_id)
                    <div class="ap-hero-pill">
                        <svg width="12" height="12" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        <span>ID: {{ $user->student_id }}</span>
                    </div>
                    @endif
                    @if($user->batch_year)
                    <div class="ap-hero-pill">
                        <svg width="12" height="12" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span>Batch {{ $user->batch_year }}</span>
                    </div>
                    @endif
                    <div class="ap-hero-pill">
                        <svg width="12" height="12" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>Alumni</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="ap-hero-actions">
                <a href="{{ route('admin.alumni-records.export-pdf', $user) }}" class="btn-hero-pdf">
                    <svg width="15" height="15" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.alumni-records.index') }}" class="btn-hero-back">
                    <svg width="15" height="15" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    {{-- KPI Strip --}}
    <div class="ap-kpi-strip">
        <div class="ap-kpi-mini" style="background:#800020;">
            <div class="ap-kpi-mini-circle" style="background:rgba(255,255,255,0.07);"></div>
            <p class="ap-kpi-mini-label" style="color:rgba(255,255,255,0.8);">Account Status</p>
            <p class="ap-kpi-mini-value" style="color:#ffffff;">
                @if($user->is_archived) Archived @elseif($user->is_approved) Approved @else Pending @endif
            </p>
        </div>
        <div class="ap-kpi-mini" style="background:#FDB813;">
            <div class="ap-kpi-mini-circle" style="background:rgba(255,255,255,0.22);"></div>
            <p class="ap-kpi-mini-label" style="color:rgba(92,55,0,0.8);">Events RSVP'd</p>
            <p class="ap-kpi-mini-value-lg" style="color:#5c3700;">{{ $user->attendees()->count() ?? 0 }}</p>
        </div>
        <div class="ap-kpi-mini" style="background:#9b3a54;">
            <div class="ap-kpi-mini-circle" style="background:rgba(255,255,255,0.07);"></div>
            <p class="ap-kpi-mini-label" style="color:rgba(255,255,255,0.8);">Connections</p>
            <p class="ap-kpi-mini-value-lg" style="color:#ffffff;">
                {{ \App\Models\Connection::where(function($q) use ($user) {
                    $q->where('requester_id', $user->id)->orWhere('receiver_id', $user->id);
                })->where('status', 'accepted')->count() }}
            </p>
        </div>
        <div class="ap-kpi-mini" style="background:#f5c842;">
            <div class="ap-kpi-mini-circle" style="background:rgba(255,255,255,0.22);"></div>
            <p class="ap-kpi-mini-label" style="color:rgba(92,55,0,0.8);">Member Since</p>
            <p class="ap-kpi-mini-value" style="color:#5c3700;">{{ $user->created_at->format('M Y') }}</p>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="ap-main-grid">

        {{-- LEFT COLUMN --}}
        <div class="ap-col">

            {{-- Professional Info --}}
            <div class="ap-detail-card">
                <div class="ap-detail-card-header">
                    <div class="ap-detail-card-icon">
                        <svg width="16" height="16" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                    <h3>Professional Information</h3>
                </div>
                <div class="ap-detail-card-body">
                    @if($user->current_position || $user->industry)
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                        @if($user->current_position)
                        <div>
                            <p style="font-size:11px;font-weight:600;color:#717182;text-transform:uppercase;letter-spacing:0.6px;margin:0 0 4px;">Current Position</p>
                            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin:0;">{{ $user->current_position }}</p>
                        </div>
                        @endif
                        @if($user->industry)
                        <div>
                            <p style="font-size:11px;font-weight:600;color:#717182;text-transform:uppercase;letter-spacing:0.6px;margin:0 0 4px;">Industry</p>
                            <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin:0;">{{ $user->industry }}</p>
                        </div>
                        @endif
                    </div>
                    @else
                    <p style="color:#717182;font-size:13px;font-style:italic;margin:0 0 16px;">No professional information provided.</p>
                    @endif

                    @if($user->skills)
                    <div>
                        <p style="font-size:11px;font-weight:600;color:#717182;text-transform:uppercase;letter-spacing:0.6px;margin:0 0 10px;">Skills</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            @foreach(array_filter(array_map('trim', (array) $user->skills)) as $skill)
                            <span style="background:rgba(128,0,32,0.08);color:#800020;font-size:12px;font-weight:600;padding:5px 12px;border-radius:50px;border:1px solid rgba(128,0,32,0.12);">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($user->linkedin)
                    <div style="margin-top:20px;padding-top:18px;border-top:1px solid #f5f5f5;">
                        <p style="font-size:11px;font-weight:600;color:#717182;text-transform:uppercase;letter-spacing:0.6px;margin:0 0 8px;">LinkedIn</p>
                        <a href="{{ $user->linkedin }}" target="_blank" style="display:inline-flex;align-items:center;gap:8px;color:#0a66c2;font-size:13px;font-weight:600;text-decoration:none;">
                            <svg width="14" height="14" fill="#0a66c2" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                            View LinkedIn Profile
                            <svg width="11" height="11" fill="none" stroke="#0a66c2" stroke-width="2" viewBox="0 0 24 24"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Academic Background --}}
            <div class="ap-detail-card">
                <div class="ap-detail-card-header">
                    <div class="ap-detail-card-icon">
                        <svg width="16" height="16" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <h3>Academic Background</h3>
                </div>
                <div class="ap-detail-card-body">
                    @if($user->course)
                    <div class="ap-acad-item">
                        <div class="ap-acad-icon" style="background:#800020;">
                            <svg width="16" height="16" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <div>
                            <p style="font-size:11px;color:#717182;margin:0 0 2px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Program</p>
                            <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin:0;">{{ $user->course }}</p>
                        </div>
                    </div>
                    @endif
                    @if($user->batch_year)
                    <div class="ap-acad-item">
                        <div class="ap-acad-icon" style="background:#FDB813;">
                            <svg width="16" height="16" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <p style="font-size:11px;color:#717182;margin:0 0 2px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Graduation Year</p>
                            <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin:0;">
                                Class of {{ $user->batch_year }}
                                <span style="background:#FDB813;color:#5c3700;font-size:10px;font-weight:700;padding:2px 8px;border-radius:50px;margin-left:8px;">{{ $user->batch_year }}</span>
                            </p>
                        </div>
                    </div>
                    @endif
                    @if($user->student_id)
                    <div class="ap-acad-item">
                        <div class="ap-acad-icon" style="background:#9b3a54;">
                            <svg width="16" height="16" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        </div>
                        <div>
                            <p style="font-size:11px;color:#717182;margin:0 0 2px;text-transform:uppercase;letter-spacing:0.5px;font-weight:600;">Student ID</p>
                            <p style="font-size:14px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Courier New',monospace;">{{ $user->student_id }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="ap-col">

            {{-- Contact Information --}}
            <div class="ap-detail-card">
                <div class="ap-detail-card-header">
                    <div class="ap-detail-card-icon">
                        <svg width="16" height="16" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.61 19a19.45 19.45 0 0 1-6-6A19.79 19.79 0 0 1 3.1 4.18 2 2 0 0 1 5.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <h3>Contact Information</h3>
                </div>
                <div class="ap-detail-card-body">
                    <div class="ap-info-item">
                        <div class="ap-info-icon" style="background:#800020;">
                            <svg width="14" height="14" fill="none" stroke="#ffffff" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p class="ap-info-label">Login Email</p>
                            <p class="ap-info-value" style="word-break:break-all;">{{ $user->email }}</p>
                        </div>
                    </div>
                    @if($user->contact_email && $user->contact_email !== $user->email)
                    <div class="ap-info-item">
                        <div class="ap-info-icon" style="background:rgba(128,0,32,0.1);">
                            <svg width="14" height="14" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p class="ap-info-label">Contact Email</p>
                            <p class="ap-info-value" style="word-break:break-all;">{{ $user->contact_email }}</p>
                        </div>
                    </div>
                    @endif
                    @if($user->phone)
                    <div class="ap-info-item">
                        <div class="ap-info-icon" style="background:rgba(128,0,32,0.1);">
                            <svg width="14" height="14" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.61 19a19.45 19.45 0 0 1-6-6A19.79 19.79 0 0 1 3.1 4.18 2 2 0 0 1 5.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L9.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <div>
                            <p class="ap-info-label">Phone</p>
                            <p class="ap-info-value">{{ $user->phone }}</p>
                        </div>
                    </div>
                    @endif
                    @if($user->address)
                    <div class="ap-info-item">
                        <div class="ap-info-icon" style="background:rgba(128,0,32,0.1);">
                            <svg width="14" height="14" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <p class="ap-info-label">Address</p>
                            <p class="ap-info-value" style="line-height:1.5;">{{ $user->address }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Admin Actions --}}
            <div class="ap-detail-card">
                <div class="ap-detail-card-header">
                    <div class="ap-detail-card-icon">
                        <svg width="16" height="16" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    </div>
                    <h3>Admin Actions</h3>
                </div>
                <div class="ap-detail-card-body">
                    @if(!$user->is_approved && !$user->is_archived)
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                        @csrf
                        <button type="submit" class="btn-approve-full">
                            <svg width="15" height="15" fill="none" stroke="#ffffff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Approve Account
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Reject this alumni account?')" class="btn-reject-full">
                            <svg width="15" height="15" fill="none" stroke="#800020" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Reject Account
                        </button>
                    </form>
                    @elseif($user->is_approved && !$user->is_archived)
                    <div style="display:flex;align-items:center;gap:10px;padding:14px 16px;background:rgba(128,0,32,0.04);border-radius:10px;border:1px solid rgba(128,0,32,0.1);margin-bottom:10px;">
                        <div style="width:8px;height:8px;border-radius:50%;background:#800020;flex-shrink:0;"></div>
                        <p style="font-size:13px;color:#800020;font-weight:600;margin:0;">Account is active and approved</p>
                    </div>
                    @endif

                    <a href="{{ route('admin.alumni-records.export-pdf', $user) }}" class="btn-action-gold">
                        <svg width="15" height="15" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Export Alumni PDF
                    </a>
                    <a href="{{ route('admin.events.index') }}" class="btn-action-ghost">
                        <svg width="15" height="15" fill="none" stroke="#800020" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        View All Events
                    </a>
                </div>
            </div>

            {{-- System Info --}}
            <div class="ap-sys-card">
                <p class="ap-sys-label">System Information</p>
                <div class="ap-sys-row">
                    <span>User ID</span>
                    <span style="font-family:'Courier New',monospace;">#{{ $user->id }}</span>
                </div>
                <div class="ap-sys-divider"></div>
                <div class="ap-sys-row">
                    <span>Role</span>
                    <span style="text-transform:capitalize;">{{ $user->role ?? 'alumni' }}</span>
                </div>
                <div class="ap-sys-divider"></div>
                <div class="ap-sys-row">
                    <span>Registered</span>
                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                </div>
                <div class="ap-sys-divider"></div>
                <div class="ap-sys-row">
                    <span>Last Updated</span>
                    <span>{{ $user->updated_at->format('M d, Y') }}</span>
                </div>
                @if($user->master_alumni_id)
                <div class="ap-sys-divider"></div>
                <div class="ap-sys-row">
                    <span>Master ID</span>
                    <span style="font-family:'Courier New',monospace;">{{ $user->master_alumni_id }}</span>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection