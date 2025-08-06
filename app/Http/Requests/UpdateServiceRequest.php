<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // اسمح للجميع باستخدامه
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'room_types' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'room_types.*' => 'exists:room_types,id',
        ];
    }
}
