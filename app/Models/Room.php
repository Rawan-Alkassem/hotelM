<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model {

    protected $table = 'Rooms';

    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
    ];

    public function roomType() {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'room_id');
    }
}

