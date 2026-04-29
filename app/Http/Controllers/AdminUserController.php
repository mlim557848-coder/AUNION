<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'alumni');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            match($request->status) {
                'approved' => $query->where('is_approved', 1)->where('is_archived', 0),
                'pending'  => $query->where('is_approved', 0)->where('is_archived', 0),
                'rejected' => $query->where('is_archived', 1),
                default    => null,
            };
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // KPI counts (always unfiltered)
        $pendingCount  = User::where('role', 'alumni')->where('is_approved', 0)->where('is_archived', 0)->count();
        $activeCount   = User::where('role', 'alumni')->where('is_approved', 1)->where('is_archived', 0)->count();
        $totalCount    = User::where('role', 'alumni')->count();
        $rejectedCount = User::where('role', 'alumni')->where('is_archived', 1)->count();

        return view('admin.users.index', compact(
            'users',
            'pendingCount',
            'activeCount',
            'totalCount',
            'rejectedCount'
        ));
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => 1, 'is_archived' => 0]);
        return back()->with('success', "{$user->name} has been approved.");
    }

    public function reject(User $user)
    {
        $user->update(['is_approved' => 0, 'is_archived' => 1]);
        return back()->with('success', "{$user->name} has been rejected.");
    }

    public function archive(User $user)
    {
        $user->update(['is_archived' => 1]);
        return back()->with('success', "{$user->name} has been archived.");
    }

    public function restore(User $user)
    {
        $user->update(['is_approved' => 0, 'is_archived' => 0]);
        return back()->with('success', "{$user->name} has been restored to pending.");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email', 'batch_year', 'course']));
        return back()->with('success', 'User updated successfully.');
    }
}