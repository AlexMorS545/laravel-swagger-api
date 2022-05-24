<?php

namespace App\Actions;

use App\Http\Resources\CarResource;
use App\Models\Car;

class RemoveDriverFromCar
{
    public function __invoke(int $car_id): array
    {
        $car = new CarResource(Car::findOrFail($car_id));

        if (empty($car->user_id))
            return ['error' => 'This car does not have driver', 'car' => $car];

        $car->update([
            'user_id' => null,
        ]);

        return ['success' => 'Driver remove successfully!'];
    }
}
