<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  schema="QuestionGroup",
 *  @OA\Property( property="id",type="integer",example="1" ),
 *  @OA\Property( property="title",type="string",example="Environnement" ),
 *  @OA\Property( property="level",type="string",example="free" ),
 *  @OA\Property( property="order",type="integer",example="1" ),
 *  @OA\Property( property="created_at",type="date",example="2024-02-02" ),
 *  @OA\Property( property="updated_at",type="date",example="2024-02-02" ),
 * )
 */
class QuestionGroup extends Model
{
    protected $guarded = ['id'];

}
