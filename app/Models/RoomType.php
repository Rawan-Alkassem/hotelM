<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class RoomType extends Model
{
    use HasFactory;
//change name of cost_per_night to price
    protected $fillable = ['name', 'description', 'price'];


//     protected $fillable = ['name', 'description','max_rooms','cost_per_night'];


    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'room_type_services', 'room_type_id', 'service_id');
    }
}

