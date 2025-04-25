<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupedUserAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $first = $this->first();

        return [
            'question' => $first->question->question,
            'answers' => $this->map(function ($qa) {
                return [
                    'answer' => $qa->answer->answer,
                    'answer_uuid' => $qa->answer_uuid,
                    'score' => $qa->answer->score,
                    'files' => !empty($qa->files) ? json_decode($qa->files, true) : []
                ];
            })
        ];
    }
}
