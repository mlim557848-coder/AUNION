<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MasterAlumni;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.login'); // your combined login/register view
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => ['required', 'string', 'exists:master_alumni,student_id'],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'max:255'],
            'password'   => ['required', 'confirmed', 'min:6'],
        ], [
            'student_id.exists' => 'This Student ID is not in our alumni records.',
        ]);

        // Check if student_id is already registered
        if (User::where('student_id', $request->student_id)->exists()) {
            throw ValidationException::withMessages([
                'student_id' => 'An account with this Student ID already exists.',
            ]);
        }

        // Check email uniqueness only if provided
        if ($request->filled('email') && User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'This email address is already registered.',
            ]);
        }

        $master = MasterAlumni::where('student_id', $request->student_id)->firstOrFail();

        // Use provided email or generate a placeholder
        $email = $request->filled('email')
            ? $request->email
            : strtolower(str_replace(' ', '.', $master->full_name)) . '.' . $request->student_id . '@alumni.local';

        User::create([
            'name'             => $master->full_name,         // always use master record name
            'email'            => $email,
            'password'         => Hash::make($request->password),
            'role'             => 'alumni',
            'student_id'       => $request->student_id,
            'master_alumni_id' => $master->id,
            'batch_year'       => $master->batch_year,
            'course'           => $master->course,
            'is_approved'      => false,
            'is_archived'      => false,
        ]);

        return redirect()->route('login')
            ->with('status', 'Registration successful! Your account is pending admin approval.');
    }

    public function lookupAlumni(Request $request): \Illuminate\Http\JsonResponse
{
    $studentId = trim($request->query('student_id', ''));

    if (empty($studentId)) {
        return response()->json(['found' => false]);
    }

    $master = MasterAlumni::where('student_id', $studentId)->first();

    if (!$master) {
        return response()->json(['found' => false]);
    }

    // Check if already registered
    $alreadyRegistered = User::where('student_id', $studentId)->exists();

    return response()->json([
        'found'      => true,
        'name'       => $master->full_name,
        'course'     => $master->course,
        'batch_year' => $master->batch_year,
        'registered' => $alreadyRegistered,
    ]);
}
}