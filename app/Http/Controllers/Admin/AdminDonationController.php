<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventBudgetAllocation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['user', 'approvedBy'])->latest();

        // ── Filter by status ──────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ── Filter by period (day / month / year) ─────────────
        if ($request->filled('period')) {
            match($request->period) {
                'today' => $query->whereDate('created_at', Carbon::today()),
                'month' => $query->whereMonth('created_at', Carbon::now()->month)
                                  ->whereYear('created_at',  Carbon::now()->year),
                'year'  => $query->whereYear('created_at', Carbon::now()->year),
                default => null,
            };
        }

        // ── Custom date range ──────────────────────────────────
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $donations = $query->paginate(20)->withQueryString();

        // ── Summary KPIs ───────────────────────────────────────
        $totalDonations   = Donation::count();
        $pendingCount     = Donation::where('status', 'pending')->count();
        $approvedCount    = Donation::where('status', 'approved')->count();
        $totalApprovedAmt = Donation::where('status', 'approved')->sum('amount');

        // ── Pool: total approved minus total already allocated ─
        $totalAllocated   = EventBudgetAllocation::sum('amount');
        $availablePool    = max(0, $totalApprovedAmt - $totalAllocated);

        // ── Period totals for summary strip ───────────────────
        $todayTotal = Donation::where('status', 'approved')
            ->whereDate('created_at', Carbon::today())->sum('amount');
        $monthTotal = Donation::where('status', 'approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at',  Carbon::now()->year)->sum('amount');
        $yearTotal  = Donation::where('status', 'approved')
            ->whereYear('created_at', Carbon::now()->year)->sum('amount');

        // ── Recent allocations (last 5) for sidebar display ───
        $recentAllocations = EventBudgetAllocation::with(['event', 'allocatedBy'])
            ->latest()
            ->take(5)
            ->get();

        // ── Events list for allocation dropdown ───────────────
        $events = Event::where('is_archived', 0)
            ->where('status', '!=', 'cancelled')
            ->orderBy('event_date', 'desc')
            ->get(['id', 'title', 'event_date']);

        return view('admin.donations.index', compact(
            'donations',
            'totalDonations',
            'pendingCount',
            'approvedCount',
            'totalApprovedAmt',
            'totalAllocated',
            'availablePool',
            'todayTotal',
            'monthTotal',
            'yearTotal',
            'recentAllocations',
            'events'
        ));
    }

    public function approve(Request $request, Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'This donation has already been processed.');
        }

        $donation->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Donation of ₱' . number_format($donation->amount, 2) . ' approved successfully.');
    }

    public function reject(Request $request, Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return back()->with('error', 'This donation has already been processed.');
        }

        $donation->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Donation rejected.');
    }

    /**
     * Pool-based allocation: admin picks event + custom amount (up to availablePool).
     * No longer tied to a single donation row.
     */
    public function allocate(Request $request)
    {
        // Recalculate available pool at time of submission
        $totalApproved  = Donation::where('status', 'approved')->sum('amount');
        $totalAllocated = EventBudgetAllocation::sum('amount');
        $availablePool  = max(0, $totalApproved - $totalAllocated);

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'amount'   => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($availablePool) {
                    if ($value > $availablePool) {
                        $fail('Amount exceeds the available pool of ₱' . number_format($availablePool, 2) . '.');
                    }
                },
            ],
            'note' => 'nullable|string|max:255',
        ]);

        $event = Event::findOrFail($request->event_id);

        // Create allocation record
        EventBudgetAllocation::create([
            'event_id'     => $event->id,
            'amount'       => $request->amount,
            'note'         => $request->note ?? 'Pool allocation to "' . $event->title . '" by ' . auth()->user()->name,
            'allocated_by' => auth()->id(),
        ]);

        // Keep event's allocated_budget column in sync
        $event->increment('allocated_budget', $request->amount);

        return back()->with('success', '₱' . number_format($request->amount, 2) . ' allocated to "' . $event->title . '" successfully.');
    }
}