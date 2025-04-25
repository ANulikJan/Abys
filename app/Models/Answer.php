<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  schema="Answer",
 *  @OA\Property( property="id",type="integer",example="1" ),
 *  @OA\Property( property="uuid",type="string",example="YHZdF9ZffJF2mjf2" ),
 *  @OA\Property( property="answer",type="string",example="Moins de 100 tonnes (5 points)" ),
 *  @OA\Property( property="score",type="integer",example="5" ),
 *  @OA\Property( property="order",type="integer",example="1" ),
 *  @OA\Property( property="sequence",type="string",example="A" ),
 * ),
 *  @OA\Property( property="created_at",type="date",example="2024-02-02" ),
 *  @OA\Property( property="updated_at",type="date",example="2024-02-02" ),
 * )
 */
class Answer extends Model
{
    protected $guarded = ['id'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_answers');
    }
}
