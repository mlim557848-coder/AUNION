@extends('admin.layout')
@section('page-title', 'Donations')
@section('page-subtitle', 'Review, approve, and allocate alumni donations')
@section('title', 'Donations')

@section('content')
<style>
    .kpi-strip {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px;
        padding: 0;
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        overflow: hidden;
    }
    .kpi-item {
        display: flex;
        flex-direction: column;
        padding: 18px 22px;
        min-height: 100px;
        border-right: 1px solid rgba(128,0,32,0.08);
    }
    .kpi-item:last-child { border-right: none; }
    .kpi-left { display: flex; align-items: center; gap: 10px; }
    .kpi-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .kpi-label {
        font-size: 11px; font-weight: 600; color: #717182;
        text-transform: uppercase; letter-spacing: 0.05em;
        margin: 0; font-family: 'Segoe UI', sans-serif;
    }
    .kpi-value {
        font-size: 20px; font-weight: 700;
        margin-top: auto; margin-left: auto; margin-bottom: 0;
        font-family: 'Segoe UI', sans-serif; white-space: nowrap;
    }

    .period-strip {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px;
        padding: 0; margin-bottom: 24px;
        display: grid; grid-template-columns: repeat(3, 1fr);
        overflow: hidden;
    }
    .period-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 22px;
        border-right: 1px solid rgba(128,0,32,0.08);
    }
    .period-item:last-child { border-right: none; }
    .period-left { display: flex; align-items: center; gap: 10px; }

    .filters-row {
        display: flex; gap: 10px; flex-wrap: wrap;
        align-items: center; margin-bottom: 20px;
    }
    .filter-select, .filter-input {
        background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15);
        border-radius: 12px; padding: 10px 14px;
        font-size: 13px; color: #1a1a1a;
        outline: none; font-family: 'Segoe UI', sans-serif;
    }
    .filter-btn {
        background: #800020; color: #ffffff; border: none;
        border-radius: 12px; padding: 10px 20px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }

    .table-wrapper {
        background: #ffffff; border-radius: 18px;
        border: 1px solid rgba(128,0,32,0.08);
        overflow-x: auto; margin-bottom: 24px;
        -webkit-overflow-scrolling: touch;
    }
    .table-wrapper table { width: 100%; border-collapse: collapse; min-width: 680px; }

    .donation-card {
        display: none; background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px; padding: 16px; margin-bottom: 10px;
    }

    .pool-banner {
        background: linear-gradient(135deg, #800020 0%, #5a0016 100%);
        border-radius: 18px; padding: 24px 28px;
        margin-bottom: 24px; position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
    }
    .pool-banner::before {
        content: ''; position: absolute;
        bottom: -30px; right: -30px;
        width: 120px; height: 120px;
        border-radius: 50%; background: rgba(255,255,255,0.06);
    }
    .pool-banner::after {
        content: ''; position: absolute;
        top: -20px; right: 80px;
        width: 70px; height: 70px;
        border-radius: 50%; background: rgba(255,255,255,0.04);
    }

    @media (max-width: 900px) {
        .kpi-strip { grid-template-columns: repeat(2, 1fr); }
        .kpi-item:nth-child(2) { border-right: none; }
        .kpi-item:nth-child(1), .kpi-item:nth-child(2) {
            border-bottom: 1px solid rgba(128,0,32,0.08);
        }
    }
    @media (max-width: 640px) {
        .kpi-strip { grid-template-columns: repeat(2, 1fr); }
        .kpi-item { padding: 14px; }
        .kpi-value { font-size: 16px; }
        .period-strip { grid-template-columns: 1fr; }
        .period-item {
            border-right: none;
            border-bottom: 1px solid rgba(128,0,32,0.08);
            padding: 14px 16px;
        }
        .period-item:last-child { border-bottom: none; }
        .filters-row { flex-direction: column; align-items: stretch; }
        .filter-select, .filter-input, .filter-btn { width: 100%; }
        .table-wrapper { display: none; }
        .donation-card { display: block; }
        .pool-banner { flex-direction: column; align-items: flex-start; }
    }
</style>

<div style="padding: 0 32px 60px; max-width: 1280px; margin: 0 auto; font-family: 'Segoe UI', sans-serif;">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span style="font-size: 14px; color: #15803d; font-family: 'Segoe UI', sans-serif;">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size: 14px; color: #dc2626; font-family: 'Segoe UI', sans-serif;">{{ session('error') }}</span>
        </div>
    @endif

    {{-- DONATION POOL BANNER --}}
    <div class="pool-banner">
        <div style="position: relative; z-index: 1;">
            <p style="font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.65); text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif;">
                Donation Pool
            </p>
            <div style="display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap;">
                <p style="font-size: 36px; font-weight: 800; color: #ffffff; margin: 0; font-family: 'Segoe UI', sans-serif; line-height: 1;">
                    ₱{{ number_format($availablePool, 2) }}
                </p>
                <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin: 0; font-family: 'Segoe UI', sans-serif;">
                    available of ₱{{ number_format($totalApprovedAmt, 2) }} total approved
                </p>
            </div>
            @if($totalAllocated > 0)
            <div style="margin-top: 10px; display: flex; align-items: center; gap: 8px;">
                <div style="width: 160px; height: 6px; background: rgba(255,255,255,0.2); border-radius: 99px; overflow: hidden;">
                    @php $pct = $totalApprovedAmt > 0 ? min(100, ($totalAllocated / $totalApprovedAmt) * 100) : 0; @endphp
                    <div style="height: 100%; width: {{ $pct }}%; background: #FDB813; border-radius: 99px;"></div>
                </div>
                <p style="font-size: 12px; color: rgba(255,255,255,0.65); margin: 0; font-family: 'Segoe UI', sans-serif;">
                    ₱{{ number_format($totalAllocated, 2) }} allocated
                </p>
            </div>
            @endif
        </div>

        <div style="position: relative; z-index: 1; display: flex; gap: 10px; flex-wrap: wrap;">
            @if($recentAllocations->count() > 0)
            <div style="background: rgba(255,255,255,0.09); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 12px 16px; min-width: 200px;">
                <p style="font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 8px; font-family: 'Segoe UI', sans-serif;">Recent Allocations</p>
                @foreach($recentAllocations as $alloc)
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; gap: 12px;">
                    <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin: 0; font-family: 'Segoe UI', sans-serif; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;">
                        {{ $alloc->event->title ?? '—' }}
                    </p>
                    <p style="font-size: 12px; font-weight: 700; color: #FDB813; margin: 0; font-family: 'Segoe UI', sans-serif; white-space: nowrap;">
                        ₱{{ number_format($alloc->amount, 2) }}
                    </p>
                </div>
                @endforeach
            </div>
            @endif

            @if($availablePool > 0)
            <button onclick="openAllocateModal()"
                style="background: #FDB813; color: #5c3700; border: none; border-radius: 14px; padding: 14px 24px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Segoe UI', sans-serif; align-self: flex-end; white-space: nowrap; box-shadow: 0 4px 16px rgba(0,0,0,0.2);">
                Allocate Pool →
            </button>
            @else
            <div style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; padding: 14px 20px; align-self: flex-end;">
                <p style="font-size: 13px; color: rgba(255,255,255,0.5); margin: 0; font-family: 'Segoe UI', sans-serif;">No funds available</p>
            </div>
            @endif
        </div>
    </div>

    {{-- KPI Strip --}}
    <div class="kpi-strip">
        <div class="kpi-item">
            <div class="kpi-left">
                <div class="kpi-icon" style="background: rgba(128,0,32,0.07);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <p class="kpi-label">Total</p>
            </div>
            <p class="kpi-value" style="color: #800020;">{{ $totalDonations }}</p>
        </div>
        <div class="kpi-item">
            <div class="kpi-left">
                <div class="kpi-icon" style="background: rgba(253,184,19,0.15);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a5500" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <p class="kpi-label">Pending</p>
            </div>
            <p class="kpi-value" style="color: #7a5500;">{{ $pendingCount }}</p>
        </div>
        <div class="kpi-item">
            <div class="kpi-left">
                <div class="kpi-icon" style="background: rgba(21,128,61,0.08);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <p class="kpi-label">Approved</p>
            </div>
            <p class="kpi-value" style="color: #15803d;">{{ $approvedCount }}</p>
        </div>
        <div class="kpi-item">
            <div class="kpi-left">
                <div class="kpi-icon" style="background: rgba(155,58,84,0.09);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9b3a54" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <p class="kpi-label">Total (₱)</p>
            </div>
            <p class="kpi-value" style="color: #9b3a54; font-size: 16px;">₱{{ number_format($totalApprovedAmt, 2) }}</p>
        </div>
    </div>

    {{-- Period Summary Strip --}}
    <div class="period-strip">
        <div class="period-item">
            <div class="period-left">
                <div class="kpi-icon" style="background: rgba(128,0,32,0.07);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; font-family: 'Segoe UI', sans-serif;">Today</p>
            </div>
            <p style="font-size: 18px; font-weight: 700; color: #800020; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($todayTotal, 2) }}</p>
        </div>
        <div class="period-item">
            <div class="period-left">
                <div class="kpi-icon" style="background: rgba(253,184,19,0.15);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a5500" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; font-family: 'Segoe UI', sans-serif;">This Month</p>
            </div>
            <p style="font-size: 18px; font-weight: 700; color: #7a5500; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($monthTotal, 2) }}</p>
        </div>
        <div class="period-item">
            <div class="period-left">
                <div class="kpi-icon" style="background: rgba(155,58,84,0.09);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9b3a54" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; font-family: 'Segoe UI', sans-serif;">This Year</p>
            </div>
            <p style="font-size: 18px; font-weight: 700; color: #9b3a54; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($yearTotal, 2) }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.donations.index') }}">
        <div class="filters-row">
            <select name="status" class="filter-select">
                <option value="">All Statuses</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="period" class="filter-select">
                <option value="">All Time</option>
                <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Today</option>
                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year"  {{ request('period') === 'year'  ? 'selected' : '' }}>This Year</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
            <input type="date" name="date_to"   value="{{ request('date_to') }}"   class="filter-input">
            <button type="submit" class="filter-btn">Filter</button>
            @if(request()->hasAny(['status','period','date_from','date_to']))
                <a href="{{ route('admin.donations.index') }}"
                   style="color: #717182; font-size: 13px; text-decoration: none; font-family: 'Segoe UI', sans-serif; align-self: center;">Clear</a>
            @endif
        </div>
    </form>

    <p style="font-size: 12px; color: #717182; margin: 0 0 14px; font-family: 'Segoe UI', sans-serif;">
        Showing {{ $donations->firstItem() ?? 0 }}–{{ $donations->lastItem() ?? 0 }} of {{ $donations->total() }} donations
    </p>

    {{-- DESKTOP TABLE --}}
    @if($donations->count() > 0)
    <div class="table-wrapper">
        <table>
            <thead>
                <tr style="background: #800020;">
                    <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Alumni</th>
                    <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Note</th>
                    <th style="padding: 14px 18px; text-align: right; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Amount</th>
                    <th style="padding: 14px 18px; text-align: center; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Status</th>
                    <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Date</th>
                    <th style="padding: 14px 18px; text-align: right; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                @php
                    $statusStyle = match($donation->status) {
                        'approved' => 'background: #f0fdf4; color: #15803d;',
                        'rejected' => 'background: #fff1f2; color: #dc2626;',
                        default    => 'background: #fef9ec; color: #92400e;',
                    };
                @endphp
                <tr style="border-bottom: 1px solid rgba(128,0,32,0.06); background: #ffffff;"
                    onmouseover="this.style.background='#fafafa'"
                    onmouseout="this.style.background='#ffffff'">
                    <td style="padding: 14px 18px; font-family: 'Segoe UI', sans-serif;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 50%; background: #800020; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #ffffff; flex-shrink: 0;">
                                {{ strtoupper(substr($donation->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0;">{{ $donation->user->name ?? '—' }}</p>
                                <p style="font-size: 11px; color: #717182; margin: 0;">{{ $donation->user->student_id ?? '—' }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px 18px; font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif; max-width: 180px;">
                        {{ $donation->note ? \Illuminate\Support\Str::limit($donation->note, 55) : '—' }}
                    </td>
                    <td style="padding: 14px 18px; text-align: right; font-size: 15px; font-weight: 700; color: #800020; font-family: 'Segoe UI', sans-serif;">
                        ₱{{ number_format($donation->amount, 2) }}
                    </td>
                    <td style="padding: 14px 18px; text-align: center; font-family: 'Segoe UI', sans-serif;">
                        <span style="font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; {{ $statusStyle }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td style="padding: 14px 18px; font-family: 'Segoe UI', sans-serif;">
                        <p style="font-size: 13px; color: #1a1a1a; margin: 0;">{{ $donation->created_at->format('M d, Y') }}</p>
                        <p style="font-size: 11px; color: #717182; margin: 0;">{{ $donation->created_at->format('g:i A') }}</p>
                    </td>
                    <td style="padding: 14px 18px; text-align: right; font-family: 'Segoe UI', sans-serif;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center; flex-wrap: wrap;">
                            @if($donation->status === 'pending')
                                <form method="POST" action="{{ route('admin.donations.approve', $donation) }}"
                                      onsubmit="return confirm('Approve this donation of ₱{{ number_format($donation->amount, 2) }}?')">
                                    @csrf
                                    <button type="submit" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.donations.reject', $donation) }}"
                                      onsubmit="return confirm('Reject this donation?')">
                                    @csrf
                                    <button type="submit" style="background: #fff1f2; border: 1px solid #fecdd3; color: #dc2626; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Reject</button>
                                </form>
                            @elseif($donation->status === 'approved')
                                <span style="font-size: 12px; color: #15803d; font-family: 'Segoe UI', sans-serif; font-style: italic;">Approved ✓</span>
                            @else
                                <span style="font-size: 12px; color: #9ca3af; font-family: 'Segoe UI', sans-serif; font-style: italic;">No actions</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARDS --}}
    @foreach($donations as $donation)
    @php
        $badgeBg    = match($donation->status) { 'approved' => '#f0fdf4', 'rejected' => '#fff1f2', default => '#fef9ec' };
        $badgeColor = match($donation->status) { 'approved' => '#15803d', 'rejected' => '#dc2626', default => '#92400e' };
    @endphp
    <div class="donation-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: #800020; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #ffffff; flex-shrink: 0;">
                    {{ strtoupper(substr($donation->user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p style="font-size: 14px; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->user->name ?? '—' }}</p>
                    <p style="font-size: 11px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->user->student_id ?? '—' }}</p>
                </div>
            </div>
            <span style="font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; background: {{ $badgeBg }}; color: {{ $badgeColor }};">
                {{ ucfirst($donation->status) }}
            </span>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <p style="font-size: 20px; font-weight: 700; color: #800020; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($donation->amount, 2) }}</p>
            <div style="text-align: right;">
                <p style="font-size: 12px; color: #1a1a1a; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->created_at->format('M d, Y') }}</p>
                <p style="font-size: 11px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->created_at->format('g:i A') }}</p>
            </div>
        </div>
        @if($donation->note)
        <p style="font-size: 12px; color: #717182; margin: 0 0 12px; font-family: 'Segoe UI', sans-serif; line-height: 1.5;">
            {{ \Illuminate\Support\Str::limit($donation->note, 80) }}
        </p>
        @endif
        @if($donation->status === 'pending')
        <div style="display: flex; gap: 8px;">
            <form method="POST" action="{{ route('admin.donations.approve', $donation) }}" style="flex: 1;"
                  onsubmit="return confirm('Approve this donation of ₱{{ number_format($donation->amount, 2) }}?')">
                @csrf
                <button type="submit" style="width: 100%; background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; font-size: 13px; font-weight: 600; padding: 9px; border-radius: 10px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.donations.reject', $donation) }}" style="flex: 1;"
                  onsubmit="return confirm('Reject this donation?')">
                @csrf
                <button type="submit" style="width: 100%; background: #fff1f2; border: 1px solid #fecdd3; color: #dc2626; font-size: 13px; font-weight: 600; padding: 9px; border-radius: 10px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Reject</button>
            </form>
        </div>
        @endif
    </div>
    @endforeach

    {{-- Pagination --}}
    @if($donations->hasPages())
        <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-top: 8px;">
            @if($donations->onFirstPage())
                <span style="padding: 8px 16px; border-radius: 10px; background: #f3f4f6; color: #9ca3af; font-size: 13px; font-family: 'Segoe UI', sans-serif;">← Prev</span>
            @else
                <a href="{{ $donations->previousPageUrl() }}" style="padding: 8px 16px; border-radius: 10px; background: #fff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none; font-weight: 500;">← Prev</a>
            @endif
            @foreach($donations->getUrlRange(1, $donations->lastPage()) as $page => $url)
                @if($page == $donations->currentPage())
                    <span style="padding: 8px 14px; border-radius: 10px; background: #800020; color: #ffffff; font-size: 13px; font-family: 'Segoe UI', sans-serif; font-weight: 600;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding: 8px 14px; border-radius: 10px; background: #fff; border: 1px solid rgba(128,0,32,0.15); color: #1a1a1a; font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none;">{{ $page }}</a>
                @endif
            @endforeach
            @if($donations->hasMorePages())
                <a href="{{ $donations->nextPageUrl() }}" style="padding: 8px 16px; border-radius: 10px; background: #fff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none; font-weight: 500;">Next →</a>
            @else
                <span style="padding: 8px 16px; border-radius: 10px; background: #f3f4f6; color: #9ca3af; font-size: 13px; font-family: 'Segoe UI', sans-serif;">Next →</span>
            @endif
        </div>
    @endif

    @else
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.07); padding: 64px 40px; text-align: center;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity: 0.3; display: block; margin: 0 auto 16px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <p style="font-size: 15px; color: #717182; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif; font-weight: 600;">No donations found</p>
            <p style="font-size: 13px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Donations submitted by alumni will appear here.</p>
        </div>
    @endif

</div>

{{-- POOL ALLOCATE MODAL --}}
<div id="allocateModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border-radius: 20px; padding: 28px; width: 100%; max-width: 500px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 3px; font-family: 'Segoe UI', sans-serif;">Allocate Donation Pool</h2>
                <p style="font-size: 13px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Choose an event and enter the amount to allocate</p>
            </div>
            <button onclick="closeAllocateModal()"
                    style="background: #f8f8f8; border: 1px solid rgba(128,0,32,0.12); cursor: pointer; color: #717182; padding: 6px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 22px;">
            <div style="background: rgba(128,0,32,0.04); border-radius: 12px; padding: 14px 16px;">
                <p style="font-size: 11px; color: #717182; margin: 0 0 4px; font-family: 'Segoe UI', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Approved</p>
                <p style="font-size: 18px; font-weight: 700; color: #800020; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($totalApprovedAmt, 2) }}</p>
            </div>
            <div style="background: rgba(21,128,61,0.05); border-radius: 12px; padding: 14px 16px;">
                <p style="font-size: 11px; color: #717182; margin: 0 0 4px; font-family: 'Segoe UI', sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Available Pool</p>
                <p id="modalAvailable" style="font-size: 18px; font-weight: 700; color: #15803d; margin: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($availablePool, 2) }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.donations.allocate') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="font-size: 13px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 6px; font-family: 'Segoe UI', sans-serif;">Select Event <span style="color: #800020;">*</span></label>
                <select name="event_id" required
                    style="width: 100%; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;">
                    <option value="">— Choose an event —</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">
                            {{ $event->title }} ({{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-size: 13px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 6px; font-family: 'Segoe UI', sans-serif;">
                    Amount <span style="color: #800020;">*</span>
                    <span style="font-weight: 400; color: #717182;">(max ₱{{ number_format($availablePool, 2) }})</span>
                </label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 14px; color: #717182; font-family: 'Segoe UI', sans-serif;">₱</span>
                    <input type="number" name="amount" id="allocateAmountInput"
                        min="1" max="{{ $availablePool }}" step="0.01"
                        placeholder="0.00"
                        oninput="updateRemaining(this.value)"
                        required
                        style="width: 100%; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; padding: 11px 14px 11px 28px; font-size: 14px; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;">
                </div>
                <p id="remainingIndicator" style="font-size: 12px; color: #717182; margin: 5px 0 0; font-family: 'Segoe UI', sans-serif; display: none;">
                    Remaining after allocation: <strong id="remainingAmt" style="color: #15803d;"></strong>
                </p>
            </div>

            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px;">
                @php $suggestions = [500, 1000, 2000, 5000]; @endphp
                @foreach($suggestions as $s)
                    @if($s <= $availablePool)
                    <button type="button" onclick="setAmount({{ $s }})"
                        style="background: rgba(128,0,32,0.06); border: 1px solid rgba(128,0,32,0.12); color: #800020; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                        ₱{{ number_format($s) }}
                    </button>
                    @endif
                @endforeach
                <button type="button" onclick="setAmount({{ $availablePool }})"
                    style="background: rgba(128,0,32,0.06); border: 1px solid rgba(128,0,32,0.12); color: #800020; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                    Max
                </button>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="font-size: 13px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 6px; font-family: 'Segoe UI', sans-serif;">Note <span style="color: #717182; font-weight: 400;">(optional)</span></label>
                <input type="text" name="note" placeholder="e.g. Budget allocation for venue"
                    style="width: 100%; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; padding: 11px 14px; font-size: 14px; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;">
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeAllocateModal()"
                    style="flex: 1; padding: 12px; background: #ffffff; color: #717182; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                    Cancel
                </button>
                <button type="submit"
                    style="flex: 2; padding: 12px; background: #800020; color: #ffffff; border: none; border-radius: 12px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                    Allocate to Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const availablePool = {{ $availablePool }};

function openAllocateModal() {
    document.getElementById('allocateModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeAllocateModal() {
    document.getElementById('allocateModal').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('allocateModal').addEventListener('click', function(e) {
    if (e.target === this) closeAllocateModal();
});
function setAmount(val) {
    const input = document.getElementById('allocateAmountInput');
    input.value = val;
    updateRemaining(val);
}
function updateRemaining(val) {
    const indicator = document.getElementById('remainingIndicator');
    const remainingEl = document.getElementById('remainingAmt');
    const num = parseFloat(val);
    if (!isNaN(num) && num > 0) {
        const remaining = availablePool - num;
        indicator.style.display = 'block';
        if (remaining < 0) {
            remainingEl.textContent = '— exceeds available pool';
            remainingEl.style.color = '#dc2626';
        } else {
            remainingEl.textContent = '₱' + remaining.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            remainingEl.style.color = '#15803d';
        }
    } else {
        indicator.style.display = 'none';
    }
}
</script>

@endsection