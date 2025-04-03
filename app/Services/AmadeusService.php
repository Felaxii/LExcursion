<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AmadeusService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId     = config('services.amadeus.client_id');
        $this->clientSecret = config('services.amadeus.client_secret');
        $this->baseUrl      = config('services.amadeus.base_url', 'https://test.api.amadeus.com');
    }

    /**
     * Retrieve an access token from Amadeus.
     */
    public function getAccessToken()
    {
        $response = Http::asForm()
            ->post($this->baseUrl . '/v1/security/oauth2/token', [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

        if ($response->failed()) {
            throw new \Exception('Error fetching Amadeus access token: ' . $response->body());
        }

        $data = $response->json();
        return $data['access_token'] ?? null;
    }

    /**
     * Get a static list of hotels in a given city using the Hotel List API (v1).
     *
     * Required parameters:
     * - cityCode (e.g. "LON" for London)
     * - subType (one of "ALL", "HOTEL_GDS", "HOTEL_LEISURE")
     * - view (set to "FULL" to return full details)
     * - Pagination parameters
     *
     * @param string $cityCode
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getHotelsByCity($cityCode)
    {
        $token = $this->getAccessToken();
    
        $query = "cityCode={$cityCode}&subType=HOTEL_GDS&view=BASIC";
        $url = $this->baseUrl . '/v1/reference-data/locations/hotels/by-city?' . $query;
    
        $response = Http::withToken($token)->get($url);
    
        if ($response->failed()) {
            throw new \Exception('Error fetching hotel list: ' . $response->body());
        }
    
        \Log::info('Hotel list response: ' . $response->body());
        return $response->json();
    }
    
    /**
     * Get real‑time hotel offers using the Hotel Offers API v3.
     *
     * This method requires a comma‑separated list of hotel IDs.
     *
     * @param array $hotelIds
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param int $adults
     * @return array
     */
    
    public function getFlightOffers($origin, $destination, $departureDate, $returnDate = null, $adults = 1)
    {
        $token = $this->getAccessToken();

        $params = [
            'originLocationCode'      => $origin,
            'destinationLocationCode' => $destination,
            'departureDate'           => $departureDate,
            'adults'                  => $adults,
        ];

        if ($returnDate) {
            $params['returnDate'] = $returnDate;
        }

        $url = $this->baseUrl . '/v2/shopping/flight-offers';

        $response = Http::withToken($token)->get($url, $params);

        if ($response->failed()) {
            throw new \Exception('Error fetching flight offers: ' . $response->body());
        }

        \Log::info('Flight offers response: ' . $response->body());
        return $response->json();
    }

    /**
     * Map city names to their IATA city codes.
     *
     * @param string $city
     * @return string
     */
    public function mapCityToHotelCode($city)
    {
        $mapping = [
            'Riga'         => 'RIX',
            'Tallinn'      => 'TLL',
            'Rome'         => 'ROM',
            'Munich'       => 'MUC',
            'Nuremberg'    => 'NUE',
            'Paris'        => 'PAR',
            'Barcelona'    => 'BCN',
            'Madrid'       => 'MAD',
            'Oslo'         => 'OSL',
            'Stockholm'    => 'STO',
            'Copenhagen'   => 'CPH',
            'Bucharest'    => 'OTP',
            'Milan'        => 'MIL',
            'Nice'         => 'NCE',
            'London'       => 'LON',
            'Dublin'       => 'DUB',
            'Athens'       => 'ATH',
            'Praha'        => 'PRG',
            'Warsaw'       => 'WAW',
            'Helsinki'     => 'HEL',
            'Zagreb'       => 'ZAG',
            'Vienna'       => 'VIE',
            'Istanbul'     => 'IST',
            'Sofia'        => 'SOF',
            'Budapest'     => 'BUD',
            'Bratislava'   => 'BTS',
            'Timisoara'    => 'TSR',
            'Cluj'         => 'CLJ',
            'Hamburg'      => 'HAM',
            'Berlin'       => 'BER',
            'Krakow'       => 'KRK',
            'Lisbon'       => 'LIS',
            'Amsterdam'    => 'AMS',
            'Brussels'     => 'BRU',
            'Varna'        => 'VAR',
            'Edinburgh'    => 'EDI',
            'Palermo'      => 'PMO',
            'Reykjavík'    => 'REK',
            'Malta'        => 'MLA',
            'Thessaloniki' => 'SKG'
        ];

        return $mapping[$city] ?? 'LON';
    }
}
