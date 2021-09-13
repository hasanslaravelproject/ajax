<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
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
           /*  'menu_starts' => ['nullable', 'date'], */
            'validity' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:1024'],
            'menu_types_id' => ['required', 'exists:menu_types,id'],
            'meal_type_id' => ['required', 'exists:meal_types,id'],
            'food_id' => ['required', 'exists:foods,id'],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }
}
