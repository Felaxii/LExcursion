<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookingComService
{
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        $this->apiKey  = config('services.bookingcom.key');
        $this->apiHost = config('services.bookingcom.host');
    }

    public function getDestinationId(string $cityName): ?string
    {
        $response = Http::withHeaders([
            'x-rapidapi-key'  => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost,
        ])->get("https://{$this->apiHost}/v1/hotels/locations", [
            'locale' => 'en-gb',
            'name'   => $cityName,
        ]);

        if ($response->failed()) {
            throw new \Exception('Error fetching destination ID: '.$response->body());
        }

        return $response->json()[0]['dest_id'] ?? null;
    }

    public function getHotels(
        string $destId,
        string $checkIn,
        string $checkOut,
        int    $adults  = 2,
        string $orderBy = 'price'
    ): array {
        $currency = session('currency', 'EUR');

        $params = [
            'dest_type'          => 'city',
            'dest_id'            => $destId,
            'checkin_date'       => $checkIn,
            'checkout_date'      => $checkOut,
            'adults_number'      => $adults,
            'locale'             => 'en-gb',
            'currency'           => $currency,        
            'filter_by_currency' => $currency,         
            'order_by'           => $orderBy,
            'units'              => 'metric',
            'include_adjacency'  => 'true',
            'room_number'        => '1',
        ];

        \Log::debug('BookingComService.getHotels → sending currency:', ['currency'=>$currency,'params'=>$params]);

        $response = Http::withHeaders([
            'x-rapidapi-key'  => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost,
        ])->get("https://{$this->apiHost}/v1/hotels/search", $params);

        \Log::debug('Booking.com /hotels/search response status='.$response->status());

        if ($response->failed()) {
            $body = $response->json();
            if (isset($body['detail']) && $body['detail'] === 'This dest_id was disabled') {
                return ['result' => []];
            }
            throw new \Exception('Error fetching hotels: '.$response->body());
        }

        $data = $response->json();

        foreach ($data['result'] as &$hotel) {
            if (isset($hotel['distance_to_destination'])) {
                $hotel['distance_from_center'] = $hotel['distance_to_destination'];
            }
        }

        return $data;
    }
}
