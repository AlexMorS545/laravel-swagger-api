<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PHPUnit\Util\Json;

class CarController extends Controller
{
    /**
     *
     * @OA\Get(
     *     path="/cars",
     *     operationId="carsAll",
     *     tags={"Cars"},
     *     summary="Get cars with pagination",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *     ),
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CarResource::collection(Car::paginate(5));
    }

    /**
     *
     * @OA\Post(
     *     path="/cars",
     *     operationId="carCreate",
     *     tags={"Cars"},
     *     summary="Create new car",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Response(
     *         response="200",
     *         description="Car create succes",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Wrong credentials response"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCarRequest $request): JsonResponse
    {
        $item = new Car();
        $item->fill($request->all());
        $item->save();
        return response()->json(['success' => 'Create car success', 'item' => $item], 201);
    }

    /**
     * @OA\Get(
     *     path="/cars/{id}",
     *     operationId="carGet",
     *     tags={"Cars"},
     *     summary="Get car by ID",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of car",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     ),
     * )
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\CarResource
     */
    public function show($id): CarResource
    {
        return new CarResource(Car::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/cars/{id}",
     *     operationId="carUpdate",
     *     tags={"Cars"},
     *     summary="Update car by id",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of car",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Car update succes",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car not found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCarRequest $request, $id): JsonResponse
    {
        $item = new CarResource(Car::findOrFail($id));
        $item->update($request->all());

        return response()->json(['success' => 'Car update success', 'item' => $item], 200);
    }

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     operationId="carDelete",
     *     tags={"Cars"},
     *     summary="Delete car by id",
     *     security={
     *       {"api_key": {}},
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of car",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="202",
     *         description="Deleted",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Car not found",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     * )
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $item = new CarResource(Car::findOrFail($id));
        $item->delete();

        return response()->json(['success' => 'Car delete success'], 202);
    }

}
