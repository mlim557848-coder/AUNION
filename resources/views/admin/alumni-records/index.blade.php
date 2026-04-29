@extends('admin.layout')

@section('title', 'Alumni Records')
@section('page-title', 'Alumni Records')
@section('page-subtitle', 'View alumni information and generate reports')

@section('content')
<style>
    .ar-wrap {
        padding: 32px 32px 60px;
        max-width: 1280px;
        margin: 0 auto;
        font-family: 'Segoe UI', sans-serif;
    }
    
    .ar-tabs { display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap; }
    .ar-tab {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 22px; font-size: 14px; font-weight: 600;
        border-radius: 10px; border: none; cursor: pointer;
        font-family: 'Segoe UI', sans-serif; transition: all 0.18s;
    }
    .ar-tab-active   { background: #800020; color: #ffffff; }
    .ar-tab-inactive { background: #ffffff; color: #717182; border: 1px solid rgba(128,0,32,0.2); }

    .ar-summary-bar {
        background: #ffffff;
        border: 1px solid rgba(128,0,32,0.08);
        border-radius: 14px;
        padding: 16px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 0;
    }
    .ar-sum-item {
        display: flex; align-items: center;
        justify-content: space-between;
        flex: 1;
    }
    .ar-sum-item:first-child { padding-right: 24px; }
    .ar-sum-item:not(:first-child):not(:last-child) { padding: 0 24px; }
    .ar-sum-item:last-child  { padding-left: 24px; }
    .ar-sum-divider { width: 1px; height: 40px; background: rgba(128,0,32,0.08); flex-shrink: 0; }
    .ar-sum-left  { display: flex; align-items: center; gap: 10px; }
    .ar-sum-icon  {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ar-sum-label {
        font-size: 11px; font-weight: 600; color: #717182;
        text-transform: uppercase; letter-spacing: 0.05em;
        margin: 0; font-family: 'Segoe UI', sans-serif;
    }
    .ar-sum-value {
        font-size: 22px; font-weight: 700;
        margin: 0; line-height: 1; font-family: 'Segoe UI', sans-serif;
    }

    .ar-card { background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden; }

    .ar-filter-bar { padding: 20px 28px; border-bottom: 1px solid rgba(128,0,32,0.08); }
    .ar-filter-form { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .ar-search-wrap { position: relative; flex: 1; min-width: 240px; }
    .ar-search-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #717182; }
    .ar-search-wrap input {
        width: 100%; padding: 10px 14px 10px 42px; font-size: 14px;
        border: 1px solid rgba(128,0,32,0.15); border-radius: 10px;
        background: #f8f8f8; color: #1a1a1a; outline: none;
        font-family: 'Segoe UI', sans-serif; box-sizing: border-box;
    }
    .ar-select {
        padding: 10px 14px; font-size: 14px;
        border: 1px solid rgba(128,0,32,0.15); border-radius: 10px;
        background: #f8f8f8; color: #1a1a1a; outline: none;
        font-family: 'Segoe UI', sans-serif;
    }
    .ar-btn-filter {
        padding: 10px 22px; font-size: 14px; font-weight: 500;
        background: #800020; color: #ffffff; border: none;
        border-radius: 10px; cursor: pointer; font-family: 'Segoe UI', sans-serif;
    }

    .ar-count { padding: 14px 28px; border-bottom: 1px solid rgba(128,0,32,0.05); }
    .ar-count span { font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif; }

    .ar-table-wrap { overflow-x: auto; }
    .ar-table { width: 100%; border-collapse: collapse; }
    .ar-table thead tr { background: #800020; }
    .ar-table th {
        padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600;
        color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em;
        white-space: nowrap; font-family: 'Segoe UI', sans-serif;
    }
    .ar-table th:first-child { padding-left: 28px; }
    .ar-table th:last-child  { padding-right: 28px; text-align: right; }
    .ar-table td {
        padding: 16px 20px; border-bottom: 1px solid rgba(128,0,32,0.05);
        font-size: 14px; color: #717182; vertical-align: middle;
        font-family: 'Segoe UI', sans-serif;
    }
    .ar-table td:first-child { padding-left: 28px; }
    .ar-table td:last-child  { padding-right: 28px; text-align: right; }
    .ar-table tbody tr:hover { background: #fdfafb; }

    .ar-mobile-list { display: none; padding: 12px 16px; }
    .ar-mobile-card { border: 1px solid rgba(128,0,32,0.08); border-radius: 14px; padding: 16px; margin-bottom: 12px; background: #ffffff; }
    .ar-mobile-top  { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .ar-avatar { width: 42px; height: 42px; border-radius: 50%; background: #800020; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ar-avatar span { font-size: 16px; font-weight: 600; color: #ffffff; }
    .ar-mobile-name  { font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0 0 2px; }
    .ar-mobile-email { font-size: 12px; color: #717182; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ar-mobile-meta  { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
    .ar-mobile-meta-label { font-size: 10px; font-weight: 700; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 2px; }
    .ar-mobile-meta-value { font-size: 13px; color: #1a1a1a; font-weight: 500; margin: 0; }
    .ar-mobile-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid rgba(128,0,32,0.07); flex-wrap: wrap; gap: 8px; }

    .badge-active   { display:inline-flex;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(128,0,32,0.08);color:#800020; }
    .badge-pending  { display:inline-flex;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(113,113,130,0.1);color:#717182; }

    .btn-view-profile {
        padding: 7px 18px; font-size: 13px; font-weight: 500;
        background: #800020; color: #ffffff; border-radius: 8px;
        text-decoration: none; display: inline-block; font-family: 'Segoe UI', sans-serif;
    }

    .ar-pagination { padding: 16px 28px; border-top: 1px solid rgba(128,0,32,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .ar-pagination .info { font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif; }
    .ar-pagination .pag-btns { display: flex; gap: 6px; }
    .pag-btn          { padding:7px 14px;font-size:13px;border-radius:8px;border:1px solid rgba(128,0,32,0.15);color:#800020;text-decoration:none;font-family:'Segoe UI',sans-serif; }
    .pag-btn-disabled { padding:7px 14px;font-size:13px;border-radius:8px;border:1px solid rgba(128,0,32,0.1);color:#717182;cursor:not-allowed;font-family:'Segoe UI',sans-serif; }

    .ar-empty { padding: 64px 28px; text-align: center; }
    .ar-empty-icon { width:64px;height:64px;border-radius:50%;background:rgba(128,0,32,0.07);display:flex;align-items:center;justify-content:center;margin:0 auto 16px; }
    .ar-empty p     { font-size:15px;font-weight:500;color:#1a1a1a;margin:0 0 6px;font-family:'Segoe UI',sans-serif; }
    .ar-empty small { font-size:14px;color:#717182;font-family:'Segoe UI',sans-serif; }

    /* Reports Tab */
    .report-section { background:#ffffff;border-radius:18px;border:1px solid rgba(128,0,32,0.08);padding:32px;margin-bottom:24px; }
    .report-section h2 { font-size:18px;font-weight:700;margin:0 0 6px;font-family:'Segoe UI',sans-serif; }
    .report-section > p { font-size:14px;color:#717182;margin:0 0 24px;font-family:'Segoe UI',sans-serif; }
    .report-grid-2 { display:grid;grid-template-columns:repeat(2,1fr);gap:16px; }
    .report-field label { display:block;font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:6px;font-family:'Segoe UI',sans-serif; }
    .report-field select {
        width:100%;padding:10px 14px;font-size:14px;
        border:1px solid rgba(128,0,32,0.15);border-radius:10px;
        background:#f8f8f8;color:#1a1a1a;outline:none;
        font-family:'Segoe UI',sans-serif;box-sizing:border-box;
    }
    .predefined-card { border:1px solid rgba(128,0,32,0.1);border-radius:14px;padding:22px; }
    .predefined-icon { width:44px;height:44px;border-radius:12px;background:rgba(128,0,32,0.07);display:flex;align-items:center;justify-content:center;margin-bottom:14px; }
    .predefined-card h4 { font-size:15px;font-weight:600;color:#1a1a1a;margin:0 0 6px;font-family:'Segoe UI',sans-serif; }
    .predefined-card p  { font-size:13px;color:#717182;margin:0 0 16px;font-family:'Segoe UI',sans-serif; }
    .btn-gen-pdf { display:inline-flex;align-items:center;gap:6px;padding:8px 18px;font-size:13px;font-weight:600;background:#800020;color:#ffffff;border-radius:8px;text-decoration:none;font-family:'Segoe UI',sans-serif; }

    @media (max-width: 768px) {
        .ar-wrap { padding: 20px 16px 48px; }
        .ar-summary-bar { flex-direction: column; padding: 16px; gap: 0; }
        .ar-sum-item { padding: 12px 0 !important; width: 100%; }
        .ar-sum-divider { width: 100%; height: 1px; }
        .ar-filter-bar { padding: 14px 16px; }
        .ar-filter-form { flex-direction: column; align-items: stretch; }
        .ar-search-wrap { min-width: 0; }
        .ar-select, .ar-btn-filter { width: 100%; }
        .ar-count { padding: 10px 16px; }
        .ar-table-wrap { display: none; }
        .ar-mobile-list { display: block; }
        .ar-pagination { padding: 14px 16px; }
        .report-section { padding: 20px 16px; }
        .report-grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .ar-tabs { gap: 8px; }
        .ar-tab { padding: 9px 14px; font-size: 13px; }
    }
</style>

<div class="ar-wrap">

    <div class="ar-tabs">
        <button onclick="showTab('records')" id="tab-records" class="ar-tab ar-tab-active">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Alumni Records
        </button>
        <button onclick="showTab('reports')" id="tab-reports" class="ar-tab ar-tab-inactive">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Generate Reports
        </button>
    </div>

    {{-- ── TAB 1: RECORDS ── --}}
    <div id="panel-records">

        <div class="ar-summary-bar">

            <div class="ar-sum-item" style="padding-right: 24px;">
                <div class="ar-sum-left">
                    <div class="ar-sum-icon" style="background: rgba(128,0,32,0.07);">
                        <svg style="width:17px;height:17px;color:#800020;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <p class="ar-sum-label">Total Alumni</p>
                </div>
                <p class="ar-sum-value" style="color:#800020;">{{ $totalAlumni ?? 0 }}</p>
            </div>

            <div class="ar-sum-divider"></div>

            <div class="ar-sum-item" style="padding: 0 24px;">
                <div class="ar-sum-left">
                    <div class="ar-sum-icon" style="background: rgba(253,184,19,0.15);">
                        <svg style="width:17px;height:17px;color:#7a5500;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="ar-sum-label">Approved</p>
                </div>
                <p class="ar-sum-value" style="color:#7a5500;">{{ $approvedAlumni ?? 0 }}</p>
            </div>

            <div class="ar-sum-divider"></div>

            <div class="ar-sum-item" style="padding: 0 24px;">
                <div class="ar-sum-left">
                    <div class="ar-sum-icon" style="background: rgba(155,58,84,0.09);">
                        <svg style="width:17px;height:17px;color:#9b3a54;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <p class="ar-sum-label">Batch Years</p>
                </div>
                <p class="ar-sum-value" style="color:#9b3a54;">{{ $batchYearCount ?? 0 }}</p>
            </div>

            <div class="ar-sum-divider"></div>

            <div class="ar-sum-item" style="padding-left: 24px;">
                <div class="ar-sum-left">
                    <div class="ar-sum-icon" style="background: rgba(245,200,66,0.18);">
                        <svg style="width:17px;height:17px;color:#7a5500;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <p class="ar-sum-label">Programs</p>
                </div>
                <p class="ar-sum-value" style="color:#7a5500;">{{ $courses->count() ?? 0 }}</p>
            </div>

        </div>

        <div class="ar-card">
            <div class="ar-filter-bar">
                <form method="GET" action="{{ route('admin.alumni-records.index') }}" class="ar-filter-form">
                    <div class="ar-search-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, student ID...">
                    </div>
                    <select name="batch_year" class="ar-select">
                        <option value="">All Batches</option>
                        @foreach($batchYears ?? [] as $batch)
                            <option value="{{ $batch }}" {{ request('batch_year') == $batch ? 'selected' : '' }}>{{ $batch }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="ar-select">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                    </select>
                    <button type="submit" class="ar-btn-filter">Filter</button>
                    @if(request()->hasAny(['search','batch_year','status']))
                        <a href="{{ route('admin.alumni-records.index') }}" style="color:#717182;font-size:13px;text-decoration:none;font-family:'Segoe UI',sans-serif;">Clear</a>
                    @endif
                </form>
            </div>

            <div class="ar-count">
                <span>{{ $alumni->total() ?? 0 }} records found</span>
            </div>

            @if($alumni->count())

            <div class="ar-table-wrap">
                <table class="ar-table">
                    <thead>
                        <tr>
                            <th>Alumni</th>
                            <th>Student ID</th>
                            <th>Batch</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $alum)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div class="ar-avatar" style="width:38px;height:38px;">
                                        <span style="font-size:14px;">{{ strtoupper(substr($alum->name,0,1)) }}</span>
                                    </div>
                                    <div>
                                        <p style="font-size:15px;font-weight:500;color:#1a1a1a;margin:0 0 2px;font-family:'Segoe UI',sans-serif;">{{ $alum->name }}</p>
                                        <p style="font-size:13px;color:#717182;margin:0;font-family:'Segoe UI',sans-serif;">{{ $alum->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $alum->student_id ?? '—' }}</td>
                            <td>{{ $alum->batch_year ?? '—' }}</td>
                            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $alum->course ?? '—' }}</td>
                            <td>
                                @if($alum->is_approved)
                                    <span class="badge-active">Approved</span>
                                @else
                                    <span class="badge-pending">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.alumni-records.show', $alum) }}" class="btn-view-profile">View Profile</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="ar-mobile-list">
                @foreach($alumni as $alum)
                <div class="ar-mobile-card">
                    <div class="ar-mobile-top">
                        <div class="ar-avatar">
                            <span>{{ strtoupper(substr($alum->name,0,1)) }}</span>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p class="ar-mobile-name">{{ $alum->name }}</p>
                            <p class="ar-mobile-email">{{ $alum->email }}</p>
                        </div>
                        @if($alum->is_approved)
                            <span class="badge-active">Approved</span>
                        @else
                            <span class="badge-pending">Pending</span>
                        @endif
                    </div>
                    <div class="ar-mobile-meta">
                        <div>
                            <p class="ar-mobile-meta-label">Student ID</p>
                            <p class="ar-mobile-meta-value">{{ $alum->student_id ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="ar-mobile-meta-label">Batch Year</p>
                            <p class="ar-mobile-meta-value">{{ $alum->batch_year ?? '—' }}</p>
                        </div>
                        <div style="grid-column:1/-1;">
                            <p class="ar-mobile-meta-label">Course</p>
                            <p class="ar-mobile-meta-value">{{ $alum->course ?? '—' }}</p>
                        </div>
                    </div>
                    <div class="ar-mobile-footer">
                        <span style="font-size:12px;color:#717182;font-family:'Segoe UI',sans-serif;">ID: {{ $alum->student_id ?? 'N/A' }}</span>
                        <a href="{{ route('admin.alumni-records.show', $alum) }}" class="btn-view-profile">View Profile</a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($alumni->hasPages())
            <div class="ar-pagination">
                <span class="info">Showing {{ $alumni->firstItem() }}–{{ $alumni->lastItem() }} of {{ $alumni->total() }}</span>
                <div class="pag-btns">
                    @if($alumni->onFirstPage())
                        <span class="pag-btn-disabled">← Prev</span>
                    @else
                        <a href="{{ $alumni->previousPageUrl() }}" class="pag-btn">← Prev</a>
                    @endif
                    @if($alumni->hasMorePages())
                        <a href="{{ $alumni->nextPageUrl() }}" class="pag-btn">Next →</a>
                    @else
                        <span class="pag-btn-disabled">Next →</span>
                    @endif
                </div>
            </div>
            @endif

            @else
            <div class="ar-empty">
                <div class="ar-empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(128,0,32,0.4)" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <p>No alumni records found</p>
                <small>Try adjusting your search or filter criteria</small>
            </div>
            @endif
        </div>
    </div>

    {{-- ── TAB 2: REPORTS ── --}}
    <div id="panel-reports" style="display:none;">

        {{-- Inline Report Form --}}
        <div class="report-section">
            <h2 style="color:#1a1a1a;">Generate Report</h2>
            <p>Choose a report type and apply filters to download a PDF.</p>

            <form method="GET" action="{{ route('admin.alumni-records.export-pdf') }}" id="reportForm">

                {{-- Report Type Toggle --}}
                <div style="margin-bottom: 28px;">
                    <p style="font-size: 13px; font-weight: 700; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 12px; font-family: 'Segoe UI', sans-serif;">Report Type</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">

                        <label id="card-alumni"
                            style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 18px; border-radius: 14px; border: 2px solid #800020; cursor: pointer; background: rgba(128,0,32,0.04);">
                            <input type="radio" name="report_type" value="all" checked
                                onchange="switchReportType('alumni')"
                                style="margin-top: 3px; accent-color: #800020; flex-shrink: 0;">
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #800020; margin: 0 0 3px; font-family: 'Segoe UI', sans-serif;">Alumni Records</p>
                                <p style="font-size: 12px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Export a list of alumni with optional batch, course, and status filters.</p>
                            </div>
                        </label>

                        <label id="card-budget"
                            style="display: flex; align-items: flex-start; gap: 12px; padding: 16px 18px; border-radius: 14px; border: 2px solid rgba(128,0,32,0.15); cursor: pointer; background: #fafafa;">
                            <input type="radio" name="report_type" value="budget"
                                onchange="switchReportType('budget')"
                                style="margin-top: 3px; accent-color: #800020; flex-shrink: 0;">
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #1a1a1a; margin: 0 0 3px; font-family: 'Segoe UI', sans-serif;">Budget & Donations</p>
                                <p style="font-size: 12px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Export donation records, allocations, and event budget summaries.</p>
                            </div>
                        </label>

                    </div>
                </div>

                {{-- Alumni Filters --}}
                <div id="filters-alumni">
                    <p style="font-size: 13px; font-weight: 700; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 12px; font-family: 'Segoe UI', sans-serif;">Alumni Filters</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                        <div class="report-field">
                            <label>Batch Year</label>
                            <select name="batch_year">
                                <option value="">All Batches</option>
                                @foreach($batchYears ?? [] as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="report-field">
                            <label>Course</label>
                            <select name="course">
                                <option value="">All Courses</option>
                                @foreach($courses ?? [] as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="report-field">
                            <label>Status</label>
                            <select name="status">
                                <option value="">All</option>
                                <option value="1">Approved</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Budget Filters --}}
                <div id="filters-budget" style="display: none;">
                    <p style="font-size: 13px; font-weight: 700; color: #717182; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 12px; font-family: 'Segoe UI', sans-serif;">Budget Filters</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="report-field">
                            <label>Period</label>
                            <select name="period">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                        <div class="report-field">
                            <label>Specific Event <span style="color:#717182;font-weight:400;">(optional)</span></label>
                            <select name="event_id">
                                <option value="">All Events</option>
                                @foreach(\App\Models\Event::orderBy('event_date','desc')->get() as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 28px; padding-top: 22px; border-top: 1px solid rgba(128,0,32,0.08);">
                    <button type="submit"
                        style="width: 100%; padding: 13px; background: #800020; color: #ffffff; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download PDF Report
                    </button>
                </div>

            </form>
        </div>

        {{-- Pre-defined Reports --}}
        <div class="report-section">
            <h2 style="color:#800020;">Pre-defined Reports</h2>
            <p>Quick access to commonly used reports</p>
            <div class="report-grid-2">
                @php
                $reports = [
                    ['type'=>'all',    'icon'=>'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8z', 'title'=>'Complete Alumni Directory', 'desc'=>'Full list of all registered alumni with details'],
                    ['type'=>'batch',  'icon'=>'M8 7V3m8 4V3M3 11h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z', 'title'=>'Alumni by Batch', 'desc'=>'Alumni grouped and sorted by graduation batch year'],
                    ['type'=>'course', 'icon'=>'M22 10v6M2 10l10-5 10 5-10 5zM6 12v5c3 3 9 3 12 0v-5', 'title'=>'Alumni by Course', 'desc'=>'Alumni grouped and sorted by program or course'],
                    ['type'=>'active', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title'=>'Active Alumni Only', 'desc'=>'Report of currently approved alumni only'],
                ];
                @endphp
                @foreach($reports as $report)
                <div class="predefined-card">
                    <div class="predefined-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8"><path d="{{ $report['icon'] }}"/></svg>
                    </div>
                    <h4>{{ $report['title'] }}</h4>
                    <p>{{ $report['desc'] }}</p>
                    <a href="{{ route('admin.alumni-records.export-pdf', ['report_type' => 'all', 'type' => $report['type']]) }}" class="btn-gen-pdf">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Generate PDF
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

<script>
function showTab(tab) {
    document.getElementById('panel-records').style.display = tab === 'records' ? 'block' : 'none';
    document.getElementById('panel-reports').style.display = tab === 'reports' ? 'block' : 'none';
    document.getElementById('tab-records').className = 'ar-tab ' + (tab === 'records' ? 'ar-tab-active' : 'ar-tab-inactive');
    document.getElementById('tab-reports').className = 'ar-tab ' + (tab === 'reports' ? 'ar-tab-active' : 'ar-tab-inactive');
}

function switchReportType(type) {
    var cardAlumni = document.getElementById('card-alumni');
    var cardBudget = document.getElementById('card-budget');
    var filAlumni  = document.getElementById('filters-alumni');
    var filBudget  = document.getElementById('filters-budget');

    if (type === 'alumni') {
        cardAlumni.style.borderColor = '#800020';
        cardAlumni.style.background  = 'rgba(128,0,32,0.04)';
        cardBudget.style.borderColor = 'rgba(128,0,32,0.15)';
        cardBudget.style.background  = '#fafafa';
        filAlumni.style.display = 'block';
        filBudget.style.display = 'none';
    } else {
        cardBudget.style.borderColor = '#800020';
        cardBudget.style.background  = 'rgba(128,0,32,0.04)';
        cardAlumni.style.borderColor = 'rgba(128,0,32,0.15)';
        cardAlumni.style.background  = '#fafafa';
        filAlumni.style.display = 'none';
        filBudget.style.display = 'block';
    }
}
</script>
@endsection