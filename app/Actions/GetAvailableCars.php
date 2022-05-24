<?php

namespace App\Actions;

use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetAvailableCars
{
    public function __invoke(): array|AnonymousResourceCollection
    {
        $cars = CarResource::collection(Car::whereNull('user_id')->paginate(5));

        if (!$cars)
            return ['error' => 'Free cars not found'];

        return $cars;
    }
}
