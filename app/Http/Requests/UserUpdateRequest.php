<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->user->id, 'id'),
                'email',
            ],
            'image' => ['nullable', 'image', 'max:1024'],
            'company_id' => ['required', 'exists:companies,id'],
            'roles' => 'array',
        ];
    }
}
