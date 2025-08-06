<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'booking_id' => $this->booking_id,
    //         'user' => new UserResource($this->whenLoaded('user')),
    //         'rating' => $this->rating,
    //         'comment' => $this->comment,
    //         'created_at' => $this->created_at->toDateTimeString(),
    //     ];
    // }



    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }


}
