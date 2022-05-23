<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningArtifactUpdateRequest extends FormRequest
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
            'type' => [
                'required',
                'in:audio,document,interactive,image,video,externo',
            ],
            'path' => ['file', 'max:1024'],
            'size' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            'external' => ['required', 'boolean'],
            'url' => ['nullable', 'url'],
            'cover_path' => ['nullable', 'max:255', 'string'],
        ];
    }
}
