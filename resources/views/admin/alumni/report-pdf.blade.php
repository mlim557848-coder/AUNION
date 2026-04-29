<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ── HEADER ── */
        .header {
            background: #1e2936;
            padding: 22px 36px 18px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .brand-sub {
            font-size: 9px;
            color: rgba(255,255,255,0.45);
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .report-meta {
            text-align: right;
        }

        .report-meta .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.4);
            margin-bottom: 1px;
        }

        .report-meta .value {
            font-size: 10px;
            color: rgba(255,255,255,0.85);
        }

        .header-divider {
            height: 1px;
            background: rgba(255,255,255,0.12);
            margin: 14px 0;
        }

        .report-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }

        .report-subtitle {
            font-size: 10px;
            color: rgba(255,255,255,0.5);
            margin-top: 3px;
        }

        .badge {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.85);
            font-size: 9px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ── FILTER STRIP ── */
        .filter-strip {
            background: #f4f5f6;
            border-bottom: 1px solid #dde0e4;
            padding: 8px 36px;
            display: flex;
            gap: 28px;
            align-items: center;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #888888;
            font-weight: 600;
            margin-bottom: 1px;
        }

        .filter-value {
            font-size: 10px;
            font-weight: 600;
            color: #1e2936;
        }

        /* ── SUMMARY ROW ── */
        .summary-row {
            display: flex;
            border-bottom: 1px solid #dde0e4;
        }

        .summary-cell {
            flex: 1;
            padding: 14px 18px;
            border-right: 1px solid #dde0e4;
        }

        .summary-cell:last-child {
            border-right: none;
        }

        .sc-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #888888;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .sc-num {
            font-size: 26px;
            font-weight: 300;
            color: #1e2936;
            line-height: 1;
        }

        .sc-sub {
            font-size: 9px;
            color: #aaaaaa;
            margin-top: 3px;
        }

        .sc-bar-bg {
            height: 3px;
            background: #e8eaed;
            border-radius: 2px;
            margin-top: 8px;
        }

        .sc-bar-fill {
            height: 3px;
            border-radius: 2px;
            background: #1e2936;
        }

        /* ── TABLE ── */
        .table-section {
            padding: 0 36px 60px;
        }

        .table-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0 10px;
            border-bottom: 2px solid #1e2936;
        }

        .table-title {
            font-size: 10px;
            font-weight: 700;
            color: #1e2936;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .table-count {
            font-size: 9px;
            color: #888888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead tr {
            background: #f4f5f6;
        }

        thead th {
            font-size: 9px;
            font-weight: 700;
            color: #555555;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #dde0e4;
            border-right: 1px solid #dde0e4;
        }

        thead th:last-child {
            border-right: none;
        }

        tbody tr {
            border-bottom: 1px solid #eceef0;
        }

        tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        tbody td {
            padding: 7px 10px;
            font-size: 10px;
            color: #1a1a1a;
            vertical-align: middle;
            border-right: 1px solid #eceef0;
        }

        tbody td:last-child {
            border-right: none;
        }

        .td-name {
            font-weight: 700;
            font-size: 10px;
            color: #1e2936;
        }

        .td-muted {
            font-size: 9px;
            color: #999999;
            margin-top: 1px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 2px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .status-active {
            background: #e8f0fe;
            color: #1a56c4;
            border: 1px solid #c3d4f7;
        }

        .status-pending {
            background: #fef6e4;
            color: #8a5e00;
            border: 1px solid #f0d88a;
        }

        .status-archived {
            background: #f1f2f4;
            color: #666666;
            border: 1px solid #cccccc;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #888888;
            font-size: 11px;
        }

        /* ── FOOTER ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #f4f5f6;
            border-top: 1px solid #dde0e4;
            padding: 8px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 9px;
            color: #999999;
        }

        .footer-right {
            font-size: 9px;
            color: #999999;
        }

        .footer-brand {
            font-weight: 700;
            color: #1e2936;
        }
    </style>
</head>
<body>

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="brand-name">Aunion</div>
                <div class="brand-sub">Alumni Management System</div>
            </div>
            <div class="report-meta">
                <div class="label">Generated</div>
                <div class="value">{{ now()->format('F d, Y') }}</div>
                <div style="margin-top:6px;" class="label">Time</div>
                <div class="value">{{ now()->format('h:i A') }}</div>
            </div>
        </div>

        <div class="header-divider"></div>

        <div class="report-title-row">
            <div>
                <div class="report-title">{{ $reportTitle }}</div>
                <div class="report-subtitle">
                    Official alumni records export
                    @if($batch) &bull; Batch {{ $batch }} @endif
                    @if($course) &bull; {{ $course }} @endif
                </div>
            </div>
            <div class="badge">{{ strtoupper($type) }}</div>
        </div>
    </div>

    {{-- ── FILTER STRIP ── --}}
    <div class="filter-strip">
        <div class="filter-item">
            <span class="filter-label">Report Type</span>
            <span class="filter-value">{{ ucfirst($type) }}</span>
        </div>
        <div class="filter-item">
            <span class="filter-label">Batch Year</span>
            <span class="filter-value">{{ $batch ?: 'All Years' }}</span>
        </div>
        <div class="filter-item">
            <span class="filter-label">Course</span>
            <span class="filter-value">{{ $course ?: 'All Courses' }}</span>
        </div>
        <div class="filter-item">
            <span class="filter-label">Total Records</span>
            <span class="filter-value">{{ $alumni->count() }}</span>
        </div>
        <div class="filter-item">
            <span class="filter-label">Export Format</span>
            <span class="filter-value">PDF Report</span>
        </div>
    </div>

    {{-- ── SUMMARY ROW ── --}}
    @php
        $total     = $alumni->count();
        $approved  = $alumni->where('is_approved', 1)->count();
        $pending   = $alumni->where('is_approved', 0)->where('is_archived', 0)->count();
        $archived  = $alumni->where('is_archived', 1)->count();
        $batches   = $alumni->pluck('batch_year')->filter()->unique()->count();

        $approvedPct = $total > 0 ? round(($approved  / $total) * 100) : 0;
        $pendingPct  = $total > 0 ? round(($pending   / $total) * 100) : 0;
        $archivedPct = $total > 0 ? round(($archived  / $total) * 100) : 0;
    @endphp

    <div class="summary-row">
        <div class="summary-cell">
            <div class="sc-label">Total Alumni</div>
            <div class="sc-num">{{ $total }}</div>
            <div class="sc-sub">All records</div>
            <div class="sc-bar-bg"><div class="sc-bar-fill" style="width:100%;"></div></div>
        </div>
        <div class="summary-cell">
            <div class="sc-label">Approved</div>
            <div class="sc-num">{{ $approved }}</div>
            <div class="sc-sub">{{ $approvedPct }}% of total</div>
            <div class="sc-bar-bg"><div class="sc-bar-fill" style="width:{{ $approvedPct }}%;"></div></div>
        </div>
        <div class="summary-cell">
            <div class="sc-label">Pending</div>
            <div class="sc-num">{{ $pending }}</div>
            <div class="sc-sub">{{ $pendingPct }}% of total</div>
            <div class="sc-bar-bg"><div class="sc-bar-fill" style="width:{{ $pendingPct }}%;"></div></div>
        </div>
        <div class="summary-cell">
            <div class="sc-label">Archived</div>
            <div class="sc-num">{{ $archived }}</div>
            <div class="sc-sub">{{ $archivedPct }}% of total</div>
            <div class="sc-bar-bg"><div class="sc-bar-fill" style="width:{{ $archivedPct }}%;"></div></div>
        </div>
        <div class="summary-cell">
            <div class="sc-label">Batch Years</div>
            <div class="sc-num">{{ $batches }}</div>
            <div class="sc-sub">Unique batches</div>
            <div class="sc-bar-bg"><div class="sc-bar-fill" style="width:60%;"></div></div>
        </div>
    </div>

    {{-- ── TABLE ── --}}
    <div class="table-section">
        <div class="table-header-row">
            <div class="table-title">Alumni Records</div>
            <div class="table-count">{{ $total }} record{{ $total !== 1 ? 's' : '' }} found</div>
        </div>

        @if($total)
        <table>
            <thead>
                <tr>
                    <th style="width:24px;">#</th>
                    <th style="width:130px;">Name</th>
                    <th style="width:80px;">Student ID</th>
                    <th style="width:110px;">Course</th>
                    <th style="width:40px;">Batch</th>
                    <th style="width:130px;">Email</th>
                    <th style="width:110px;">Position</th>
                    <th style="width:58px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni as $index => $alum)
                <tr>
                    <td style="color:#aaaaaa; font-size:9px;">{{ $index + 1 }}</td>
                    <td>
                        <div class="td-name">{{ $alum->name }}</div>
                        @if($alum->phone)
                            <div class="td-muted">{{ $alum->phone }}</div>
                        @endif
                    </td>
                    <td>{{ $alum->student_id ?? '—' }}</td>
                    <td>{{ $alum->course ?? '—' }}</td>
                    <td>{{ $alum->batch_year ?? '—' }}</td>
                    <td style="font-size:9px;">{{ $alum->contact_email ?? $alum->email }}</td>
                    <td>
                        @if($alum->current_position)
                            <div style="font-size:9px;">{{ $alum->current_position }}</div>
                            @if($alum->industry)
                                <div class="td-muted">{{ $alum->industry }}</div>
                            @endif
                        @else
                            <span style="color:#aaaaaa;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($alum->is_archived)
                            <span class="status-badge status-archived">Archived</span>
                        @elseif($alum->is_approved)
                            <span class="status-badge status-active">Active</span>
                        @else
                            <span class="status-badge status-pending">Pending</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            No alumni records found matching the selected filters.
        </div>
        @endif
    </div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        <div class="footer-left">
            <span class="footer-brand">Aunion</span> &mdash; Alumni Management System &bull; Confidential Document
        </div>
        <div class="footer-right">
            Generated on {{ now()->format('M d, Y \a\t h:i A') }}
        </div>
    </div>

</body>
</html>