<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Http\Resources\UserResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    /**
     * @OA\Get(
     *     path="/available-cars",
     *     operationId="freeCars",
     *     tags={"Drives"},
     *     summary="Free cars for driving",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Response(
     *         response="200",
     *         description="We have free cars",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Free cars not found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableCars(): JsonResponse
    {
        $cars = CarResource::collection(Car::whereNull('user_id')->paginate(5));

        if (!$cars)
            return response()->json(['error' => 'Free cars not found']);

        return response()->json($cars);
    }

    /**
     *
     * @OA\Get(
     *     path="/drive/{user_id}/{car_id}",
     *     operationId="driveCar",
     *     tags={"Drives"},
     *     summary="Get free car for driving",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="The user id for driving car",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="car_id",
     *         in="path",
     *         description="The car id for user",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Car create succes",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car not found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function driveCar(int $user_id, int $car_id): JsonResponse
    {
        $car = new CarResource(Car::findOrFail($car_id));

        if ($car_have_driver = Car::where('user_id', $user_id)->first()) {
            return response()->json(['success' => 'You have a car', 'car' => $car_have_driver]);
        }

        if (!empty($car->user)) {

            if ($car->user->id === $user_id) {
                return response()->json(['success' => 'It is your car', 'car' => $car]);
            }
            return response()->json(['error' => 'This car is not free'], 404);
        }

        $car->update([
            'user_id' => $user_id,
        ]);

        return response()->json(['success' => 'You give car for drive', 'car' => $car]);
    }

    /**
     *
     * @OA\Get(
     *     path="/remove-car/{car_id}",
     *     operationId="removeCar",
     *     tags={"Drives"},
     *     summary="Remove user of car",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="car_id",
     *         in="path",
     *         description="The car id with user driver",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Remove car of driver success",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car not found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCar($car_id): JsonResponse
    {
        $car = new CarResource(Car::findOrFail($car_id));

        if (empty($car->user))
            return response()->json(['error' => 'This car does not have driver', 'car' => $car], 404);

        $car->update([
            'user_id' => null,
        ]);
        return response()->json(['success' => 'Driver remove']);
    }
}
