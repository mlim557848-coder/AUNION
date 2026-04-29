<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        return view('alumni.announcements', compact('announcements'));
    }
}