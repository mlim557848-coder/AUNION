<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Records Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #ffffff;
            padding: 40px 44px;
        }

        /* ── Header ── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 2px solid #1a1a1a;
        }
        .header-left  { display: table-cell; vertical-align: top; }
        .header-right { display: table-cell; vertical-align: top; text-align: right; }

        .org-name { font-size: 20px; font-weight: 700; color: #1a1a1a; letter-spacing: -0.5px; line-height: 1; }
        .org-sub  { font-size: 9px; color: #555555; margin-top: 3px; letter-spacing: 0.08em; text-transform: uppercase; }
        .report-title { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 2px; }
        .report-meta  { font-size: 9px; color: #555555; line-height: 1.7; }

        /* ── Filter Summary ── */
        .filter-bar {
            display: table;
            width: 100%;
            border: 1px solid #d0d0d0;
            margin-bottom: 22px;
        }
        .filter-item {
            display: table-cell;
            padding: 9px 14px;
            border-right: 1px solid #d0d0d0;
            vertical-align: middle;
        }
        .filter-item:last-child { border-right: none; }
        .filter-label { font-size: 7.5px; font-weight: 700; color: #888888; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 2px; }
        .filter-value { font-size: 10px; font-weight: 600; color: #1a1a1a; }

        /* ── Stats strip ── */
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .stats-table td {
            width: 25%;
            padding: 12px 16px;
            border: 1px solid #d0d0d0;
            vertical-align: top;
        }
        .stats-table td:not(:last-child) { border-right: none; }
        .stat-label { font-size: 8px; font-weight: 700; color: #777777; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
        .stat-value { font-size: 20px; font-weight: 300; color: #1a1a1a; line-height: 1; }

        /* ── Section header ── */
        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 0;
        }
        .section-title {
            font-size: 10px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 8px 12px;
            background: #1a1a1a;
            display: table-cell;
            width: 70%;
        }
        .section-count {
            font-size: 9px;
            color: #555555;
            padding: 8px 12px;
            background: #f0f0f0;
            border-top: 1px solid #d0d0d0;
            border-right: 1px solid #d0d0d0;
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        /* ── Data table ── */
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table thead tr {
            background: #f7f7f7;
            border-top: 1px solid #d0d0d0;
            border-bottom: 2px solid #1a1a1a;
        }
        table.data-table thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 8px;
            font-weight: 700;
            color: #333333;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }
        table.data-table tbody tr { border-bottom: 1px solid #ebebeb; }
        table.data-table tbody tr:last-child { border-bottom: 1px solid #d0d0d0; }
        table.data-table tbody td {
            padding: 8px 10px;
            font-size: 9.5px;
            color: #1a1a1a;
            vertical-align: top;
        }
        table.data-table tbody td.muted { color: #666666; }
        .status-approved {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #333333;
            border-radius: 2px;
            font-size: 8px;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-pending {
            display: inline-block;
            padding: 2px 8px;
            border: 1px solid #aaaaaa;
            border-radius: 2px;
            font-size: 8px;
            font-weight: 700;
            color: #777777;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 32px;
            padding-top: 10px;
            border-top: 1px solid #cccccc;
            display: table;
            width: 100%;
        }
        .footer-left  { display: table-cell; font-size: 8px; color: #888888; }
        .footer-right { display: table-cell; font-size: 8px; color: #888888; text-align: right; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="org-name">AUNION</div>
            <div class="org-sub">Alumni Management System</div>
        </div>
        <div class="header-right">
            <div class="report-title">Alumni Records Report</div>
            <div class="report-meta">
                Generated: {{ $generated }}<br>
                Document Type: Alumni Directory
            </div>
        </div>
    </div>

    {{-- Active Filters --}}
    <div class="filter-bar">
        <div class="filter-item">
            <div class="filter-label">Batch Year</div>
            <div class="filter-value">{{ $filters['batch_year'] ?? 'All Batches' ?: 'All Batches' }}</div>
        </div>
        <div class="filter-item">
            <div class="filter-label">Course / Program</div>
            <div class="filter-value">{{ $filters['course'] ?? 'All Courses' ?: 'All Courses' }}</div>
        </div>
        <div class="filter-item">
            <div class="filter-label">Status</div>
            <div class="filter-value">
                @if(isset($filters['status']) && $filters['status'] === '1') Approved Only
                @elseif(isset($filters['status']) && $filters['status'] === '0') Pending Only
                @else All Status
                @endif
            </div>
        </div>
        <div class="filter-item">
            <div class="filter-label">Total Records</div>
            <div class="filter-value">{{ $alumni->count() }}</div>
        </div>
    </div>

    {{-- Stats Strip --}}
    @php
        $approvedCount = $alumni->where('is_approved', true)->count();
        $pendingCount  = $alumni->where('is_approved', false)->count();
        $batches       = $alumni->pluck('batch_year')->filter()->unique()->count();
    @endphp
    <table class="stats-table">
        <tr>
            <td>
                <div class="stat-label">Total Alumni</div>
                <div class="stat-value">{{ $alumni->count() }}</div>
            </td>
            <td>
                <div class="stat-label">Approved</div>
                <div class="stat-value">{{ $approvedCount }}</div>
            </td>
            <td>
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $pendingCount }}</div>
            </td>
            <td>
                <div class="stat-label">Batch Years</div>
                <div class="stat-value">{{ $batches }}</div>
            </td>
        </tr>
    </table>

    {{-- Records Table --}}
    <div class="section-header">
        <div class="section-title">Alumni Directory</div>
        <div class="section-count">{{ $alumni->count() }} record(s) found</div>
    </div>

    @if($alumni->count())
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:22px;">#</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Student ID</th>
                <th>Batch</th>
                <th>Course / Program</th>
                <th>Status</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumni as $i => $alum)
            <tr>
                <td class="muted">{{ $i + 1 }}</td>
                <td><strong>{{ $alum->name }}</strong></td>
                <td class="muted">{{ $alum->email }}</td>
                <td class="muted" style="font-family: 'Courier New', monospace;">{{ $alum->student_id ?? '—' }}</td>
                <td>{{ $alum->batch_year ?? '—' }}</td>
                <td>{{ $alum->course ?? '—' }}</td>
                <td>
                    @if($alum->is_approved)
                        <span class="status-approved">Approved</span>
                    @else
                        <span class="status-pending">Pending</span>
                    @endif
                </td>
                <td class="muted">{{ $alum->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="padding: 14px 12px; font-size: 9.5px; color: #888888; font-style: italic; border: 1px solid #d0d0d0; border-top: none;">
        No alumni records found matching the selected filters.
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <div class="footer-left">
            AUNION Alumni Management System &mdash; Confidential Document<br>
            This report is generated automatically and is for authorized use only.
        </div>
        <div class="footer-right">
            Generated: {{ $generated }}<br>
            Total Records: {{ $alumni->count() }}
        </div>
    </div>

</body>
</html>