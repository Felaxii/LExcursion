<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookingComService
{
    protected $apiKey;
    protected $apiHost;

    public function __construct()
    {
        // Set these in your .env and config/services.php
        $this->apiKey  = config('services.bookingcom.key');
        $this->apiHost = config('services.bookingcom.host'); // e.g., "booking-com.p.rapidapi.com"
    }

    /**
     * Get destination ID for a city using the Booking.com locations endpoint.
     *
     * @param string $cityName
     * @return string|null
     */
    public function getDestinationId(string $cityName)
    {
        $url = "https://{$this->apiHost}/v1/hotels/locations";
        $params = [
            'locale' => 'en-gb',
            'name'   => $cityName,
        ];

        $response = Http::withHeaders([
            'x-rapidapi-key'  => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost,
        ])->get($url, $params);

        if ($response->failed()) {
            throw new \Exception('Error fetching destination ID: ' . $response->body());
        }

        $data = $response->json();
        \Log::info('Destination search response for ' . $cityName . ': ' . json_encode($data));

        if (is_array($data) && count($data) > 0 && isset($data[0]['dest_id'])) {
            return $data[0]['dest_id'];
        }
        return null;
    }

    /**
     * Get hotels for a given destination using the Booking.com hotels search endpoint.
     *
     * If the API indicates that the dest_id is disabled, we return an empty array instead of throwing an exception.
     *
     * @param string $destId
     * @param string $checkIn Date in YYYY-MM-DD format.
     * @param string $checkOut Date in YYYY-MM-DD format.
     * @param int $adultsNumber
     * @param string $order_by
     * @return array
     */
    public function getHotels(string $destId, string $checkIn, string $checkOut, int $adultsNumber = 2, string $order_by = 'price')
    {
        $url = "https://{$this->apiHost}/v1/hotels/search";

        $params = [
            'dest_type'          => 'city',
            'dest_id'            => $destId,
            'checkin_date'       => $checkIn,
            'checkout_date'      => $checkOut,
            'adults_number'      => $adultsNumber,
            'locale'             => 'en-gb',
            'currency'           => 'EUR',  
            'filter_by_currency' => 'EUR',  
            'order_by'           => $order_by,
            'units'              => 'metric',
            'room_number'        => '1',
        ];

        $response = Http::withHeaders([
            'x-rapidapi-key'  => $this->apiKey,
            'x-rapidapi-host' => $this->apiHost,
        ])->get($url, $params);

        if ($response->failed()) {
            $json = $response->json();
            if (isset($json['detail']) && $json['detail'] === 'This dest_id was disabled') {
                \Log::warning("Disabled destination id {$destId} encountered.");
                return []; // Return an empty result to allow graceful handling
            }
            throw new \Exception('Error fetching hotels: ' . $response->body());
        }

        \Log::info('Hotels response: ' . $response->body());
        return $response->json();
    }
}
