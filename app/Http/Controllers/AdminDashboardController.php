<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Donation;        // ← changed from EventDonation

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAlumni        = User::where('role', 'alumni')->where('is_approved', 1)->count();
        $pendingApprovals   = User::where('role', 'alumni')->where('is_approved', 0)->count();
        $totalEvents        = Event::where('is_archived', 0)->count();
        $totalAnnouncements = Announcement::where('is_published', 1)->count();

        $recentAlumni = User::where('role', 'alumni')
                            ->where('is_approved', 1)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
                               ->where('is_archived', 0)
                               ->orderBy('event_date')
                               ->take(3)
                               ->get();

        $recentAnnouncements = Announcement::where('is_published', 1)
                                           ->orderBy('published_at', 'desc')
                                           ->take(3)
                                           ->get();

        // Donations — approved only
        $totalDonations  = Donation::where('status', 'approved')->sum('amount');
        $totalDonors     = Donation::where('status', 'approved')->distinct('user_id')->count('user_id');
        $recentDonations = Donation::with(['user', 'event'])
                                   ->where('status', 'approved')
                                   ->orderBy('created_at', 'desc')
                                   ->take(5)
                                   ->get();

        return view('admin.dashboard', compact(
            'totalAlumni',
            'pendingApprovals',
            'totalEvents',
            'totalAnnouncements',
            'recentAlumni',
            'upcomingEvents',
            'recentAnnouncements',
            'totalDonations',
            'totalDonors',
            'recentDonations'
        ));
    }
}