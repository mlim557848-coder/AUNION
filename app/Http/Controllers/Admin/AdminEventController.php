<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\EventDonation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['attendees', 'donations'])->where('is_archived', 0);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $today = Carbon::today();
            match($request->status) {
                'upcoming'  => $query->where('event_date', '>', $today)->where('status', '!=', 'cancelled'),
                'ongoing'   => $query->whereDate('event_date', $today),
                'past'      => $query->where('event_date', '<', $today)->where('status', '!=', 'cancelled'),
                'cancelled' => $query->where('status', 'cancelled'),
                default     => null,
            };
        }

        $events = $query->orderBy('event_date', 'asc')->paginate(20)->withQueryString();

        $today           = Carbon::today();
        $totalEvents     = Event::where('is_archived', 0)->count();
        $upcomingEvents  = Event::where('is_archived', 0)->where('event_date', '>', $today)->where('status', '!=', 'cancelled')->count();
        $thisMonthEvents = Event::where('is_archived', 0)->whereMonth('event_date', $today->month)->whereYear('event_date', $today->year)->count();
        $totalAttendees  = EventAttendee::count();

        return view('admin.events.index', compact(
            'events', 'totalEvents', 'upcomingEvents', 'thisMonthEvents', 'totalAttendees'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location'   => 'required|string|max:255',
        ]);

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'event_date'  => $request->event_date,
            'event_time'  => $request->event_time,
            'status'      => 'upcoming',
            'is_archived' => 0,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location'   => 'required|string|max:255',
        ]);

        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'event_date'  => $request->event_date,
            'event_time'  => $request->event_time,
            'status'      => $request->status ?? $event->status,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->update(['status' => 'cancelled']);
        return redirect()->route('admin.events.index')->with('success', 'Event cancelled.');
    }

    public function attendees(Event $event)
    {
        $attendees = $event->attendees()->with('user')->get();
        return view('admin.events.attendees', compact('event', 'attendees'));
    }

    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event);
    }

    public function create()
    {
        return redirect()->route('admin.events.index');
    }

    public function budget(Event $event)
{
    // Direct event donations (alumni donating to a specific event)
    $donations = EventDonation::where('event_id', $event->id)
        ->with('user')
        ->orderByDesc('created_at')
        ->get()
        ->map(fn($d) => [
            'name'       => $d->user->name       ?? 'Unknown',
            'student_id' => $d->user->student_id ?? '—',
            'amount'     => (float) $d->amount,
            'note'       => $d->note ?? '',
            'date'       => $d->created_at->format('M d, Y'),
        ]);
 
    // Admin-approved allocations to this event
    $allocations = \App\Models\EventBudgetAllocation::where('event_id', $event->id)
        ->with('allocatedBy')
        ->orderByDesc('created_at')
        ->get()
        ->map(fn($a) => [
            'allocated_by' => $a->allocatedBy->name ?? 'Admin',
            'amount'       => (float) $a->amount,
            'note'         => $a->note ?? '',
            'date'         => $a->created_at->format('M d, Y'),
        ]);
 
    return response()->json([
        'allocated_budget' => (float) $allocations->sum('amount'),
        'total_donated'    => (float) $donations->sum('amount'),
        'allocations'      => $allocations->values(),
        'donations'        => $donations->values(),
    ]);
}
}