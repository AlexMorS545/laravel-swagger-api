<?php

namespace App\Http\Controllers\API;

use App\Actions\GetAvailableCars;
use App\Actions\GetCarForDriveAction;
use App\Actions\RemoveDriverFromCar;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
    public function availableCars(GetAvailableCars $getAvailableCars): JsonResponse
    {
        return response()->json($getAvailableCars());
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
    public function driveCar(GetCarForDriveAction $getCarForDriveAction, int $user_id, int $car_id): JsonResponse
    {
        return response()->json($getCarForDriveAction($user_id, $car_id));
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
    public function removeCar(RemoveDriverFromCar $removeDriverFromCar, int $car_id): JsonResponse
    {
        return response()->json($removeDriverFromCar($car_id));
    }
}
