<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_location()
    {
        $user = User::factory()->create();

        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'list' => [
                    [
                        'dt_txt' => '2023-10-01 12:00:00',
                        'main' => [
                            'temp_min' => 15,
                            'temp_max' => 20,
                        ],
                        'weather' => [
                            [
                                'main' => 'Clouds',
                                'icon' => '04d',
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson('/api/locations', [
            'city' => 'New York',
            'state' => 'NY',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('locations', [
            'city' => 'New York',
            'state' => 'NY',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('forecasts', [
            'condition' => 'Clouds',
            'icon' => '04d',
        ]);
    }

    public function test_user_cannot_add_more_than_three_locations()
    {
        $user = User::factory()->create();
        Location::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/locations', [
            'city' => 'Chicago',
            'state' => 'IL',
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'You can only register up to 3 locations.']);
    }
}
