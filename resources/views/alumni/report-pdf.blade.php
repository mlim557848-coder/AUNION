<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>{{ $reportTitle }} — Aunion</title>
    <style>
        * {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 12px;
            color: #1a1a1a;
            background: #ffffff;
            padding: 0;
        }

        /* ── Header ─────────────────────────────── */
        .pdf-header {
            background: #800020;
            color: #ffffff;
            padding: 28px 36px 24px;
            margin-bottom: 0;
        }
        .pdf-header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .pdf-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pdf-brand-logo {
            width: 40px;
            height: 40px;
            background: #FDB813;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            color: #800020;
            text-align: center;
            line-height: 40px;
        }
        .pdf-brand-name {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }
        .pdf-brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.65);
        }
        .pdf-meta {
            text-align: right;
            font-size: 11px;
            color: rgba(255,255,255,0.70);
        }
        .pdf-title {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
        }
        .pdf-subtitle {
            font-size: 12px;
            color: rgba(255,255,255,0.68);
        }

        /* ── Gold strip below header ─────────────── */
        .gold-strip {
            background: #FDB813;
            height: 5px;
        }

        /* ── Summary bar ─────────────────────────── */
        .summary-bar {
            background: #f8f8f8;
            border-bottom: 1px solid #e8e8e8;
            padding: 14px 36px;
            display: flex;
            gap: 40px;
        }
        .summary-item label {
            font-size: 10px;
            font-weight: 700;
            color: #717182;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: block;
            margin-bottom: 3px;
        }
        .summary-item span {
            font-size: 16px;
            font-weight: 800;
            color: #800020;
        }

        /* ── Table ───────────────────────────────── */
        .table-wrap {
            padding: 24px 36px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #800020;
        }
        thead th {
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        tbody tr {
            border-bottom: 1px solid #efefef;
        }
        tbody td {
            padding: 10px 14px;
            font-size: 12px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        .badge-active {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            background: #d1fae5;
            color: #065f46;
            font-size: 11px;
            font-weight: 700;
        }
        .badge-archived {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
        }
        .batch-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 6px;
            background: rgba(253,184,19,0.20);
            color: #7a4f00;
            font-size: 11px;
            font-weight: 700;
        }

        /* Empty state */
        .empty {
            text-align: center;
            padding: 48px 24px;
            color: #717182;
            font-size: 14px;
        }

        /* ── Footer ──────────────────────────────── */
        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #800020;
            color: rgba(255,255,255,0.65);
            font-size: 10px;
            padding: 8px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="pdf-header">
        <div class="pdf-header-top">
            <div class="pdf-brand">
                <div class="pdf-brand-logo">A</div>
                <div>
                    <div class="pdf-brand-name">Aunion</div>
                    <div class="pdf-brand-sub">Alumni Management System</div>
                </div>
            </div>
            <div class="pdf-meta">
                Generated: {{ now()->format('F d, Y \a\t h:i A') }}<br>
                Prepared by: Admin
            </div>
        </div>
        <div class="pdf-title">{{ $reportTitle }}</div>
        <div class="pdf-subtitle">
            @if(!empty($batch)) Batch: {{ $batch }} &nbsp;|&nbsp; @endif
            @if(!empty($course)) Course: {{ $course }} &nbsp;|&nbsp; @endif
            Total Records: {{ count($alumni) }}
        </div>
    </div>

    <div class="gold-strip"></div>

    {{-- Summary --}}
    <div class="summary-bar">
        <div class="summary-item">
            <label>Total Records</label>
            <span>{{ count($alumni) }}</span>
        </div>
        @if(!empty($batch))
        <div class="summary-item">
            <label>Batch Filter</label>
            <span>{{ $batch }}</span>
        </div>
        @endif
        @if(!empty($course))
        <div class="summary-item">
            <label>Course Filter</label>
            <span>{{ $course }}</span>
        </div>
        @endif
        <div class="summary-item">
            <label>Report Type</label>
            <span style="font-size:13px;">{{ $reportTitle }}</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrap">
        @if($alumni->isEmpty())
            <div class="empty">No alumni records found for the selected filters.</div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Student ID</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumni as $i => $alum)
                    <tr>
                        <td style="color:#717182;">{{ $i + 1 }}</td>
                        <td><strong>{{ $alum->name }}</strong></td>
                        <td style="color:#717182;">{{ $alum->email }}</td>
                        <td>{{ $alum->student_id ?? '—' }}</td>
                        <td>{{ $alum->course ?? '—' }}</td>
                        <td>
                            @if($alum->batch_year)
                                <span class="batch-pill">{{ $alum->batch_year }}</span>
                            @else —
                            @endif
                        </td>
                        <td>
                            @if($alum->is_archived)
                                <span class="badge-archived">Archived</span>
                            @else
                                <span class="badge-active">Active</span>
                            @endif
                        </td>
                        <td style="color:#717182;">{{ $alum->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Footer --}}
    <div class="pdf-footer">
        <span>Aunion Alumni Management System — Confidential</span>
        <span>{{ now()->format('Y') }} © Aunion</span>
    </div>

</body>
</html>