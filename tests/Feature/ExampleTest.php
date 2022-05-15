<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_cars_json()
    {
        $response = $this->getJson('/api/cars');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'data' => true,
            ])
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'type',
                            'user_id',
                            'user',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            );
    }

    public function test_get_one_car_json()
    {
        $response = $this->getJson('/api/cars/1');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->where('id', 1)->etc()
            );
    }

    public function test_create_car_json()
    {
        $response = $this->postJson('/api/cars', ['name' => 'Moskvich', 'type' => 'sedan']);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'item' => true,
            ]);
    }
}
