<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'answer_uuid' => 'required|string|exists:answers,uuid',
            'files.*' => 'required|mimes:pdf',
        ];
    }

//    public function messages()
//    {
//        return [
//            'answer_uuid.regex' => 'The entered data contains invalid characters․(Allowed characters .  and – ).',
//        ];
//    }

}
