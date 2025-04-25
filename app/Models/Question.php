<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  schema="Question",
 *  @OA\Property(property="id", type="integer", example="1"),
 *  @OA\Property(property="uuid", type="string", example="YHZdF9ZffJF2mjf2"),
 *  @OA\Property(property="question", type="string", example="Quantité annuelle de CO₂ émise par l’entreprise (en tonnes)"),
 *  @OA\Property(property="level", type="string", example="free"),
 *  @OA\Property(property="order", type="integer", example="1"),
 *  @OA\Property(property="group", ref="#/components/schemas/QuestionGroup"),
 *  @OA\Property(property="sequence", type="string", example="Q1"),
 *  @OA\Property(
 *      property="answers",
 *      type="array",
 *      @OA\Items(ref="#/components/schemas/Answer")
 *  ),
 *  @OA\Property(property="created_at", type="string", format="date", example="2024-02-02"),
 *  @OA\Property(property="updated_at", type="string", format="date", example="2024-02-02")
 * )
 */

class Question extends Model
{
    protected $guarded = ['id'];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function group()
    {
        return $this->hasOne(QuestionGroup::class, 'id', 'group_id');
    }

}
