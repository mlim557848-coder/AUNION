@extends('admin.layout')

@section('title', 'Alumni Records')

@section('content')
<div style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto;">

    {{-- Page heading --}}
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 28px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px;">Alumni Records & Reports</h1>
        <p style="font-size: 15px; color: #717182; margin: 0;">View alumni information and generate reports</p>
    </div>

    {{-- Tab Buttons --}}
    <div style="display: flex; gap: 10px; margin-bottom: 28px;">
        <button onclick="showTab('records')" id="tab-records"
            style="display: flex; align-items: center; gap: 8px; padding: 10px 22px; font-size: 14px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; background: #800020; color: #ffffff;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Alumni Records
        </button>
        <button onclick="showTab('reports')" id="tab-reports"
            style="display: flex; align-items: center; gap: 8px; padding: 10px 22px; font-size: 14px; font-weight: 600; border-radius: 10px; border: 1px solid rgba(128,0,32,0.2); cursor: pointer; background: #ffffff; color: #717182;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Generate Reports
        </button>
    </div>

    {{-- ── TAB 1: ALUMNI RECORDS ── --}}
    <div id="panel-records">

        {{-- KPI Cards --}}
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-bottom: 28px;">

            <div style="background: #800020; border-radius: 18px; padding: 28px 28px 24px; position: relative; overflow: hidden; min-height: 130px;">
                <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <p style="font-size: 13px; font-weight: 400; color: rgba(255,255,255,0.8); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Total Alumni</p>
                </div>
                <p style="font-size: 48px; font-weight: 300; color: #ffffff; margin: 0; line-height: 1;">{{ $totalAlumni ?? 0 }}</p>
            </div>

            <div style="background: #FDB813; border-radius: 18px; padding: 28px 28px 24px; position: relative; overflow: hidden; min-height: 130px;">
                <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.18);"></div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(92,55,0,0.15); display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5c3700" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <p style="font-size: 13px; font-weight: 400; color: rgba(92,55,0,0.8); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Batch Years</p>
                </div>
                <p style="font-size: 48px; font-weight: 300; color: #5c3700; margin: 0; line-height: 1;">{{ $batchYears ?? 0 }}</p>
            </div>

            <div style="background: #9b3a54; border-radius: 18px; padding: 28px 28px 24px; position: relative; overflow: hidden; min-height: 130px;">
                <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <p style="font-size: 13px; font-weight: 400; color: rgba(255,255,255,0.8); margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Programs</p>
                </div>
                <p style="font-size: 48px; font-weight: 300; color: #ffffff; margin: 0; line-height: 1;">{{ $programs ?? 0 }}</p>
            </div>

        </div>

        {{-- Search + Filter --}}
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden;">
            <div style="padding: 20px 28px; border-bottom: 1px solid rgba(128,0,32,0.08);">
                <form method="GET" action="{{ route('admin.alumni-records.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <div style="position: relative; flex: 1; min-width: 240px;">
                        <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #717182;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, student ID..."
                            style="width: 100%; padding: 10px 14px 10px 42px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                    </div>
                    <select name="batch" style="padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                        <option value="">All Batches</option>
                        @foreach($batchList ?? [] as $batch)
                            <option value="{{ $batch }}" {{ request('batch') == $batch ? 'selected' : '' }}>{{ $batch }}</option>
                        @endforeach
                    </select>
                    <select name="status" style="padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                    <button type="submit" style="padding: 10px 22px; font-size: 14px; font-weight: 500; background: #800020; color: #ffffff; border: none; border-radius: 10px; cursor: pointer;">Filter</button>
                </form>
            </div>

            {{-- Records count --}}
            <div style="padding: 14px 28px; border-bottom: 1px solid rgba(128,0,32,0.05);">
                <span style="font-size: 13px; color: #717182;">{{ $alumni->total() ?? 0 }} records found</span>
            </div>

            {{-- Table --}}
            @if($alumni->count())
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #fafafa; border-bottom: 1px solid rgba(128,0,32,0.08);">
                            <th style="padding: 14px 28px; text-align: left; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Alumni</th>
                            <th style="padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Student ID</th>
                            <th style="padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Batch</th>
                            <th style="padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Course</th>
                            <th style="padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                            <th style="padding: 14px 28px; text-align: right; font-size: 12px; font-weight: 600; color: #717182; text-transform: uppercase; letter-spacing: 0.05em;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $alum)
                        <tr style="border-bottom: 1px solid rgba(128,0,32,0.05);">
                            <td style="padding: 16px 28px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #800020; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <span style="font-size: 14px; font-weight: 600; color: #ffffff;">{{ strtoupper(substr($alum->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p style="font-size: 15px; font-weight: 500; color: #1a1a1a; margin: 0 0 2px;">{{ $alum->name }}</p>
                                        <p style="font-size: 13px; color: #717182; margin: 0;">{{ $alum->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 20px; font-size: 14px; color: #717182;">{{ $alum->student_id ?? '—' }}</td>
                            <td style="padding: 16px 20px; font-size: 14px; color: #717182;">{{ $alum->batch_year ?? '—' }}</td>
                            <td style="padding: 16px 20px; font-size: 14px; color: #717182;">{{ $alum->course ?? '—' }}</td>
                            <td style="padding: 16px 20px;">
                                @if(!$alum->is_archived)
                                    <span style="display: inline-flex; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(128,0,32,0.08); color: #800020;">Active</span>
                                @else
                                    <span style="display: inline-flex; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(113,113,130,0.1); color: #717182;">Archived</span>
                                @endif
                            </td>
                            <td style="padding: 16px 28px; text-align: right;">
                                <a href="{{ route('admin.alumni-records.show', $alum) }}"
                                    style="padding: 7px 18px; font-size: 13px; font-weight: 500; background: #800020; color: #ffffff; border-radius: 8px; text-decoration: none; display: inline-block;">View Profile</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($alumni->hasPages())
            <div style="padding: 16px 28px; border-top: 1px solid rgba(128,0,32,0.08); display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 13px; color: #717182;">Showing {{ $alumni->firstItem() }}–{{ $alumni->lastItem() }} of {{ $alumni->total() }}</span>
                <div style="display: flex; gap: 6px;">
                    @if($alumni->onFirstPage())
                        <span style="padding: 7px 14px; font-size: 13px; border-radius: 8px; border: 1px solid rgba(128,0,32,0.1); color: #717182; cursor: not-allowed;">← Prev</span>
                    @else
                        <a href="{{ $alumni->previousPageUrl() }}" style="padding: 7px 14px; font-size: 13px; border-radius: 8px; border: 1px solid rgba(128,0,32,0.15); color: #800020; text-decoration: none;">← Prev</a>
                    @endif
                    @if($alumni->hasMorePages())
                        <a href="{{ $alumni->nextPageUrl() }}" style="padding: 7px 14px; font-size: 13px; border-radius: 8px; border: 1px solid rgba(128,0,32,0.15); color: #800020; text-decoration: none;">Next →</a>
                    @else
                        <span style="padding: 7px 14px; font-size: 13px; border-radius: 8px; border: 1px solid rgba(128,0,32,0.1); color: #717182; cursor: not-allowed;">Next →</span>
                    @endif
                </div>
            </div>
            @endif

            @else
            <div style="padding: 64px 28px; text-align: center;">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(128,0,32,0.07); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(128,0,32,0.4)" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <p style="font-size: 15px; font-weight: 500; color: #1a1a1a; margin: 0 0 6px;">No alumni records found</p>
                <p style="font-size: 14px; color: #717182; margin: 0;">Try adjusting your search or filter criteria</p>
            </div>
            @endif
        </div>

    </div>

    {{-- ── TAB 2: GENERATE REPORTS ── --}}
    <div id="panel-reports" style="display: none;">

        {{-- Custom Report --}}
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 32px; margin-bottom: 24px;">
            <h2 style="font-size: 18px; font-weight: 600; color: #FDB813; margin: 0 0 6px;">Custom Report</h2>
            <p style="font-size: 14px; color: #717182; margin: 0 0 24px;">Generate a filtered report based on your criteria</p>
            <form method="GET" action="{{ route('admin.alumni-records.report') }}">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Batch Year</label>
                        <select name="batch" style="width: 100%; padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                            <option value="">All Batches</option>
                            @foreach($batchList ?? [] as $batch)
                                <option value="{{ $batch }}">{{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Course / Program</label>
                        <select name="course" style="width: 100%; padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                            <option value="">All Courses</option>
                            @foreach($courseList ?? [] as $course)
                                <option value="{{ $course }}">{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Report Type</label>
                        <select name="type" style="width: 100%; padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none;">
                            <option value="all">Complete Directory</option>
                            <option value="batch">By Batch</option>
                            <option value="course">By Course</option>
                            <option value="active">Active Alumni Only</option>
                        </select>
                    </div>
                </div>
                <button type="submit" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 600; background: #FDB813; color: #5c3700; border: none; border-radius: 10px; cursor: pointer;">Generate Custom Report</button>
            </form>
        </div>

        {{-- Pre-defined Reports --}}
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 32px;">
            <h2 style="font-size: 18px; font-weight: 600; color: #800020; margin: 0 0 6px;">Pre-defined Reports</h2>
            <p style="font-size: 14px; color: #717182; margin: 0 0 24px;">Quick access to commonly used reports</p>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">

                @php
                $reports = [
                    ['type' => 'all',    'icon' => 'M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8z', 'title' => 'Complete Alumni Directory', 'desc' => 'Full list of all registered alumni with details'],
                    ['type' => 'batch',  'icon' => 'M8 7V3m8 4V3M3 11h18M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z', 'title' => 'Alumni by Batch', 'desc' => 'Alumni grouped and sorted by graduation batch year'],
                    ['type' => 'course', 'icon' => 'M22 10v6M2 10l10-5 10 5-10 5zM6 12v5c3 3 9 3 12 0v-5', 'title' => 'Alumni by Course', 'desc' => 'Alumni grouped and sorted by program or course'],
                    ['type' => 'active', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Active Alumni Only', 'desc' => 'Report of currently active (non-archived) alumni'],
                ];
                @endphp

                @foreach($reports as $report)
                <div style="border: 1px solid rgba(128,0,32,0.1); border-radius: 14px; padding: 22px;">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(128,0,32,0.07); display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8"><path d="{{ $report['icon'] }}"/></svg>
                    </div>
                    <p style="font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px;">{{ $report['title'] }}</p>
                    <p style="font-size: 13px; color: #717182; margin: 0 0 16px;">{{ $report['desc'] }}</p>
                    <a href="{{ route('admin.alumni-records.report', ['type' => $report['type']]) }}"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; font-size: 13px; font-weight: 600; background: #800020; color: #ffffff; border-radius: 8px; text-decoration: none;">
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
    document.getElementById('tab-records').style.background = tab === 'records' ? '#800020' : '#ffffff';
    document.getElementById('tab-records').style.color = tab === 'records' ? '#ffffff' : '#717182';
    document.getElementById('tab-records').style.border = tab === 'records' ? 'none' : '1px solid rgba(128,0,32,0.2)';
    document.getElementById('tab-reports').style.background = tab === 'reports' ? '#800020' : '#ffffff';
    document.getElementById('tab-reports').style.color = tab === 'reports' ? '#ffffff' : '#717182';
    document.getElementById('tab-reports').style.border = tab === 'reports' ? 'none' : '1px solid rgba(128,0,32,0.2)';
}
</script>
@endsection