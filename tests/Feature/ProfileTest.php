<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('profile.index'));

        $response->assertStatus(200);
        $response->assertSee($user->email);
    }

    public function test_user_can_update_profile_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('profile.update'), [
            'nickname'    => 'NewNick',
            'full_name'   => 'Test Name',
            'address'     => 'Street 1',
            'occupation'  => 'Student',
            'description' => 'Nice guy',
        ]);

        $response->assertRedirect(route('profile.index'));
        $this->assertDatabaseHas('users', ['nickname' => 'NewNick']);
    }
}
