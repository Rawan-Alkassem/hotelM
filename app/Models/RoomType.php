<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{

    protected $fillable = ['name', 'description','max_rooms','cost_per_night'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_type_services');
    }
}

