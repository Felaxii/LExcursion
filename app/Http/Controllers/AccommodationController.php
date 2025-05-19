<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Services\BookingComService;

class AccommodationController extends Controller
{
    public function show(Request $request, BookingComService $booking)
    {
        $city         = $request->query('city', 'London');
        $checkInDate  = $request->query('checkInDate', date('Y-m-d'));
        $checkOutDate = $request->query('checkOutDate', date('Y-m-d', strtotime('+1 day')));
        $adults       = $request->query('adults', 2);

        $orderMap = [
            'price_asc'            => 'price',
            'price_desc'           => 'class_descending',
            'rating'               => 'review_score',
            'best_rating_for_price'=> 'upsort_bh',
        ];
        $orderInput = $request->query('order_by', 'price_asc');
        $order_by   = $orderMap[$orderInput] ?? 'price';

        try {
            $destId     = $booking->getDestinationId($city);
            $hotelsData = $destId
                         ? $booking->getHotels($destId, $checkInDate, $checkOutDate, $adults, $order_by)
                         : ['result'=>[]];
            $message    = null;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $hotelsData = ['result'=>[]];
            $message    = "Error fetching hotels for {$city}. Please try again.";
        }

        $currency = session('currency','EUR');
        if ($currency !== 'EUR') {
            $rate = Cache::remember("fx_EUR_{$currency}", now()->addHour(), function() use($currency) {
                $resp = Http::get('https://api.exchangerate.host/latest', [
                    'base'    => 'EUR',
                    'symbols' => $currency,
                ])->json();
                return $resp['rates'][$currency] ?? 1;
            });
            foreach ($hotelsData['result'] as &$hotel) {
                if (isset($hotel['min_total_price']) && is_numeric($hotel['min_total_price'])) {
                    $hotel['min_total_price'] = round($hotel['min_total_price'] * $rate, 2);
                }
            }
        }


        return view('accommodations', [
            'city'         => $city,
            'hotelsData'   => $hotelsData,
            'checkInDate'  => $checkInDate,
            'checkOutDate' => $checkOutDate,
            'adults'       => $adults,
            'order_by'     => $orderInput,
            'message'      => $message,
        ]);
    }
}
