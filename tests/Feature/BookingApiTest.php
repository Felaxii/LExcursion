<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    public function test_booking_api_returns_hotels()
    {
        Http::fake([
            'https://*.booking.com/*' => Http::response(['result' => [['hotel_name' => 'Test Hotel']]], 200)
        ]);

        $response = $this->get('/accommodations?city=Paris&checkInDate=2025-06-01&checkOutDate=2025-06-02&adults=2');

        $response->assertStatus(200);
        $response->assertViewHas('hotelsData');
    }
}
