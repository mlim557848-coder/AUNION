@extends('admin.layout')

@section('page-title', 'Event Attendees')
@section('page-subtitle', $event->title)

@section('content')
<div style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto; font-family: 'Segoe UI', sans-serif;">

    {{-- Back + Header --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px;">
        <div>
            <a href="{{ route('admin.events.index') }}"
               style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #717182; text-decoration: none; margin-bottom: 10px; font-family: 'Segoe UI', sans-serif;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Back to Events
            </a>
            <h1 style="font-size: 26px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px; font-family: 'Segoe UI', sans-serif;">Event Attendees</h1>
            <p style="font-size: 14px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Alumni who RSVP'd to this event</p>
        </div>
    </div>

    {{-- Event Info Banner --}}
    <div style="background: linear-gradient(135deg, #800020 0%, #5a0016 100%); border-radius: 18px; padding: 28px 32px; margin-bottom: 28px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
        <div style="position: absolute; bottom: -30px; right: 100px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>

        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 20px; position: relative; z-index: 1;">
            <div>
                <p style="font-size: 12px; color: rgba(255,255,255,0.6); margin: 0 0 6px; font-family: 'Segoe UI', sans-serif; text-transform: uppercase; letter-spacing: 0.06em;">Event</p>
                <h2 style="font-size: 22px; font-weight: 700; color: #ffffff; margin: 0 0 14px; font-family: 'Segoe UI', sans-serif;">{{ $event->title }}</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); border-radius: 20px; padding: 6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span style="font-size: 13px; color: #ffffff; font-family: 'Segoe UI', sans-serif;">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}
                        </span>
                    </div>
                    @if($event->event_time)
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); border-radius: 20px; padding: 6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span style="font-size: 13px; color: #ffffff; font-family: 'Segoe UI', sans-serif;">
                            {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                        </span>
                    </div>
                    @endif
                    @if($event->location)
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.12); border-radius: 20px; padding: 6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.85)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span style="font-size: 13px; color: #ffffff; font-family: 'Segoe UI', sans-serif;">{{ $event->location }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RSVP Count Pill --}}
            <div style="background: #FDB813; border-radius: 16px; padding: 18px 24px; text-align: center; flex-shrink: 0;">
                <p style="font-size: 36px; font-weight: 300; color: #5c3700; margin: 0; line-height: 1; font-family: 'Segoe UI', sans-serif;">{{ $attendees->count() }}</p>
                <p style="font-size: 12px; color: #5c3700; font-weight: 600; margin: 4px 0 0; font-family: 'Segoe UI', sans-serif;">RSVPs</p>
            </div>
        </div>
    </div>

    {{-- Attendees Table --}}
    @if($attendees->count() > 0)

        <p style="font-size: 12px; color: #717182; margin: 0 0 14px; font-family: 'Segoe UI', sans-serif;">
            Showing {{ $attendees->count() }} {{ Str::plural('attendee', $attendees->count()) }}
        </p>

        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #800020;">
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">#</th>
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Alumni</th>
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Student ID</th>
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Course</th>
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Batch Year</th>
                        <th style="padding: 14px 18px; text-align: left; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">RSVP'd At</th>
                        <th style="padding: 14px 18px; text-align: right; font-size: 12px; font-weight: 600; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendees as $index => $attendee)
                    @php $user = $attendee->user; @endphp
                    @if($user)
                    <tr style="border-bottom: 1px solid rgba(128,0,32,0.06);"
                        onmouseover="this.style.background='#fafafa'"
                        onmouseout="this.style.background='#ffffff'">

                        <td style="padding: 16px 18px; font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif;">
                            {{ $index + 1 }}
                        </td>

                        <td style="padding: 16px 18px; font-family: 'Segoe UI', sans-serif;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #800020; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #ffffff; flex-shrink: 0;">
                                    {{ strtoupper(substr($user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p style="font-size: 14px; font-weight: 600; color: #1a1a1a; margin: 0 0 2px;">{{ $user->name }}</p>
                                    <p style="font-size: 12px; color: #717182; margin: 0;">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 16px 18px; font-size: 13px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif;">
                            {{ $user->student_id ?? '—' }}
                        </td>

                        <td style="padding: 16px 18px; font-size: 13px; color: #1a1a1a; font-family: 'Segoe UI', sans-serif;">
                            {{ $user->course ?? '—' }}
                        </td>

                        <td style="padding: 16px 18px; font-family: 'Segoe UI', sans-serif;">
                            @if($user->batch_year)
                                <span style="background: rgba(128,0,32,0.07); color: #800020; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">
                                    {{ $user->batch_year }}
                                </span>
                            @else
                                <span style="font-size: 13px; color: #717182;">—</span>
                            @endif
                        </td>

                        <td style="padding: 16px 18px; font-size: 13px; color: #717182; font-family: 'Segoe UI', sans-serif;">
                            {{ \Carbon\Carbon::parse($attendee->created_at)->format('M j, Y · g:i A') }}
                        </td>

                        <td style="padding: 16px 18px; text-align: right; font-family: 'Segoe UI', sans-serif;">
                            <a href="{{ route('admin.alumni-records.show', $user) }}"
                               style="background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); color: #1a1a1a; font-size: 12px; font-weight: 500; padding: 6px 14px; border-radius: 8px; text-decoration: none; font-family: 'Segoe UI', sans-serif;">
                                View Profile
                            </a>
                        </td>

                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.07); padding: 60px 40px; text-align: center;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity: 0.3; display: block; margin: 0 auto 16px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <p style="font-size: 15px; color: #717182; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif; font-weight: 600;">No attendees yet</p>
            <p style="font-size: 13px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">No alumni have RSVP'd to this event.</p>
        </div>
    @endif

</div>
@endsection