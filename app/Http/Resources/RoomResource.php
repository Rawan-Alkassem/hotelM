<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'room_number' => $this->room_number,
            'room_type' => new RoomTypeResource($this->whenLoaded('roomType')),
            'status' => $this->status,
            'price' => $this->roomType?->price,// من room_type
            // 'images' => $this->images->pluck('image_path'),
        ];
    }
}
