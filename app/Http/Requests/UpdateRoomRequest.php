<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules()
    {
        $roomId = $this->route('room')->id;

        return [
            'room_number'   => 'required|unique:rooms,room_number,' . $roomId,
            'room_type_id'  => 'required|exists:room_types,id',
            'status'        => 'required|in:available,booked,maintenance',
        ];
    }
}
