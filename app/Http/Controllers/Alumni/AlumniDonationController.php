<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class AlumniDonationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // All donations by this alumni, newest first
        $donations = Donation::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        // Summary counts
        $totalDonated  = Donation::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $pendingCount  = Donation::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $approvedCount = Donation::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        return view('alumni.donations', compact(
            'donations',
            'totalDonated',
            'pendingCount',
            'approvedCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:999999',
            'note'   => 'nullable|string|max:255',
        ]);

        Donation::create([
            'user_id' => auth()->id(),
            'amount'  => $request->amount,
            'note'    => $request->note,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Your donation of ₱' . number_format($request->amount, 2) . ' has been submitted and is pending admin approval. Thank you!');
    }
}