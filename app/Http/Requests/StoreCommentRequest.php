<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author_name' => 'required|string|max:50',
            'body' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'author_name.required' => 'Author name is required',
            'body.required' => 'Comment body is required',
        ];
    }
}