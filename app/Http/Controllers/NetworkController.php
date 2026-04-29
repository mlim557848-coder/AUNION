<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::user();

        $query = User::where('id', '!=', $authUser->id)
            ->where('role', 'alumni')
            ->where('is_approved', 1)
            ->where('is_archived', 0);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('course', 'like', "%{$search}%")
                  ->orWhere('current_position', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%")
                  ->orWhere('batch_year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('batch')) {
            $query->where('batch_year', $request->batch);
        }

        $alumni = $query->orderBy('name')->paginate(12)->withQueryString();

        // Map: other user ID → Connection object (not just status string)
        $myConnections = Connection::where(function ($q) use ($authUser) {
                $q->where('requester_id', $authUser->id)
                  ->orWhere('receiver_id', $authUser->id);
            })
            ->whereIn('status', ['pending', 'accepted'])
            ->get();

        $connections = [];
        foreach ($myConnections as $conn) {
            $otherId = $conn->requester_id === $authUser->id
                ? $conn->receiver_id
                : $conn->requester_id;
            $connections[$otherId] = $conn;
        }

        // Incoming pending requests sent TO me
        $pendingReceived = Connection::where('receiver_id', $authUser->id)
            ->where('status', 'pending')
            ->with('requester')
            ->latest()
            ->get();

        // Stats
        $totalAlumni = User::where('role', 'alumni')
            ->where('is_approved', 1)
            ->where('is_archived', 0)
            ->where('id', '!=', $authUser->id)
            ->count();

        $connectionsCount = Connection::where(function ($q) use ($authUser) {
                $q->where('requester_id', $authUser->id)
                  ->orWhere('receiver_id', $authUser->id);
            })
            ->where('status', 'accepted')
            ->count();

        $batchYears = User::where('role', 'alumni')
            ->where('is_approved', 1)
            ->whereNotNull('batch_year')
            ->distinct()
            ->orderByDesc('batch_year')
            ->pluck('batch_year');

        return view('alumni.network', compact(
            'alumni',
            'connections',
            'pendingReceived',
            'totalAlumni',
            'connectionsCount',
            'batchYears'
        ));
    }

    public function connect(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'You cannot connect with yourself.');
        }

        $exists = Connection::where(function ($q) use ($authUser, $user) {
                $q->where('requester_id', $authUser->id)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($authUser, $user) {
                $q->where('requester_id', $user->id)->where('receiver_id', $authUser->id);
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'A connection already exists.');
        }

        Connection::create([
            'requester_id' => $authUser->id,
            'receiver_id'  => $user->id,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Connection request sent to ' . $user->name . '.');
    }

    public function accept(Connection $connection)
    {
        if ($connection->receiver_id !== Auth::id()) abort(403);

        $connection->update(['status' => 'accepted']);

        return back()->with('success', 'Connection accepted.');
    }

    public function reject(Connection $connection)
    {
        if ($connection->receiver_id !== Auth::id()) abort(403);

        $connection->delete();

        return back()->with('success', 'Connection request declined.');
    }

    public function disconnect(Connection $connection)
    {
        $authUser = Auth::user();

        if ($connection->requester_id !== $authUser->id && $connection->receiver_id !== $authUser->id) {
            abort(403);
        }

        $connection->delete();

        return back()->with('success', 'Connection removed.');
    }
}