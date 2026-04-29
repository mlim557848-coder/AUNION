<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('alumni.profile', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('alumni.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'batch_year'   => 'nullable|digits:4',
            'course'       => 'nullable|string|max:255',
            'profile_photo'=> 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $skills = null;
        if ($request->filled('skills')) {
            $skills = array_values(array_filter(array_map('trim', explode(',', $request->skills))));
        }

        $data = [
            'name'             => $request->name,
            'batch_year'       => $request->batch_year,
            'course'           => $request->course,
            'contact_email'    => $request->contact_email,
            'phone'            => $request->phone,
            'address'          => $request->address,
            'linkedin'         => $request->linkedin,
            'current_position' => $request->current_position,
            'industry'         => $request->industry,
            'skills'           => $skills,
        ];

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path('profile_photos/' . $user->profile_photo))) {
                unlink(public_path('profile_photos/' . $user->profile_photo));
            }

            $file     = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_photos'), $filename);
            $data['profile_photo'] = $filename;
        }

        $user->update($data);

        return redirect()->route('alumni.profile')->with('success', 'Profile updated successfully!');
    }
}