<?php

namespace App\Http\Services;

use App\Http\Repositories\QuestionRepository;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function getUserAnswers()
    {
        return $this->questionRepository->getUserAnswers();
    }

    public function getUserAnswersOnQuestion($uuid)
    {
        return $this->questionRepository->getUserAnswersOnQuestion($uuid);
    }

    public function answerQuestion($data)
    {
        $docs = [];
        $user = Auth::user();
        if (!empty($data['files'])) {
            $path = 'uploads/tmp/';
            foreach ($data['files'] as $file) {
                if (is_string($file) && (strpos($file, $path) !== false)) {
                    $docs[] = $file;
                } else {
                    $fileName = Str::random(10) . '_' . $file->getClientOriginalName();
                    $filePath = $path . str_replace(' ', '_', $fileName);
                    $fileData = Storage::disk('public')->put($filePath, file_get_contents($file));
                    if ($fileData) {
                        $docs[] = env('APP_URL') . 'storage/' . $filePath;
                    }
                }
            }
        }

        $requestData = [
            'question_uuid' => $data['question_uuid'],
            'answer_uuid' => $data['answer_uuid'],
            'user_id' => $user->id,
        ];

        if (!empty($docs)) {
            $requestData['files'] = json_encode($docs);
        }

        return $this->questionRepository->saveData($requestData);
    }


}
