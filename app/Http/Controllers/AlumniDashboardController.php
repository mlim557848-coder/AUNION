<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Connection;
use App\Models\Announcement;
use App\Models\ProfileView;
use App\Models\EventAttendee;
use Illuminate\Support\Facades\Auth;

class AlumniDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalAlumni = User::where('role', 'alumni')
            ->where('is_approved', 1)
            ->where('is_archived', 0)
            ->count();

        $upcomingEventsCount = Event::where('event_date', '>=', now())
            ->where('is_archived', 0)
            ->count();

        $upcomingEvents = Event::where('event_date', '>=', now())
            ->where('is_archived', 0)
            ->orderBy('event_date')
            ->take(3)
            ->get();

        $announcementsCount = Announcement::published()->count();

        $connectionsCount = Connection::where(function ($q) use ($user) {
                $q->where('requester_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->where('status', 'accepted')
            ->count();

        $profileViews = ProfileView::where('viewed_id', $user->id)->count();

        $eventsAttended = EventAttendee::where('user_id', $user->id)->count();

        $announcements = Announcement::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentActivity = EventAttendee::where('user_id', $user->id)
            ->with('event')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($a) => [
                'text' => 'You RSVP\'d to: ' . $a->event->title,
                'time' => $a->created_at->diffForHumans(),
            ]);

        return view('alumni.dashboard', compact(
            'totalAlumni',
            'upcomingEventsCount',
            'upcomingEvents',
            'announcementsCount',
            'connectionsCount',
            'profileViews',
            'eventsAttended',
            'announcements',
            'recentActivity',
        ));
    }
}