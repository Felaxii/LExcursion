<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiTripTest extends TestCase
{
    use RefreshDatabase;

    public function test_ai_trip_generation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Http::fake([
            'https://api.openai.com/*' => Http::response([
                'choices' => [[
                    'message' => ['content' => '[{"name":"Rome","country":"Italy","description":"Sunny and historical","reason":"Great for exploration"}]']
                ]]
            ], 200)
        ]);

        $response = $this->post('/trip-generator', [
            'type'        => 'exploration',            
            'price_level' => 'low',                  
            'geography'   => ['beach', 'city'],        
            'interests'   => ['food', 'events'],       
            'extra'       => 'none'                    
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('cities');
        $response->assertViewHas('filters');
    }
}
