<?php

namespace App\Http\Repositories;

use App\Models\QuestionAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionRepository
{

    public function saveData($data){
        return QuestionAnswer::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'question_uuid' => $data['question_uuid'],
            ],
            $data
        );
    }

    public function getUserAnswersOnQuestion($uuid)
    {
        return QuestionAnswer::with(['question', 'answer'])
            ->where(['user_id' => Auth::id(), 'question_uuid' => $uuid])
            ->get()
            ->groupBy(fn($item) => $item->question_uuid);
    }

    public function getUserAnswers()
    {
        return QuestionAnswer::with(['question', 'answer'])
            ->where('user_id', Auth::id())
            ->get()
            ->groupBy(fn($item) => $item->question_uuid);
    }
}
