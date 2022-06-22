<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemStoreRequest extends FormRequest
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
            'menu_id' => ['required', 'exists:menus,id'],
            'item_type' => ['required', 'max:255', 'string'],
            'item_id' => ['required', 'numeric'],
            'order' => ['required', 'numeric'],
        ];
    }
}
