<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
      
        $response = $this->post('/api/login', [
            'email' => 'user@example.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }


    public function test_logout()
    {
        // First, log in to get the token
    $loginResponse = $this->post('/api/login', [
        'email' => 'user@example.com',
        'password' => '123456',
    ]);
    
    $token = $loginResponse->json('token');

    // Ensure token is available
    $this->assertNotNull($token);

    // Now log out
    $response = $this->withHeaders(['Authorization' => "Bearer $token"])
                     ->post('/api/logout');

    // Ensure the response is correct
    $response->assertStatus(200)
             ->assertJson(['status' => 'success', 'message' => 'Logged out']);
    }
}
