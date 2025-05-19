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

    public function getAccessToken()
    {
        $response = Http::asForm()->post("{$this->baseUrl}/v1/security/oauth2/token", [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->failed()) {
            throw new \Exception('Error fetching Amadeus access token: '.$response->body());
        }

        return $response->json('access_token');
    }

    public function getFlightOffers(
        string $origin,
        string $destination,
        string $departureDate,
        ?string $returnDate = null,
        int $adults = 1
    ): array {
        $token    = $this->getAccessToken();
        $currency = session('currency', 'EUR');

        $params = [
            'originLocationCode'      => $origin,
            'destinationLocationCode' => $destination,
            'departureDate'           => $departureDate,
            'adults'                  => $adults,
            'currencyCode'            => $currency,
        ];

        if ($returnDate) {
            $params['returnDate'] = $returnDate;
        }

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/v2/shopping/flight-offers", $params);

        if ($response->failed()) {
            throw new \Exception('Error fetching flight offers: '.$response->body());
        }

        return $response->json();
    }

    public function getHotelsByCity(string $cityCode): array
    {
        $token = $this->getAccessToken();
        $url   = "{$this->baseUrl}/v1/reference-data/locations/hotels/by-city?cityCode={$cityCode}&subType=HOTEL_GDS&view=BASIC";

        $response = Http::withToken($token)->get($url);

        if ($response->failed()) {
            throw new \Exception('Error fetching hotel list: '.$response->body());
        }

        return $response->json();
    }

    public function mapCityToHotelCode(string $city): string
    {
        $mapping = [
            'Rome'=>'ROM', 'Munich'=>'MUC', 'Paris'=>'PAR', /* ...etc... */
        ];

        return $mapping[$city] ?? 'LON';
    }
}
