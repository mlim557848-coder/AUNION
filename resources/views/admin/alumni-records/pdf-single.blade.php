<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aunion — Alumni Profile: {{ $user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #ffffff;
            padding: 32px 36px;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #800020;
            padding-bottom: 16px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .brand { color: #800020; font-size: 22px; font-weight: 700; }
        .brand span { color: #FDB813; }
        .report-label { font-size: 12px; color: #717182; margin-top: 4px; }
        .meta { text-align: right; font-size: 10px; color: #717182; line-height: 1.8; }

        /* Hero banner */
        .hero {
            background: #800020;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; color: #ffffff;
            flex-shrink: 0;
        }
        .hero-info .name { font-size: 20px; font-weight: 700; color: #ffffff; }
        .hero-info .email { font-size: 11px; color: rgba(255,255,255,0.75); margin-top: 4px; }
        .hero-info .badge {
            display: inline-block;
            margin-top: 8px;
            font-size: 9px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-pending  { background: #fef3c7; color: #92400e; }

        /* KPI strip */
        .kpi-strip { display: flex; gap: 14px; margin-bottom: 20px; }
        .kpi-box { flex: 1; border-radius: 10px; padding: 14px 18px; }
        .kpi-label { font-size: 10px; opacity: 0.82; margin-bottom: 6px; }
        .kpi-number { font-size: 26px; font-weight: 300; line-height: 1; }
        .kpi-maroon { background: #800020; color: #ffffff; }
        .kpi-gold   { background: #FDB813; color: #5c3700; }
        .kpi-rose   { background: #9b3a54; color: #ffffff; }
        .kpi-amber  { background: #f5c842; color: #5c3700; }

        /* Info grid */
        .info-grid { display: flex; gap: 20px; margin-bottom: 20px; }
        .info-section {
            flex: 1;
            background: #fafafa;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            padding: 14px 18px;
        }
        .info-section h3 {
            font-size: 11px;
            font-weight: 700;
            color: #800020;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(128,0,32,0.12);
        }
        .info-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px dotted #e5e5e5; }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { font-size: 10px; color: #717182; }
        .info-row .value { font-size: 10px; color: #1a1a1a; font-weight: 600; text-align: right; max-width: 60%; }

        /* Events table */
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead tr { background: #800020; }
        thead th { padding: 8px 10px; text-align: left; font-size: 9px; font-weight: 700; color: #ffffff; }
        tbody tr:nth-child(even) { background: #fafafa; }
        tbody td { padding: 7px 10px; font-size: 10px; color: #1a1a1a; border-bottom: 1px solid #f0f0f0; }

        /* Footer */
        .footer {
            margin-top: 24px;
            border-top: 1px solid #e5e5e5;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #717182;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="brand">Au<span>n</span>ion</div>
            <div class="report-label">Alumni Profile Report</div>
        </div>
        <div class="meta">
            <div><strong>Generated:</strong> {{ now()->format('F d, Y h:i A') }}</div>
            <div><strong>Document:</strong> Individual Alumni Record</div>
        </div>
    </div>

    {{-- Hero --}}
    <div class="hero">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div class="hero-info">
            <div class="name">{{ $user->name }}</div>
            <div class="email">{{ $user->email }}</div>
            <span class="badge {{ $user->is_approved ? 'badge-approved' : 'badge-pending' }}">
                {{ $user->is_approved ? 'Approved' : 'Pending' }}
            </span>
        </div>
    </div>

    {{-- KPI strip --}}
    <div class="kpi-strip">
        <div class="kpi-box kpi-maroon">
            <div class="kpi-label">Events RSVP'd</div>
            <div class="kpi-number">{{ $attendeesCount }}</div>
        </div>
        <div class="kpi-box kpi-gold">
            <div class="kpi-label">Connections</div>
            <div class="kpi-number">{{ $connectionsCount }}</div>
        </div>
        <div class="kpi-box kpi-rose">
            <div class="kpi-label">Batch Year</div>
            <div class="kpi-number" style="font-size:18px;">{{ $user->batch_year ?? '—' }}</div>
        </div>
        <div class="kpi-box kpi-amber">
            <div class="kpi-label">Member Since</div>
            <div class="kpi-number" style="font-size:14px; margin-top:4px;">{{ $user->created_at->format('M Y') }}</div>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="info-grid">
        {{-- Academic --}}
        <div class="info-section">
            <h3>Academic Background</h3>
            <div class="info-row"><span class="label">Course</span><span class="value">{{ $user->course ?? '—' }}</span></div>
            <div class="info-row"><span class="label">Batch Year</span><span class="value">{{ $user->batch_year ?? '—' }}</span></div>
            <div class="info-row"><span class="label">Student ID</span><span class="value">{{ $user->student_id ?? '—' }}</span></div>
        </div>

        {{-- Professional --}}
        <div class="info-section">
            <h3>Professional Info</h3>
            <div class="info-row"><span class="label">Current Position</span><span class="value">{{ $user->current_position ?? '—' }}</span></div>
            <div class="info-row"><span class="label">Industry</span><span class="value">{{ $user->industry ?? '—' }}</span></div>
            <div class="info-row"><span class="label">LinkedIn</span><span class="value">{{ $user->linkedin ?? '—' }}</span></div>
        </div>

        {{-- Contact --}}
        <div class="info-section">
            <h3>Contact Information</h3>
            <div class="info-row"><span class="label">Email</span><span class="value">{{ $user->contact_email ?? $user->email }}</span></div>
            <div class="info-row"><span class="label">Phone</span><span class="value">{{ $user->phone ?? '—' }}</span></div>
            <div class="info-row"><span class="label">Address</span><span class="value">{{ $user->address ?? '—' }}</span></div>
        </div>
    </div>

    {{-- Events RSVP'd --}}
    @if($rsvpdEvents->count() > 0)
    <div style="background:#fafafa; border:1px solid #e5e5e5; border-radius:10px; padding:14px 18px; margin-bottom:20px;">
        <h3 style="font-size:11px; font-weight:700; color:#800020; margin-bottom:10px; padding-bottom:6px; border-bottom:1px solid rgba(128,0,32,0.12);">
            Events RSVP'd To
        </h3>
        <table>
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rsvpdEvents as $event)
                <tr>
                    <td><strong>{{ $event->title }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                    <td>{{ $event->location ?? '—' }}</td>
                    <td>{{ ucfirst($event->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <span>Aunion Alumni Management System — Confidential</span>
        <span>Alumni ID: #{{ $user->id }}</span>
    </div>

</body>
</html>