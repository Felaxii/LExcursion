<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->query('country', '');
        $destinations = [];

        if ($country !== '') {
            $destinations = Destination::where('country', $country)
                ->with('flights')
                ->get();
        }

        return view('map', [
            'country'      => $country,
            'destinations' => $destinations,
        ]);
    }
}
