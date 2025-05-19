<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_blog_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/blog', [
            'title' => 'Test Title',
            'content' => 'Test content body for blog.',
        ]);

        $response->assertRedirect('/blog');
        $this->assertDatabaseHas('blog_posts', ['title' => 'Test Title']);
    }

    public function test_guest_cannot_create_blog_post()
    {
        $response = $this->post('/blog', [
            'title' => 'Guest Try',
            'content' => 'This should fail',
        ]);

        $response->assertRedirect('/login');
    }
}
