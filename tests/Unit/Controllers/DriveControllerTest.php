<?php

namespace Tests\Unit\Controllers;

use App\Http\Resources\CarResource;
use App\Http\Resources\UserResource;
use App\Models\Car;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DriveControllerTest extends TestCase
{
    public function test_available_cars()
    {
        $response = $this->getJson('/api/available-cars');

        $response
            ->assertStatus(200)
//            ->assertExactJson([])
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'type',
                        'user',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
    }

    public function test_get_car_for_drive()
    {
        $response = $this->getJson('/api/drive/3/3');

        $response
            ->assertOk()
//            ->assertExactJson([])
            ->assertJsonStructure(
                [
                    'success',
                    'car' => [
                        'id',
                        'name',
                        'type',
                        'user',
                        'user_id',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
    }

    public function test_remove_drive()
    {
        $car = new CarResource(Car::findOrFail(3));
        $car->update(['user_id' => 5]);

        $response = $this->getJson('/api/remove-car/3');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'success'
            ]);
    }
}
