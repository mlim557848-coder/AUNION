@extends('admin.layout')

@section('title', 'User Management')
@section('page-title', 'User Management')
@section('page-subtitle', 'Approve registrations and manage user accounts')

@section('content')
<style>
    /* ── Wrapper ── */
    .um-wrap {
        padding: 32px 32px 60px;
        max-width: 1280px;
        margin: 0 auto;
        font-family: 'Segoe UI', sans-serif;
    }


    /* ── Flash ── */
    .um-flash {
        margin-bottom: 20px;
        padding: 13px 18px;
        background: rgba(128,0,32,0.06);
        border: 1px solid rgba(128,0,32,0.15);
        border-radius: 10px;
        display: flex; align-items: center; gap: 10px;
    }
    .um-flash span { font-size: 14px; color: #800020; font-weight: 500; }

    /* ── Summary bar ── */
    .summary-bar {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px;
        padding: 16px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
    }
    .summary-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex: 1;
        padding: 0 24px;
    }
    .summary-item:first-child { padding-left: 0; }
    .summary-item:last-child  { padding-right: 0; }
    .summary-divider {
        width: 1px; height: 40px;
        background: rgba(128,0,32,0.08);
        flex-shrink: 0;
    }
    .summary-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .summary-label-group { display: flex; align-items: center; gap: 10px; }
    .summary-label {
        font-size: 11px; font-weight: 600; color: #717182;
        text-transform: uppercase; letter-spacing: 0.05em; margin: 0;
    }
    .summary-value { font-size: 22px; font-weight: 700; margin: 0; line-height: 1; }

    /* ── Main card ── */
    .um-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid rgba(128,0,32,0.08);
        overflow: hidden;
    }

    /* ── Card header ── */
    .um-card-header {
        padding: 18px 28px;
        border-bottom: 1px solid rgba(128,0,32,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .um-card-header-left { display: flex; align-items: center; gap: 10px; }
    .um-card-header-left h2 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin: 0; }

    /* ── Filter form ── */
    .filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .search-wrap { position: relative; }
    .search-wrap svg {
        position: absolute; left: 11px; top: 50%;
        transform: translateY(-50%);
        width: 15px; height: 15px; color: #717182;
    }
    .search-wrap input {
        padding: 9px 14px 9px 34px;
        font-size: 13.5px;
        border: 1px solid rgba(128,0,32,0.15);
        border-radius: 10px;
        background: #f8f8f8;
        color: #1a1a1a;
        outline: none;
        width: 230px;
        font-family: 'Segoe UI', sans-serif;
    }
    .filter-select {
        padding: 9px 14px;
        font-size: 13.5px;
        border: 1px solid rgba(128,0,32,0.15);
        border-radius: 10px;
        background: #f8f8f8;
        color: #1a1a1a;
        outline: none;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-filter {
        padding: 9px 20px;
        font-size: 13.5px; font-weight: 600;
        background: #800020; color: #ffffff;
        border: none; border-radius: 10px;
        cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-clear {
        padding: 9px 16px;
        font-size: 13.5px; font-weight: 500;
        color: #717182;
        border: 1px solid rgba(128,0,32,0.12);
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Segoe UI', sans-serif;
    }

    /* ── Desktop table ── */
    .um-table-wrap { overflow-x: auto; }
    .um-table {
        width: 100%; border-collapse: collapse;
        font-family: 'Segoe UI', sans-serif;
    }
    .um-table thead tr {
        background: #fafafa;
        border-bottom: 1px solid rgba(128,0,32,0.08);
    }
    .um-table th {
        padding: 13px 20px;
        text-align: left;
        font-size: 11.5px; font-weight: 700;
        color: #717182;
        text-transform: uppercase; letter-spacing: 0.06em;
        white-space: nowrap;
    }
    .um-table th:first-child { padding-left: 28px; }
    .um-table th:last-child  { padding-right: 28px; text-align: right; }
    .um-table td {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(128,0,32,0.05);
        font-size: 13.5px; color: #717182;
        vertical-align: middle;
    }
    .um-table td:first-child { padding-left: 28px; }
    .um-table td:last-child  { padding-right: 28px; }
    .um-table tbody tr { transition: background 0.15s; }
    .um-table tbody tr:hover { background: #fdfafb; }

    /* ── Mobile cards (hidden on desktop) ── */
    .mobile-user-list { display: none; padding: 12px 16px; }
    .mobile-user-card {
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        background: #ffffff;
    }
    .mobile-user-top {
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 12px;
    }
    .mobile-user-avatar {
        width: 42px; height: 42px;
        border-radius: 50%; background: #800020;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .mobile-user-avatar span { font-size: 16px; font-weight: 700; color: #ffffff; }
    .mobile-user-name { font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0 0 2px; }
    .mobile-user-course { font-size: 12px; color: #717182; margin: 0; }
    .mobile-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 14px;
    }
    .mobile-meta-item {}
    .mobile-meta-label {
        font-size: 10px; font-weight: 700;
        color: #717182; text-transform: uppercase;
        letter-spacing: 0.05em; margin: 0 0 2px;
    }
    .mobile-meta-value { font-size: 13px; color: #1a1a1a; font-weight: 500; margin: 0; }
    .mobile-actions {
        display: flex; gap: 8px; flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid rgba(128,0,32,0.07);
    }

    /* ── Status badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .badge-pending  { background: rgba(253,184,19,0.15); color: #7a5500; }
    .badge-pending .badge-dot  { background: #FDB813; }
    .badge-active   { background: rgba(128,0,32,0.08); color: #800020; }
    .badge-active .badge-dot   { background: #800020; }
    .badge-rejected { background: rgba(212,24,61,0.08); color: #d4183d; }
    .badge-rejected .badge-dot { background: #d4183d; }

    /* ── Action buttons ── */
    .btn-approve {
        padding: 7px 16px; font-size: 13px; font-weight: 600;
        background: #800020; color: #ffffff;
        border: none; border-radius: 8px; cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-reject {
        padding: 7px 14px; font-size: 13px; font-weight: 500;
        background: transparent; color: #d4183d;
        border: 1px solid rgba(212,24,61,0.3);
        border-radius: 8px; cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-archive {
        padding: 7px 14px; font-size: 13px; font-weight: 500;
        background: transparent; color: #717182;
        border: 1px solid rgba(128,0,32,0.15);
        border-radius: 8px; cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-restore {
        padding: 7px 16px; font-size: 13px; font-weight: 600;
        background: transparent; color: #800020;
        border: 1px solid rgba(128,0,32,0.3);
        border-radius: 8px; cursor: pointer;
        font-family: 'Segoe UI', sans-serif;
    }
    .approved-label { font-size: 13px; color: #800020; font-weight: 600; }

    /* ── Pagination ── */
    .um-pagination {
        padding: 16px 28px;
        border-top: 1px solid rgba(128,0,32,0.08);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
    }
    .um-pagination span.info { font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif; }
    .um-pagination .pag-btns { display: flex; gap: 6px; }
    .pag-btn {
        padding: 7px 14px; font-size: 13px; border-radius: 8px;
        border: 1px solid rgba(128,0,32,0.15);
        color: #800020; text-decoration: none;
        font-family: 'Segoe UI', sans-serif;
    }
    .pag-btn-disabled {
        padding: 7px 14px; font-size: 13px; border-radius: 8px;
        border: 1px solid rgba(128,0,32,0.1);
        color: #c0c0c0; cursor: not-allowed;
        font-family: 'Segoe UI', sans-serif;
    }

    /* ── Empty state ── */
    .um-empty { padding: 72px 28px; text-align: center; }
    .um-empty-icon {
        width: 60px; height: 60px;
        background: rgba(128,0,32,0.06); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .um-empty h3 { font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif; }
    .um-empty p  { font-size: 14px; color: #717182; margin: 0 0 20px; font-family: 'Segoe UI', sans-serif; }

    /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */
    @media (max-width: 768px) {
        .um-wrap { padding: 20px 16px 48px; }
        .um-heading h1 { font-size: 20px; }

        /* Summary bar → 2×2 grid */
        .summary-bar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            padding: 0;
        }
        .summary-divider { display: none; }
        .summary-item {
            padding: 16px;
            border-bottom: 1px solid rgba(128,0,32,0.08);
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .summary-item:nth-child(odd)  { border-right: 1px solid rgba(128,0,32,0.08); }
        .summary-item:nth-child(3),
        .summary-item:nth-child(4)    { border-bottom: none; }
        .summary-value { font-size: 26px; }

        /* Card header stacks */
        .um-card-header {
            padding: 14px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-form { width: 100%; }
        .search-wrap { flex: 1; min-width: 0; }
        .search-wrap input { width: 100%; }
        .filter-select { flex: 1; min-width: 0; }

        /* Hide desktop table, show mobile cards */
        .um-table-wrap { display: none; }
        .mobile-user-list { display: block; }

        /* Pagination */
        .um-pagination { padding: 14px 16px; }
    }

    @media (max-width: 480px) {
        .filter-form { flex-direction: column; align-items: stretch; }
        .search-wrap, .filter-select, .btn-filter, .btn-clear { width: 100%; }
        .btn-filter, .btn-clear { text-align: center; }
    }
</style>

<div class="um-wrap">


    {{-- Flash --}}
    @if(session('success'))
    <div class="um-flash">
        <svg style="width:17px;height:17px;color:#800020;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Summary Bar --}}
    <div class="summary-bar">
        <div class="summary-item">
            <div class="summary-label-group">
                <div class="summary-icon" style="background:rgba(253,184,19,0.15);">
                    <svg style="width:17px;height:18px;color:#7a5500;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <p class="summary-label">Pending</p>
            </div>
            <p class="summary-value" style="color:#7a5500;">{{ $pendingCount }}</p>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <div class="summary-label-group">
                <div class="summary-icon" style="background:rgba(128,0,32,0.07);">
                    <svg style="width:17px;height:17px;color:#800020;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <p class="summary-label">Active</p>
            </div>
            <p class="summary-value" style="color:#800020;">{{ $activeCount }}</p>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <div class="summary-label-group">
                <div class="summary-icon" style="background:rgba(155,58,84,0.09);">
                    <svg style="width:17px;height:17px;color:#9b3a54;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <p class="summary-label">Total Alumni</p>
            </div>
            <p class="summary-value" style="color:#9b3a54;">{{ $totalCount }}</p>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <div class="summary-label-group">
                <div class="summary-icon" style="background:rgba(212,24,61,0.07);">
                    <svg style="width:17px;height:17px;color:#d4183d;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                </div>
                <p class="summary-label">Rejected</p>
            </div>
            <p class="summary-value" style="color:#d4183d;">{{ $rejectedCount ?? 0 }}</p>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="um-card">

        {{-- Card Header --}}
        <div class="um-card-header">
            <div class="um-card-header-left">
                <h2>Registered Users</h2>
                @if(request('status'))
                    <span class="badge {{ request('status') === 'pending' ? 'badge-pending' : (request('status') === 'approved' ? 'badge-active' : 'badge-rejected') }}">
                        {{ ucfirst(request('status')) }}
                    </span>
                @endif
            </div>
            <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, ID...">
                </div>
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn-filter">Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.users.index') }}" class="btn-clear">Clear</a>
                @endif
            </form>
        </div>

        @if($users->count())

        {{-- ── DESKTOP TABLE ── --}}
        <div class="um-table-wrap">
            <table class="um-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Student ID</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:11px;">
                                <div style="width:36px;height:36px;border-radius:50%;background:#800020;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <span style="font-size:13px;font-weight:700;color:#ffffff;">{{ strtoupper(substr($user->name,0,1)) }}</span>
                                </div>
                                <div>
                                    <p style="font-size:14px;font-weight:600;color:#1a1a1a;margin:0;">{{ $user->name }}</p>
                                    @if($user->course)
                                    <p style="font-size:12px;color:#717182;margin:1px 0 0;">{{ $user->course }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->student_id)
                                <span style="font-size:13px;font-weight:600;color:#1a1a1a;background:#f4f4f4;padding:3px 9px;border-radius:6px;">{{ $user->student_id }}</span>
                            @else
                                <span style="color:#c0c0c0;">—</span>
                            @endif
                        </td>
                        <td>{{ $user->batch_year ?? '—' }}</td>
                        <td>
                            @if($user->is_archived)
                                <span class="badge badge-rejected"><span class="badge-dot"></span>Rejected</span>
                            @elseif($user->is_approved)
                                <span class="badge badge-active"><span class="badge-dot"></span>Active</span>
                            @else
                                <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:7px;">
                                @if(!$user->is_approved && !$user->is_archived)
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-approve">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.reject', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-reject">Reject</button>
                                    </form>
                                @elseif($user->is_approved && !$user->is_archived)
                                    <span class="approved-label">✓ Approved</span>
                                    <form method="POST" action="{{ route('admin.users.archive', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-archive">Archive</button>
                                    </form>
                                @elseif($user->is_archived)
                                    <form method="POST" action="{{ route('admin.users.restore', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-restore">Restore</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── MOBILE CARDS ── --}}
        <div class="mobile-user-list">
            @foreach($users as $user)
            <div class="mobile-user-card">
                <div class="mobile-user-top">
                    <div class="mobile-user-avatar">
                        <span>{{ strtoupper(substr($user->name,0,1)) }}</span>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p class="mobile-user-name">{{ $user->name }}</p>
                        <p class="mobile-user-course">{{ $user->email }}</p>
                    </div>
                    {{-- Status badge top-right --}}
                    @if($user->is_archived)
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Rejected</span>
                    @elseif($user->is_approved)
                        <span class="badge badge-active"><span class="badge-dot"></span>Active</span>
                    @else
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    @endif
                </div>

                <div class="mobile-meta-grid">
                    <div class="mobile-meta-item">
                        <p class="mobile-meta-label">Student ID</p>
                        <p class="mobile-meta-value">
                            @if($user->student_id)
                                <span style="background:#f4f4f4;padding:2px 8px;border-radius:5px;font-size:13px;">{{ $user->student_id }}</span>
                            @else
                                <span style="color:#c0c0c0;">—</span>
                            @endif
                        </p>
                    </div>
                    <div class="mobile-meta-item">
                        <p class="mobile-meta-label">Batch Year</p>
                        <p class="mobile-meta-value">{{ $user->batch_year ?? '—' }}</p>
                    </div>
                    <div class="mobile-meta-item">
                        <p class="mobile-meta-label">Course</p>
                        <p class="mobile-meta-value" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $user->course ?? '—' }}</p>
                    </div>
                    <div class="mobile-meta-item">
                        <p class="mobile-meta-label">Registered</p>
                        <p class="mobile-meta-value">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="mobile-actions">
                    @if(!$user->is_approved && !$user->is_archived)
                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-approve">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-reject">Reject</button>
                        </form>
                    @elseif($user->is_approved && !$user->is_archived)
                        <span class="approved-label">✓ Approved</span>
                        <form method="POST" action="{{ route('admin.users.archive', $user) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-archive">Archive</button>
                        </form>
                    @elseif($user->is_archived)
                        <form method="POST" action="{{ route('admin.users.restore', $user) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-restore">Restore</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="um-pagination">
            <span class="info">Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users</span>
            <div class="pag-btns">
                @if($users->onFirstPage())
                    <span class="pag-btn-disabled">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="pag-btn">← Prev</a>
                @endif
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="pag-btn">Next →</a>
                @else
                    <span class="pag-btn-disabled">Next →</span>
                @endif
            </div>
        </div>
        @endif

        @else
        {{-- Empty state --}}
        <div class="um-empty">
            <div class="um-empty-icon">
                <svg style="width:28px;height:28px;color:rgba(128,0,32,0.3);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <h3>No users found</h3>
            <p>Try adjusting your search or filter criteria</p>
            @if(request('search') || request('status'))
            <a href="{{ route('admin.users.index') }}" style="padding:9px 20px;font-size:14px;font-weight:600;background:#800020;color:#ffffff;border-radius:10px;text-decoration:none;font-family:'Segoe UI',sans-serif;">Clear Filters</a>
            @endif
        </div>
        @endif

    </div>{{-- /.um-card --}}
</div>{{-- /.um-wrap --}}
@endsection