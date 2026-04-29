<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\EventBudgetAllocation;
use App\Models\EventDonation;
use App\Models\User;
use App\Models\Connection;
use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminAlumniController extends Controller
{
    // ─────────────────────────────────────────────
    //  ALUMNI RECORDS INDEX
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = User::where('role', 'alumni')->where('is_archived', false);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('course', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('batch_year')) {
            $query->where('batch_year', $request->batch_year);
        }
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        $alumni = $query->orderBy('name')->paginate(15)->withQueryString();

        $base = User::where('role', 'alumni')->where('is_archived', false);

        $batchYears     = (clone $base)->whereNotNull('batch_year')->distinct()->orderBy('batch_year', 'desc')->pluck('batch_year');
        $totalAlumni    = (clone $base)->count();
        $approvedAlumni = (clone $base)->where('is_approved', true)->count();
        $pendingAlumni  = (clone $base)->where('is_approved', false)->count();
        $batchYearCount = (clone $base)->whereNotNull('batch_year')->distinct('batch_year')->count('batch_year');
        $courses        = (clone $base)->whereNotNull('course')->distinct()->orderBy('course')->pluck('course');

        return view('admin.alumni-records.index', compact(
            'alumni', 'batchYears', 'totalAlumni', 'approvedAlumni', 'pendingAlumni', 'batchYearCount', 'courses'
        ));
    }

    // ─────────────────────────────────────────────
    //  SHOW SINGLE ALUMNI
    // ─────────────────────────────────────────────
    public function show(User $user)
    {
        $attendeesCount = EventAttendee::where('user_id', $user->id)->count();

        $connectionsCount = Connection::where(function ($q) use ($user) {
            $q->where('requester_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->count();

        $rsvpdEvents = Event::whereHas('attendees', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orderBy('event_date', 'desc')->take(5)->get();

        return view('admin.alumni-records.show', compact(
            'user', 'connectionsCount', 'attendeesCount', 'rsvpdEvents'
        ));
    }

    // ─────────────────────────────────────────────
    //  REPORT PAGE — now just redirects to index
    //  (report form is embedded in the index page)
    // ─────────────────────────────────────────────
    public function report(Request $request)
    {
        return redirect()->route('admin.alumni-records.index');
    }

    // ─────────────────────────────────────────────
    //  PDF EXPORT (bulk — respects filters)
    // ─────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $reportType = $request->get('report_type', 'all');

        // ── Budget / Donations report ─────────────────────────────────────────
        if ($reportType === 'budget') {
            $period  = $request->get('period', 'all');
            $eventId = $request->get('event_id');

            // General donations
            $donationsQuery = Donation::with(['user', 'approvedBy'])->latest();
            if ($period === 'month') {
                $donationsQuery->whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year);
            } elseif ($period === 'year') {
                $donationsQuery->whereYear('created_at', now()->year);
            } elseif ($period === 'today') {
                $donationsQuery->whereDate('created_at', today());
            }
            $donations = $donationsQuery->get();

            // Event allocations
            $allocationsQuery = EventBudgetAllocation::with(['event', 'allocatedBy'])->latest();
            if ($eventId) {
                $allocationsQuery->where('event_id', $eventId);
            }
            $allocations = $allocationsQuery->get();

            // Event donations
            $eventDonationsQuery = EventDonation::with(['event', 'user'])->latest();
            if ($eventId) {
                $eventDonationsQuery->where('event_id', $eventId);
            }
            $eventDonations = $eventDonationsQuery->get();

            $events    = Event::where('is_archived', 0)->orderBy('event_date', 'desc')->get();
            $generated = now()->format('F d, Y \a\t g:i A');

            $pdf = Pdf::loadView('admin.alumni-records.report-budget-pdf', compact(
                'donations', 'allocations', 'eventDonations', 'events',
                'period', 'eventId', 'generated'
            ))->setPaper('a4', 'portrait');

            return $pdf->download('aunion-budget-report-' . now()->format('Y-m-d') . '.pdf');
        }

        // ── Alumni Records report ─────────────────────────────────────────────
        $query = User::where('role', 'alumni');

        if ($request->filled('batch_year')) {
            $query->where('batch_year', $request->batch_year);
        }
        if ($request->filled('course')) {
            $query->where('course', $request->course);
        }
        if ($request->filled('status') && $request->status !== '') {
            $query->where('is_approved', $request->status);
        }

        $alumni    = $query->orderBy('name')->get();
        $generated = now()->format('F d, Y \a\t g:i A');
        $filters   = $request->only(['report_type', 'batch_year', 'course', 'status']);

        $pdf = Pdf::loadView('admin.alumni-records.report-pdf', compact(
            'alumni', 'generated', 'filters'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('aunion-alumni-report-' . now()->format('Y-m-d') . '.pdf');
    }

    // ─────────────────────────────────────────────
    //  PDF EXPORT — SINGLE ALUMNI PROFILE
    // ─────────────────────────────────────────────
    public function exportSinglePdf(User $user)
    {
        $attendeesCount = EventAttendee::where('user_id', $user->id)->count();

        $connectionsCount = Connection::where(function ($q) use ($user) {
            $q->where('requester_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->count();

        $rsvpdEvents = Event::whereHas('attendees', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orderBy('event_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.alumni-records.pdf-single', compact(
            'user', 'attendeesCount', 'connectionsCount', 'rsvpdEvents'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('alumni-profile-' . str($user->name)->slug() . '.pdf');
    }
}