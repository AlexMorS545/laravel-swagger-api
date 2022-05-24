<?php

namespace App\Actions;

use App\Http\Resources\CarResource;
use App\Models\Car;

class GetCarForDriveAction
{
    public function __invoke(int $user_id, int $car_id): array
    {
        $car = new CarResource(Car::findOrFail($car_id));

        if ($car_have_driver = Car::where('user_id', $user_id)->first()) {
            return ['success' => 'You have a car', 'car' => $car_have_driver];
        }

        if (!empty($car->user)) {

            if ($car->user->id === $user_id) {
                return ['success' => 'It is your car', 'car' => $car];
            }
            return ['error' => 'This car is not free'];
        }

        $car->update([
            'user_id' => $user_id,
        ]);

        return ['success' => 'You take car successfully!', 'car' => new CarResource(Car::findOrFail($car->id)->load('user'))];
    }
}
