<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nickname'    => 'nullable|string|max:255',
            'full_name'   => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'occupation'  => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048', 
        ]);


        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        $user->update($validatedData);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
