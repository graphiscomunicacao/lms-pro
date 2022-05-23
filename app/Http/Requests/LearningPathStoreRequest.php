<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningPathStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'start_time' => ['nullable', 'date'],
            'end_time' => ['nullable', 'date'],
            'availability_time' => ['nullable', 'numeric'],
            'cover_path' => ['image', 'max:1024'],
            'tries' => ['required', 'numeric'],
            'passing_score' => ['required', 'numeric'],
            'approval_goal' => ['nullable', 'numeric'],
            'certificate_id' => ['required', 'exists:certificates,id'],
        ];
    }
}
