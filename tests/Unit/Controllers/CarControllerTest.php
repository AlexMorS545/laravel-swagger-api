<?php

namespace Tests\Unit\Controllers;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    public function test_get_cars_json()
    {
        $response = $this->getJson('/api/cars');

        $response
            ->assertStatus(200)
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
        $response = $this->getJson('/api/cars/3');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('data')
                ->first(fn ($json) =>
                $json->where('id', 3)
                    ->etc()
                )
            );
    }

    public function test_create_car_json()
    {
        $response = $this->postJson('/api/cars', ['name' => 'Moskvich', 'type' => 'sedan']);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'item' => [
                    'name',
                    'type',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    public function test_update_car_json()
    {
        $response = $this->putJson('/api/cars/2', ['name' => 'BMW', 'type' => 'sedan']);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'item' => [
                    'id',
                    'user_id',
                    'name',
                    'type',
                    'user',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
