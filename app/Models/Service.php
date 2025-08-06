<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

  
    protected $fillable = ['name', 'description', 'image']; 

  


    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'room_type_services');
    }

     public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
    

}
