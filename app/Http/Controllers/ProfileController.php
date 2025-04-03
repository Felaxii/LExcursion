<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Display the profile page
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Show the form to complete or edit the profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update the profile
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input fields (you can customize the rules)
        $validatedData = $request->validate([
            'nickname'    => 'nullable|string|max:255',
            'full_name'   => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'occupation'  => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // Optionally delete the old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        // Update user with validated data
        $user->update($validatedData);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
