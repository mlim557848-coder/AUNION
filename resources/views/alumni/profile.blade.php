@extends('alumni.layout')
@section('title', 'My Profile')

@push('styles')
<style>
.profile-hero {
    background:linear-gradient(135deg,#800020,#5a0016);
    border-radius:20px; padding:40px;
    position:relative; overflow:hidden; margin-bottom:28px;
    box-shadow:0 8px 32px rgba(128,0,32,0.22);
}
.profile-hero-deco { position:absolute; border-radius:50%; background:rgba(253,184,19,0.08); }
.profile-hero-inner { display:flex; align-items:flex-end; gap:28px; position:relative; z-index:1; flex-wrap:wrap; }
.profile-avatar-lg {
    width:96px; height:96px; border-radius:50%; flex-shrink:0;
    background:#FDB813; display:flex; align-items:center; justify-content:center;
    font-size:30px; font-weight:800; color:#5c3700;
    border:4px solid rgba(255,255,255,0.3); overflow:hidden;
    box-shadow:0 8px 24px rgba(0,0,0,0.2);
}
.profile-avatar-lg img { width:100%; height:100%; object-fit:cover; }
.info-pill {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(255,255,255,0.13); border:1px solid rgba(255,255,255,0.2);
    border-radius:999px; padding:7px 16px;
    font-size:13px; color:#fff; white-space:nowrap;
    transition:background 0.25s;
}
.info-pill:hover { background:rgba(255,255,255,0.2); }
.info-pill.gold { background:rgba(253,184,19,0.18); border-color:rgba(253,184,19,0.4); color:#FDB813; }

.info-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
.info-section {
    background:#fff; border-radius:16px;
    border:1px solid rgba(128,0,32,0.08); padding:24px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
    transition:box-shadow 0.3s;
}
.info-section:hover { box-shadow:0 8px 28px rgba(128,0,32,0.09); }
.info-section-title {
    font-size:12px; font-weight:700; color:#800020;
    text-transform:uppercase; letter-spacing:0.6px; margin:0 0 16px;
    padding-bottom:10px; border-bottom:1px solid rgba(128,0,32,0.08);
}
.info-row {
    display:flex; gap:11px; padding:10px 0;
    border-bottom:1px solid rgba(128,0,32,0.06); align-items:flex-start;
}
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.skill-tag {
    display:inline-block; background:#fdf0f3;
    border:1px solid rgba(128,0,32,0.14); border-radius:999px;
    padding:5px 14px; font-size:12.5px; color:#800020;
    font-weight:500; margin:3px; transition:all 0.25s;
}
.skill-tag:hover { background:#800020; color:#fff; }

@media (max-width:768px) {
    .profile-hero { padding:26px 20px; }
    .profile-hero-inner { flex-direction:column; align-items:flex-start; gap:20px; }
    .profile-avatar-lg { width:80px; height:80px; font-size:24px; }
    .pills-row { flex-wrap:wrap; }
    .info-grid { grid-template-columns:1fr; }
    .action-row { flex-direction:column !important; }
    .action-row a { text-align:center; justify-content:center; }
}
</style>
@endpush

@section('content')
@php $user = auth()->user(); $initials = strtoupper(substr($user->name,0,2)); @endphp

{{-- Hero --}}
<div class="profile-hero">
    <div class="profile-hero-deco" style="width:300px;height:300px;top:-120px;right:-80px;"></div>
    <div class="profile-hero-deco" style="width:150px;height:150px;bottom:-50px;left:30%;opacity:0.5;background:rgba(255,255,255,0.05);"></div>
    <div class="profile-hero-inner">
        <div class="profile-avatar-lg">
            @if($user->profile_photo)
                <img src="{{ asset('profile_photos/'.$user->profile_photo) }}" alt="">
            @else {{ $initials }} @endif
        </div>
        <div style="flex:1;min-width:0;">
            <h1 style="font-size:26px;font-weight:800;color:#fff;margin:0 0 5px;font-family:'Georgia',serif;">{{ $user->name }}</h1>
            @if($user->current_position)
            <p style="color:rgba(255,255,255,0.78);margin:0 0 16px;font-size:14.5px;">{{ $user->current_position }}@if($user->industry) · {{ $user->industry }}@endif</p>
            @else <div style="margin-bottom:16px;"></div> @endif
            <div class="pills-row" style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="info-pill">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    {{ $user->course ?? 'N/A' }}
                </span>
                <span class="info-pill">Batch {{ $user->batch_year ?? 'N/A' }}</span>
                @if($user->is_approved)
                <span class="info-pill gold">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    Verified Alumni
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Action Button --}}
<div class="action-row" style="display:flex;gap:10px;margin-bottom:28px;flex-wrap:wrap;">
    <a href="{{ route('alumni.profile.edit') }}" style="background:#800020;color:#fff;text-decoration:none;padding:11px 24px;border-radius:10px;font-size:14px;font-weight:600;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(128,0,32,0.25);transition:all 0.25s;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit Profile
    </a>
</div>

{{-- Info Grid --}}
<div class="info-grid">
    <div class="info-section">
        <h3 class="info-section-title">Contact Information</h3>
        @if($user->contact_email ?? $user->email)
        <div class="info-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8" style="flex-shrink:0;margin-top:2px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span style="font-size:13.5px;color:#1a1a1a;word-break:break-all;">{{ $user->contact_email ?? $user->email }}</span>
        </div>
        @endif
        @if($user->phone)
        <div class="info-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8" style="flex-shrink:0;"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.72A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
            <span style="font-size:13.5px;color:#1a1a1a;">{{ $user->phone }}</span>
        </div>
        @endif
        @if($user->linkedin)
        <div class="info-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8" style="flex-shrink:0;"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
            <a href="{{ $user->linkedin }}" target="_blank" style="font-size:13.5px;color:#800020;text-decoration:none;font-weight:500;">LinkedIn Profile ↗</a>
        </div>
        @endif
        @if($user->address)
        <div class="info-row">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8" style="flex-shrink:0;margin-top:2px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span style="font-size:13.5px;color:#1a1a1a;">{{ $user->address }}</span>
        </div>
        @endif
    </div>

    <div class="info-section">
        <h3 class="info-section-title">Career</h3>
        @if($user->current_position)
        <div style="margin-bottom:14px;">
            <div style="font-size:11px;color:#717182;text-transform:uppercase;font-weight:600;margin-bottom:4px;">Position</div>
            <div style="font-size:14px;color:#1a1a1a;font-weight:500;">{{ $user->current_position }}</div>
        </div>
        @endif
        @if($user->industry)
        <div style="margin-bottom:14px;">
            <div style="font-size:11px;color:#717182;text-transform:uppercase;font-weight:600;margin-bottom:4px;">Industry</div>
            <div style="font-size:14px;color:#1a1a1a;">{{ $user->industry }}</div>
        </div>
        @endif
        @if($user->batch_year)
        <div>
            <div style="font-size:11px;color:#717182;text-transform:uppercase;font-weight:600;margin-bottom:4px;">Graduation Year</div>
            <div style="font-size:14px;color:#1a1a1a;">{{ $user->batch_year }}</div>
        </div>
        @endif
    </div>

    @if(!empty((array)$user->skills))
    <div class="info-section" style="grid-column:1/-1;">
        <h3 class="info-section-title">Skills</h3>
        <div>
            @foreach((array)$user->skills as $skill)
                @if($skill)<span class="skill-tag">{{ $skill }}</span>@endif
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection