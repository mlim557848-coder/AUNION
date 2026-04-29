@extends('alumni.layout')

@section('title', 'Events')

@section('content')
<div style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto; font-family: 'Segoe UI', sans-serif;">

    {{-- Page Header --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px;">Events</h1>
        <p style="font-size: 14px; color: #717182; margin: 0;">Browse and RSVP to upcoming alumni events.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span style="font-size: 14px; color: #15803d;">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size: 14px; color: #dc2626;">{{ session('error') }}</span>
        </div>
    @endif

    {{-- KPI Strip --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 36px;">

        {{-- Card 1: Total Events --}}
        <div style="background: #800020; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Total Events</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #ffffff; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $events->total() }}</p>
        </div>

        {{-- Card 2: My RSVPs --}}
        <div style="background: #FDB813; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.18);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #5c3700; font-family: 'Segoe UI', sans-serif;">My RSVPs</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #5c3700; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $myRsvpCount }}</p>
        </div>

        {{-- Card 3: This Month --}}
        <div style="background: #9b3a54; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0 0 18px; color: #ffffff; font-family: 'Segoe UI', sans-serif;">This Month</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #ffffff; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $thisMonthCount }}</p>
        </div>

    </div>

    {{-- Events Grid --}}
    @if($events->isEmpty())
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 64px 40px; text-align: center;">
            <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity: 0.35; margin-bottom: 16px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif;">No Events Found</p>
            <p style="font-size: 14px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">There are no upcoming events at this time. Check back soon!</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 24px; margin-bottom: 36px;">
            @foreach($events as $event)
                @php
                    $isRsvped = $event->attendees->contains('user_id', auth()->id());
                    $isPast = \Carbon\Carbon::parse($event->event_date)->isPast();
                    $statusColor = match($event->status) {
                        'upcoming' => ['bg' => '#f0fdf4', 'text' => '#15803d', 'dot' => '#22c55e'],
                        'ongoing'  => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'dot' => '#3b82f6'],
                        'past'     => ['bg' => '#f9fafb', 'text' => '#6b7280', 'dot' => '#9ca3af'],
                        default    => ['bg' => '#fef9ec', 'text' => '#92400e', 'dot' => '#f59e0b'],
                    };
                @endphp

                <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden; display: flex; flex-direction: column; transition: box-shadow 0.2s;"
                     onmouseover="this.style.boxShadow='0 8px 32px rgba(128,0,32,0.10)'"
                     onmouseout="this.style.boxShadow='none'">

                    {{-- Card Header Banner --}}
                    <div style="background: linear-gradient(135deg, #800020 0%, #a0003a 100%); padding: 24px 24px 20px; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -20px; right: -20px; width: 90px; height: 90px; border-radius: 50%; background: rgba(255,255,255,0.06);"></div>
                        <div style="position: absolute; bottom: -30px; left: -10px; width: 70px; height: 70px; border-radius: 50%; background: rgba(253,184,19,0.10);"></div>

                        {{-- Status Badge --}}
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; position: relative; z-index: 1;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; font-family: 'Segoe UI', sans-serif; text-transform: uppercase; letter-spacing: 0.5px;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: {{ $statusColor['dot'] }}; display: inline-block;"></span>
                                {{ ucfirst($event->status ?? 'upcoming') }}
                            </span>
                            @if($isRsvped)
                                <span style="background: #FDB813; color: #5c3700; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; font-family: 'Segoe UI', sans-serif; text-transform: uppercase; letter-spacing: 0.5px;">✓ RSVP'd</span>
                            @endif
                        </div>

                        {{-- Event Title --}}
                        <h3 style="font-size: 17px; font-weight: 700; color: #ffffff; margin: 0; line-height: 1.3; position: relative; z-index: 1; font-family: 'Segoe UI', sans-serif;">{{ $event->title }}</h3>
                    </div>

                    {{-- Card Body --}}
                    <div style="padding: 20px 24px; flex: 1; display: flex; flex-direction: column;">

                        {{-- Meta Info --}}
                        <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                            <div style="display: flex; align-items: center; gap: 9px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2" style="flex-shrink:0;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <span style="font-size: 13px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif; font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}
                                    @if($event->event_time)
                                        &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                            @if($event->location)
                                <div style="display: flex; align-items: center; gap: 9px;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2" style="flex-shrink:0;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span style="font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif;">{{ $event->location }}</span>
                                </div>
                            @endif
                            <div style="display: flex; align-items: center; gap: 9px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="2" style="flex-shrink:0;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span style="font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif;">{{ $event->attendees->count() }} {{ Str::plural('attendee', $event->attendees->count()) }}</span>
                            </div>
                        </div>

                        {{-- Description --}}
                        @if($event->description)
                            <p style="font-size: 13px; color: #717182; line-height: 1.6; margin: 0 0 20px; font-family: 'Segoe UI', sans-serif; flex: 1;">
                                {{ Str::limit($event->description, 110) }}
                            </p>
                        @else
                            <div style="flex: 1;"></div>
                        @endif

                        {{-- RSVP Action --}}
                        <div style="border-top: 1px solid rgba(128,0,32,0.08); padding-top: 16px; margin-top: auto;">
                            @if($isPast || $event->status === 'past')
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #f9fafb; border-radius: 10px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span style="font-size: 13px; color: #9ca3af; font-family: 'Segoe UI', sans-serif; font-weight: 500;">Event has ended</span>
                                </div>
                            @elseif($isRsvped)
                                <form method="POST" action="{{ route('alumni.events.cancel-rsvp', $event) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width: 100%; padding: 11px; background: #ffffff; color: #800020; border: 1.5px solid #800020; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif; transition: all 0.15s;"
                                            onmouseover="this.style.background='#fff1f4'"
                                            onmouseout="this.style.background='#ffffff'">
                                        Cancel RSVP
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('alumni.events.rsvp', $event) }}">
                                    @csrf
                                    <button type="submit"
                                            style="width: 100%; padding: 11px; background: #800020; color: #ffffff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif; transition: all 0.15s;"
                                            onmouseover="this.style.background='#6b001a'"
                                            onmouseout="this.style.background='#800020'">
                                        RSVP to this Event
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
            <div style="display: flex; justify-content: center; gap: 8px; flex-wrap: wrap;">
                {{-- Previous --}}
                @if($events->onFirstPage())
                    <span style="padding: 8px 16px; border-radius: 10px; background: #f3f4f6; color: #9ca3af; font-size: 14px; font-family: 'Segoe UI', sans-serif; cursor: default;">← Prev</span>
                @else
                    <a href="{{ $events->previousPageUrl() }}"
                       style="padding: 8px 16px; border-radius: 10px; background: #ffffff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 14px; font-family: 'Segoe UI', sans-serif; text-decoration: none; font-weight: 500;">← Prev</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                    @if($page == $events->currentPage())
                        <span style="padding: 8px 14px; border-radius: 10px; background: #800020; color: #ffffff; font-size: 14px; font-family: 'Segoe UI', sans-serif; font-weight: 600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           style="padding: 8px 14px; border-radius: 10px; background: #ffffff; border: 1px solid rgba(128,0,32,0.15); color: #1a1a1a; font-size: 14px; font-family: 'Segoe UI', sans-serif; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($events->hasMorePages())
                    <a href="{{ $events->nextPageUrl() }}"
                       style="padding: 8px 16px; border-radius: 10px; background: #ffffff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 14px; font-family: 'Segoe UI', sans-serif; text-decoration: none; font-weight: 500;">Next →</a>
                @else
                    <span style="padding: 8px 16px; border-radius: 10px; background: #f3f4f6; color: #9ca3af; font-size: 14px; font-family: 'Segoe UI', sans-serif; cursor: default;">Next →</span>
                @endif
            </div>
        @endif
    @endif

</div>
@endsection