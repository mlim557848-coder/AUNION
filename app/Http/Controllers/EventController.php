<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventAttendee;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())
            ->where('is_archived', false)
            ->get();

        $registeredEvents = auth()->user()->attendedEvents()->get();

        return view('alumni.events', compact('upcomingEvents', 'registeredEvents'));
    }

    public function register($eventId)
    {
        $user = auth()->user();

        EventAttendee::firstOrCreate([
            'event_id' => $eventId,
            'user_id' => $user->id
        ]);

        return back()->with('success', 'Successfully registered for the event!');
    }
}