<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CurrencyApiTest extends TestCase
{
    public function test_currency_conversion_is_applied()
    {
        Http::fake([
            'https://api.exchangerate.host/*' => Http::response(['rates' => ['USD' => 1.1]], 200)
        ]);

        session(['currency' => 'USD']);

        $response = $this->get('/accommodations?city=Paris&checkInDate=2025-06-01&checkOutDate=2025-06-02&adults=2');

        $response->assertStatus(200);
        $response->assertViewHas('hotelsData');
    }
}
