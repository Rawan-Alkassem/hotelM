<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// class BookingResource extends JsonResource
// {
//     public function toArray(Request $request): array
//     {
//         return [
//             'id' => $this->id,
//             'user' => new UserResource($this->whenLoaded('user')),
//             'room' => new RoomResource($this->whenLoaded('room')),
//             'check_in_date' => $this->start_date,
//             'check_out_date' => $this->end_date,
//             'status' => $this->status,
//             'total_price' => $this->total_price,
//             'services' => ServiceResource::collection($this->whenLoaded('services')),
//         ];
//     }
// }
class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'room' => new RoomResource($this->whenLoaded('room')),
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
