<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingComService;

class AccommodationController extends Controller
{
    public function show(Request $request, BookingComService $booking)
    {
        $city = $request->query('city', 'London');
        $checkInDate = $request->query('checkInDate', date('Y-m-d'));
        $checkOutDate = $request->query('checkOutDate', date('Y-m-d', strtotime('+1 day')));
        $adults = $request->query('adults', 2);
        
        // Read the sort filter from the query (default to "price_asc")
        $orderInput = $request->query('order_by', 'price_asc');
        // Map our friendly sort options to the API allowed values.
        $allowedMapping = [
            'price_asc'           => 'price',
            'price_desc'          => 'class_descending', // assuming this sorts by price descending
            'rating'              => 'review_score',
            'best_rating_for_price' => 'upsort_bh',
        ];
        $order_by = $allowedMapping[$orderInput] ?? 'price';

        try {
            $destId = $booking->getDestinationId($city);
            if (!$destId) {
                throw new \Exception("No destination ID found for {$city}");
            }

            $hotelsData = $booking->getHotels($destId, $checkInDate, $checkOutDate, $adults, $order_by);
            $errorMessage = null;
        } catch (\Exception $e) {
            \Log::error("BookingCom Error: " . $e->getMessage());
            $hotelsData = null;
            $errorMessage = "Error fetching hotels for {$city}. Please try again.";
        }

        return view('accommodations', [
            'city'         => $city,
            'hotelsData'   => $hotelsData,
            'checkInDate'  => $checkInDate,
            'checkOutDate' => $checkOutDate,
            'adults'       => $adults,
            'order_by'     => $orderInput,  // pass the friendly value to the view
            'message'      => $errorMessage,
        ]);
    }
}
