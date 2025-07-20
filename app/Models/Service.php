<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = ['name', 'description'];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_service');
    }
     public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
