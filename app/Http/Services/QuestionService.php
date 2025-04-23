<?php

namespace App\Http\Services;

use App\Http\Repositories\QuestionRepository;
use App\Models\Question;

class QuestionService
{

    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function questionList()
    {
        return Question::with(['answers', 'group'])->get();
    }


}
