<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function currency(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|in:USD,EUR,GBP,JPY,AUD',
        ]);

        // Store chosen currency in session
        session(['currency' => $request->currency]);

        // Redirect back to wherever the user was
        return back();
    }
}
