@extends('alumni.layout')
@section('title', 'Network')

@push('styles')
<style>
.alumni-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}
.alumni-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid rgba(128,0,32,0.08);
    padding: 28px 20px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.alumni-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 40px rgba(128,0,32,0.12);
}
.alumni-avatar {
    width: 70px; height: 70px; border-radius: 50%;
    margin: 0 auto 16px;
    background: #fdf0f3;
    border: 2.5px solid rgba(128,0,32,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 800; color: #800020;
    overflow: hidden;
}
.alumni-card:hover .alumni-avatar { border-color: rgba(128,0,32,0.35); }
.connect-btn {
    width: 100%; padding: 10px; border-radius: 10px;
    font-size: 13.5px; font-weight: 600; cursor: pointer; border: none;
    font-family: 'Segoe UI', sans-serif; transition: all 0.25s;
}
.section-title {
    font-size: 16px; font-weight: 600; color: #1a1a1a;
    margin: 0 0 16px; display: flex; align-items: center; gap: 10px;
}
.badge {
    background: #800020; color: #fff; font-size: 11px;
    padding: 2px 8px; border-radius: 20px; font-weight: 600;
}
.network-page-wrap {
    padding: 40px 48px 60px;
    max-width: 1280px;
    margin: 0 auto;
    font-family: 'Segoe UI', sans-serif;
}
@media (max-width: 768px) {
    .network-page-wrap {
        padding: 24px 20px 48px;
    }
    .network-search-row {
        flex-direction: column !important;
    }
    .network-search-row input,
    .network-search-row select,
    .network-search-row button,
    .network-search-row a {
        width: 100% !important;
        min-width: unset !important;
        box-sizing: border-box;
    }
}
@media (max-width: 640px) {
    .alumni-grid { grid-template-columns: repeat(2,1fr); gap: 12px; }
    .alumni-card { padding: 18px 12px; }
    .alumni-avatar { width: 56px; height: 56px; font-size: 17px; }
}
@media (max-width: 360px) { .alumni-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="network-page-wrap">

    {{-- Header --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #1a1a1a; margin: 0 0 5px; font-family: 'Georgia', serif;">Alumni Network</h1>
        <p style="color: #717182; font-size: 14px; margin: 0;">Connect and reconnect with fellow alumni</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #166534; font-size: 14px; font-family: 'Segoe UI', sans-serif;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fca5a5; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #991b1b; font-size: 14px; font-family: 'Segoe UI', sans-serif;">
            ✕ {{ session('error') }}
        </div>
    @endif

    {{-- Incoming Requests Panel --}}
    @if($pendingReceived->count() > 0)
    <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 24px 28px; margin-bottom: 32px;">
        <div class="section-title">
            Incoming Requests <span class="badge">{{ $pendingReceived->count() }}</span>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($pendingReceived as $req)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: #fafafa; border-radius: 12px; border: 1px solid rgba(128,0,32,0.07); flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: #fdf0f3; border: 2px solid rgba(128,0,32,0.15); display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800; color: #800020; flex-shrink: 0;">
                        {{ strtoupper(substr($req->requester->name, 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #1a1a1a; font-family: 'Segoe UI', sans-serif;">{{ $req->requester->name }}</div>
                        <div style="font-size: 12px; color: #717182; font-family: 'Segoe UI', sans-serif;">{{ $req->requester->course ?? 'N/A' }} · {{ $req->requester->batch_year ?? 'N/A' }}</div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <form method="POST" action="{{ route('alumni.network.accept', $req) }}">
                        @csrf
                        <button type="submit" style="background: #800020; color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('alumni.network.reject', $req) }}">
                        @csrf
                        <button type="submit" style="background: #fff; color: #991b1b; border: 1px solid #fca5a5; border-radius: 8px; padding: 8px 18px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Decline</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- People You May Know --}}
    @php
        $suggestions = $alumni->filter(fn($a) => !isset($connections[$a->id]))->take(6);
    @endphp
    @if($suggestions->count() > 0 && !request('search') && !request('batch'))
    <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 24px 28px; margin-bottom: 32px;">
        <div class="section-title">
            People You May Know
            <span style="font-size: 12px; color: #717182; font-weight: 400;">Alumni not yet connected with you</span>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px;">
            @foreach($suggestions as $alum)
            <div style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #fafafa; border-radius: 14px; border: 1px solid rgba(128,0,32,0.06);">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #fdf0f3; border: 2px solid rgba(128,0,32,0.15); display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 800; color: #800020; flex-shrink: 0;">
                    {{ strtoupper(substr($alum->name, 0, 2)) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 13px; font-weight: 600; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Segoe UI', sans-serif;">{{ $alum->name }}</div>
                    <div style="font-size: 11px; color: #717182; font-family: 'Segoe UI', sans-serif;">{{ $alum->course ?? 'N/A' }} · {{ $alum->batch_year ?? 'N/A' }}</div>
                    @if($alum->current_position)
                        <div style="font-size: 11px; color: #800020; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Segoe UI', sans-serif;">{{ $alum->current_position }}</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('alumni.network.connect', $alum) }}">
                    @csrf
                    <button type="submit" style="background: #800020; color: #fff; border: none; border-radius: 8px; padding: 7px 14px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif; white-space: nowrap;">
                        + Connect
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Search & Filters --}}
    <form method="GET" action="{{ route('alumni.network') }}" class="network-search-row" style="display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search by name, course, position..."
            style="flex: 1; min-width: 220px; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 16px; font-size: 14px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif; outline: none; box-sizing: border-box;">

        <select name="batch" style="background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 16px; font-size: 14px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif; outline: none; box-sizing: border-box;">
            <option value="">All Batches</option>
            @foreach($batchYears as $year)
                <option value="{{ $year }}" {{ request('batch') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>

        <button type="submit" style="background: #800020; color: #ffffff; border: none; border-radius: 12px; padding: 10px 24px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;">
            Search
        </button>

        @if(request('search') || request('batch'))
            <a href="{{ route('alumni.network') }}" style="background: #f8f8f8; color: #717182; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 20px; font-size: 14px; text-decoration: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box; display: inline-block;">
                Clear
            </a>
        @endif
    </form>

    {{-- Section label --}}
    <div class="section-title" style="margin-bottom: 20px;">
        All Alumni
        <span style="font-size: 12px; color: #717182; font-weight: 400;">{{ $alumni->total() }} {{ Str::plural('member', $alumni->total()) }}</span>
    </div>

    {{-- Alumni Grid --}}
    @if($alumni->isEmpty())
        <div style="text-align: center; padding: 80px 20px; background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08);">
            <div style="font-size: 48px; margin-bottom: 16px;">👥</div>
            <p style="color: #1a1a1a; font-size: 18px; font-weight: 500; margin: 0 0 8px; font-family: 'Segoe UI', sans-serif;">No alumni found</p>
            <p style="color: #717182; font-size: 14px; margin: 0; font-family: 'Segoe UI', sans-serif;">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="alumni-grid">
            @foreach($alumni as $alum)
                @php
                    $conn        = $connections[$alum->id] ?? null;
                    $status      = $conn ? $conn->status : null;
                    $isRequester = $conn ? ($conn->requester_id === auth()->id()) : false;
                @endphp
                <div class="alumni-card">
                    <div class="alumni-avatar">
                        {{ strtoupper(substr($alum->name, 0, 2)) }}
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; font-family: 'Segoe UI', sans-serif;">{{ $alum->name }}</div>
                    <div style="font-size: 12px; color: #717182; margin-bottom: 4px; font-family: 'Segoe UI', sans-serif;">{{ $alum->course ?? 'N/A' }} · {{ $alum->batch_year ?? 'N/A' }}</div>
                    @if($alum->current_position)
                        <div style="font-size: 12.5px; color: #800020; font-weight: 500; margin-bottom: 14px; font-family: 'Segoe UI', sans-serif;">{{ $alum->current_position }}</div>
                    @else
                        <div style="margin-bottom: 14px; font-size: 12px; color: #c0c0c0; font-family: 'Segoe UI', sans-serif;">No position listed</div>
                    @endif

                    @if($status === 'accepted')
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; color: #166534; font-weight: 600; padding: 8px; background: #f0fdf4; border-radius: 8px; font-family: 'Segoe UI', sans-serif;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Connected
                            </div>
                            <form method="POST" action="{{ route('alumni.network.disconnect', $conn) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="connect-btn" style="background: #fff; color: #991b1b; border: 1px solid #fca5a5; font-size: 12px; padding: 7px;"
                                    onclick="return confirm('Remove this connection?')">
                                    Disconnect
                                </button>
                            </form>
                        </div>

                    @elseif($status === 'pending' && $isRequester)
                        <button class="connect-btn" style="background: #f3f4f6; color: #717182; cursor: default;" disabled>
                            Request Sent
                        </button>

                    @elseif($status === 'pending' && !$isRequester)
                        <div style="display: flex; gap: 6px;">
                            <form method="POST" action="{{ route('alumni.network.accept', $conn) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="connect-btn" style="background: #800020; color: #fff;">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('alumni.network.reject', $conn) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="connect-btn" style="background: #fff; color: #991b1b; border: 1px solid #fca5a5;">Decline</button>
                            </form>
                        </div>

                    @else
                        <form method="POST" action="{{ route('alumni.network.connect', $alum) }}">
                            @csrf
                            <button type="submit" class="connect-btn" style="background: #800020; color: #fff; box-shadow: 0 4px 14px rgba(128,0,32,0.25);">
                                Connect
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        @if($alumni->hasPages())
            <div style="margin-top: 36px; display: flex; justify-content: center;">
                {{ $alumni->links() }}
            </div>
        @endif
    @endif

</div>
@endsection