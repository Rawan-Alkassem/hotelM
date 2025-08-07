<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Room extends Model
{
    use HasFactory;

    protected $table = 'Rooms';

    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
    ];


      public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

// public function images()
//     {
//         return $this->hasMany(related: RoomImage::class);
//     }



    public function roomType() {
//   return $this->belongsTo(RoomType::class);
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'room_id');
    }
 public function services()
{
    return $this->belongsToMany(Service::class, 'room_service');
}


    public function images()
{
    return $this->hasMany(RoomImage::class);
}
}


