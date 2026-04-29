<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Donation;         // ← changed
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;

class AlumniEventController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Event::with(['attendees'])
            ->where('is_archived', false);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $today = \Carbon\Carbon::today();
            match($request->status) {
                'upcoming'  => $query->where('event_date', '>', $today)->where('status', '!=', 'cancelled'),
                'past'      => $query->where('event_date', '<', $today)->where('status', '!=', 'cancelled'),
                'cancelled' => $query->where('status', 'cancelled'),
                default     => null,
            };
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(12)->withQueryString();

        $totalEvents   = Event::where('is_archived', false)->count();
        $myRsvpCount   = EventAttendee::where('user_id', $userId)->count();
        $upcomingCount = Event::where('is_archived', false)
            ->where('event_date', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->count();

        return view('alumni.events', compact(
            'events', 'myRsvpCount', 'upcomingCount', 'totalEvents'
        ));
    }

    public function rsvp(Event $event)
    {
        EventAttendee::firstOrCreate([
            'user_id'  => auth()->id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'You have successfully RSVP\'d to this event.');
    }

    public function cancelRsvp(Event $event)
    {
        EventAttendee::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->delete();

        return back()->with('success', 'Your RSVP has been cancelled.');
    }

    public function donate(Request $request, Event $event)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:999999',
            'note'   => 'nullable|string|max:255',
        ]);

        // Write to donations table (with pending status for admin approval)
        Donation::create([
            'event_id' => $event->id,
            'user_id'  => auth()->id(),
            'amount'   => $request->amount,
            'note'     => $request->note,
            'status'   => 'pending',
        ]);

        return back()->with('success', 'Thank you for your donation of ₱' . number_format($request->amount, 2) . '! It is pending admin approval.');
    }
}