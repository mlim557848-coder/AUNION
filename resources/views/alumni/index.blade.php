@extends('alumni.layout')

@section('content')
<div style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto; font-family: 'Segoe UI', sans-serif;">

    {{-- Page Header --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 28px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px;">Events</h1>
        <p style="color: #717182; font-size: 15px; margin: 0;">Browse and RSVP to upcoming alumni events</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #166534; font-size: 14px;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fca5a5; border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; color: #991b1b; font-size: 14px;">
            ✕ {{ session('error') }}
        </div>
    @endif

    {{-- KPI Cards --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 36px;">

        {{-- Card 1 --}}
        <div style="background: #800020; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #ffffff;">Total Events</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #ffffff;">{{ $totalEvents }}</p>
        </div>

        {{-- Card 2 --}}
        <div style="background: #FDB813; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.18);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #5c3700;">Upcoming</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #5c3700;">{{ $upcomingCount }}</p>
        </div>

        {{-- Card 3 --}}
        <div style="background: #9b3a54; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #ffffff;">My RSVPs</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #ffffff;">{{ $myRsvpCount }}</p>
        </div>

    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('alumni.events') }}" style="display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap;">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search events..."
            style="flex: 1; min-width: 200px; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 16px; font-size: 14px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif; outline: none;">

        <select name="status" style="background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 16px; font-size: 14px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif; outline: none;">
            <option value="">All Events</option>
            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
            <option value="past" {{ request('status') === 'past' ? 'selected' : '' }}>Past</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" style="background: #800020; color: #ffffff; border: none; border-radius: 12px; padding: 10px 24px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
            Search
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('alumni.events') }}" style="background: #f8f8f8; color: #717182; border: 1px solid rgba(128,0,32,0.15); border-radius: 12px; padding: 10px 20px; font-size: 14px; text-decoration: none; font-family: 'Segoe UI', sans-serif;">
                Clear
            </a>
        @endif
    </form>

    {{-- Events Grid --}}
    @if($events->isEmpty())
        <div style="text-align: center; padding: 80px 20px; background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08);">
            <div style="font-size: 48px; margin-bottom: 16px;">📅</div>
            <p style="color: #1a1a1a; font-size: 18px; font-weight: 500; margin: 0 0 8px;">No events found</p>
            <p style="color: #717182; font-size: 14px; margin: 0;">Check back later for upcoming alumni events.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 20px;">
            @foreach($events as $event)
                @php
                    $isPast      = \Carbon\Carbon::parse($event->event_date)->isPast();
                    $isCancelled = $event->status === 'cancelled';
                    $isRsvpd     = $event->attendees->contains('user_id', auth()->id());
                @endphp

                <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 24px; display: flex; flex-direction: column; gap: 12px; {{ $isPast || $isCancelled ? 'opacity: 0.75;' : '' }}">

                    {{-- Status Badge + Date --}}
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        @if($isCancelled)
                            <span style="background: #fff1f2; color: #991b1b; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Cancelled</span>
                        @elseif($isPast)
                            <span style="background: rgba(128,0,32,0.07); color: #800020; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Past</span>
                        @else
                            <span style="background: #f0fdf4; color: #166534; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming</span>
                        @endif

                        <span style="font-size: 13px; color: #717182;">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h3 style="font-size: 17px; font-weight: 600; color: #1a1a1a; margin: 0; line-height: 1.3;">
                        {{ $event->title }}
                    </h3>

                    {{-- Description --}}
                    @if($event->description)
                        <p style="font-size: 14px; color: #717182; margin: 0; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $event->description }}
                        </p>
                    @endif

                    {{-- Meta --}}
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #717182;">
                            <span>📍</span>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #717182;">
                            <span>🕐</span>
                            <span>{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #717182;">
                            <span>👥</span>
                            <span>{{ $event->attendees->count() }} {{ Str::plural('attendee', $event->attendees->count()) }}</span>
                        </div>
                    </div>

                    {{-- RSVP Button --}}
                    <div style="margin-top: auto; padding-top: 8px;">
                        @if($isCancelled)
                            <button disabled style="width: 100%; padding: 10px; border-radius: 50px; font-size: 14px; font-weight: 500; background: #f8f8f8; color: #717182; border: 1px solid rgba(128,0,32,0.1); cursor: not-allowed; font-family: 'Segoe UI', sans-serif;">
                                Event Cancelled
                            </button>
                        @elseif($isPast)
                            <button disabled style="width: 100%; padding: 10px; border-radius: 50px; font-size: 14px; font-weight: 500; background: #f8f8f8; color: #717182; border: 1px solid rgba(128,0,32,0.1); cursor: not-allowed; font-family: 'Segoe UI', sans-serif;">
                                Event Ended
                            </button>
                        @elseif($isRsvpd)
                            <div style="display: flex; gap: 8px;">
                                <button disabled style="flex: 1; padding: 10px; border-radius: 50px; font-size: 14px; font-weight: 500; background: rgba(128,0,32,0.07); color: #800020; border: 1px solid rgba(128,0,32,0.15); cursor: default; font-family: 'Segoe UI', sans-serif;">
                                    ✓ RSVP'd
                                </button>
                                <form method="POST" action="{{ route('alumni.events.cancel-rsvp', $event) }}" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 50px; font-size: 14px; font-weight: 500; background: #fff; color: #991b1b; border: 1px solid #fca5a5; cursor: pointer; font-family: 'Segoe UI', sans-serif;"
                                        onclick="return confirm('Cancel your RSVP for this event?')">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @else
                            <form method="POST" action="{{ route('alumni.events.rsvp', $event) }}">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 10px; border-radius: 50px; font-size: 14px; font-weight: 500; background: #800020; color: #ffffff; border: none; cursor: pointer; font-family: 'Segoe UI', sans-serif;"
                                    onmouseover="this.style.background='#6b001a'"
                                    onmouseout="this.style.background='#800020'">
                                    RSVP Now
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
            <div style="margin-top: 36px; display: flex; justify-content: center;">
                {{ $events->links() }}
            </div>
        @endif
    @endif

</div>
@endsection