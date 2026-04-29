<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Budget & Donations Report</title>
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

        .org-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            line-height: 1;
        }
        .org-sub {
            font-size: 9px;
            color: #555555;
            margin-top: 3px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .report-title {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 2px;
        }
        .report-meta {
            font-size: 9px;
            color: #555555;
            line-height: 1.7;
        }

        /* ── Summary Row ── */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 26px;
        }
        .summary-table td {
            width: 33.33%;
            padding: 14px 18px;
            border: 1px solid #d0d0d0;
            vertical-align: top;
        }
        .summary-table td:not(:last-child) {
            border-right: none;
        }
        .sum-label {
            font-size: 8px;
            font-weight: 700;
            color: #777777;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 5px;
        }
        .sum-value {
            font-size: 18px;
            font-weight: 300;
            color: #1a1a1a;
            line-height: 1;
        }
        .sum-count {
            font-size: 8px;
            color: #999999;
            margin-top: 3px;
        }

        /* ── Section ── */
        .section { margin-bottom: 28px; }
        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 0;
        }
        .section-title {
            font-size: 10px;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 8px 12px;
            background: #1a1a1a;
            color: #ffffff;
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

        /* ── Table ── */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
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
        table.data-table thead th.text-right { text-align: right; }
        table.data-table tbody tr {
            border-bottom: 1px solid #ebebeb;
        }
        table.data-table tbody tr:last-child { border-bottom: 1px solid #d0d0d0; }
        table.data-table tbody td {
            padding: 8px 10px;
            font-size: 9.5px;
            color: #1a1a1a;
            vertical-align: top;
        }
        table.data-table tbody td.text-right { text-align: right; }
        table.data-table tbody td.muted { color: #666666; }
        table.data-table .total-row td {
            padding: 9px 10px;
            font-weight: 700;
            font-size: 9.5px;
            background: #f7f7f7;
            border-top: 2px solid #1a1a1a;
            border-bottom: 1px solid #d0d0d0;
        }

        .empty-notice {
            padding: 14px 12px;
            font-size: 9.5px;
            color: #888888;
            font-style: italic;
            border: 1px solid #d0d0d0;
            border-top: none;
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
            <div class="report-title">Budget &amp; Donations Report</div>
            <div class="report-meta">
                Generated: {{ $generated }}<br>
                Period: {{ $period === 'all' ? 'All Time' : ucfirst($period) }}<br>
                @if($eventId)
                    Event Filter: Applied
                @else
                    Event Filter: All Events
                @endif
            </div>
        </div>
    </div>

    {{-- Summary --}}
    @php
        $totalDonations      = $donations->sum('amount');
        $totalEventDonations = $eventDonations->sum('amount');
        $totalAllocations    = $allocations->sum('amount');
        $grandTotal          = $totalDonations + $totalEventDonations;
    @endphp

    <table class="summary-table">
        <tr>
            <td>
                <div class="sum-label">General Donations</div>
                <div class="sum-value">&#8369;{{ number_format($totalDonations, 2) }}</div>
                <div class="sum-count">{{ $donations->count() }} {{ $donations->count() === 1 ? 'record' : 'records' }}</div>
            </td>
            <td>
                <div class="sum-label">Event Donations</div>
                <div class="sum-value">&#8369;{{ number_format($totalEventDonations, 2) }}</div>
                <div class="sum-count">{{ $eventDonations->count() }} {{ $eventDonations->count() === 1 ? 'record' : 'records' }}</div>
            </td>
            <td>
                <div class="sum-label">Budget Allocations</div>
                <div class="sum-value">&#8369;{{ number_format($totalAllocations, 2) }}</div>
                <div class="sum-count">{{ $allocations->count() }} {{ $allocations->count() === 1 ? 'record' : 'records' }}</div>
            </td>
        </tr>
    </table>

    {{-- General Donations --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title">General Donations</div>
            <div class="section-count">{{ $donations->count() }} record(s) &nbsp;&bull;&nbsp; Total: &#8369;{{ number_format($totalDonations, 2) }}</div>
        </div>
        @if($donations->count())
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:24px;">#</th>
                    <th>Donor Name</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $i => $donation)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td><strong>{{ $donation->user->name ?? '—' }}</strong></td>
                    <td class="muted">{{ $donation->user->email ?? '—' }}</td>
                    <td>{{ ucfirst($donation->status ?? 'pending') }}</td>
                    <td class="muted">{{ \Carbon\Carbon::parse($donation->created_at)->format('M d, Y') }}</td>
                    <td class="text-right"><strong>&#8369;{{ number_format($donation->amount, 2) }}</strong></td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5">Total General Donations</td>
                    <td class="text-right">&#8369;{{ number_format($totalDonations, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="empty-notice">No general donation records found for the selected period.</div>
        @endif
    </div>

    {{-- Event Donations --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title">Event Donations</div>
            <div class="section-count">{{ $eventDonations->count() }} record(s) &nbsp;&bull;&nbsp; Total: &#8369;{{ number_format($totalEventDonations, 2) }}</div>
        </div>
        @if($eventDonations->count())
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:24px;">#</th>
                    <th>Donor Name</th>
                    <th>Event</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventDonations as $i => $ed)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td><strong>{{ $ed->user->name ?? '—' }}</strong></td>
                    <td>{{ $ed->event->title ?? '—' }}</td>
                    <td class="muted">{{ $ed->note ?? '—' }}</td>
                    <td class="muted">{{ \Carbon\Carbon::parse($ed->created_at)->format('M d, Y') }}</td>
                    <td class="text-right"><strong>&#8369;{{ number_format($ed->amount, 2) }}</strong></td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5">Total Event Donations</td>
                    <td class="text-right">&#8369;{{ number_format($totalEventDonations, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="empty-notice">No event donation records found for the selected filters.</div>
        @endif
    </div>

    {{-- Budget Allocations --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title">Budget Allocations</div>
            <div class="section-count">{{ $allocations->count() }} record(s) &nbsp;&bull;&nbsp; Total: &#8369;{{ number_format($totalAllocations, 2) }}</div>
        </div>
        @if($allocations->count())
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:24px;">#</th>
                    <th>Event</th>
                    <th>Allocated By</th>
                    <th>Date</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allocations as $i => $alloc)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td><strong>{{ $alloc->event->title ?? '—' }}</strong></td>
                    <td>{{ $alloc->allocatedBy->name ?? '—' }}</td>
                    <td class="muted">{{ \Carbon\Carbon::parse($alloc->created_at)->format('M d, Y') }}</td>
                    <td class="text-right"><strong>&#8369;{{ number_format($alloc->amount, 2) }}</strong></td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">Total Allocations</td>
                    <td class="text-right">&#8369;{{ number_format($totalAllocations, 2) }}</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="empty-notice">No budget allocation records found for the selected filters.</div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        <div class="footer-left">
            AUNION Alumni Management System &mdash; Confidential Document<br>
            This report is generated automatically and is for authorized use only.
        </div>
        <div class="footer-right">
            Generated: {{ $generated }}<br>
            Combined Donations Total: &#8369;{{ number_format($grandTotal, 2) }}
        </div>
    </div>

</body>
</html>