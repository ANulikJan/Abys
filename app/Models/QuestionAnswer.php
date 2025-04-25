<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{

    protected $fillable = [
        'answer_uuid',
        'question_uuid',
        'user_id',
        'files'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_uuid', 'uuid');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_uuid', 'uuid');
    }
}
