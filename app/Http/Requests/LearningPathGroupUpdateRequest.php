<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningPathGroupUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cover_path' => ['required', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
            'availability_time' => ['nullable', 'numeric'],
            'tries' => ['required', 'numeric'],
            'approval_goal' => ['required', 'numeric'],
            'passing_score' => ['required', 'numeric'],
        ];
    }
}
