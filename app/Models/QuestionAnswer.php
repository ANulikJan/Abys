<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{

    protected $fillable = [
        'answer_id',
        'question_id',
        'user_id',
        'file'
    ];
}
