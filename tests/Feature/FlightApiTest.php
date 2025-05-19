<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FlightApiTest extends TestCase
{
    public function test_amadeus_api_returns_flights()
    {
        Http::fake([
            'https://test.api.amadeus.com/*' => Http::response(['data' => [['id' => 1]]], 200)
        ]);

        $response = $this->get('/travel-options?city=Paris&travelers=1&date=2025-06-01');

        $response->assertStatus(200);
        $response->assertViewHas('flightData');
    }
}
