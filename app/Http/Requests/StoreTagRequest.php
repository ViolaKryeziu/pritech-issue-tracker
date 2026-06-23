<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // IMPORTANT: përndryshe bllokon request-in
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:tags,name',
            'color' => 'nullable|string|max:50',
        ];
    }
}