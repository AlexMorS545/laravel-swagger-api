<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @OA\Schema(
 * required={"password"},
 * @OA\Xml(name="Car"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", readOnly="true", description="User id for driving car"),
 * @OA\Property(property="name", type="string", readOnly="true", description="Car name", example="UAZ"),
 * @OA\Property(property="type", type="string", readOnly="true", description="Car type", example="crossover"),
 * @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 * @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 * @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 *
 * Class Car
 *
 */

class Car extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'cars';

    protected $fillable = [
        'user_id',
        'name',
        'type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
