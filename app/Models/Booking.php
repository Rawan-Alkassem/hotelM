<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    protected $table = 'Bookings';


// OR using $casts (preferred in newer Laravel versions):
protected $casts = [
    'check_in_date' => 'date',
    'check_out_date' => 'date',
];
    protected $fillable = [
        'user_id',
        'room_id',
        'status',
        'check_in_date',
        'check_out_date',
        'total_price'
    ];
protected $dates = [
    'check_in_date',
    'check_out_date',
    'created_at',
    'updated_at'
];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receptionist()
    {
        return $this->belongsTo(User::class, 'receptionist_id');
    }
    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function reviews() {
        return $this->hasMany(BookingReview::class, 'booking_id');
    }

    public function checkInOutLogs() {
        return $this->hasMany(CheckInOutLog::class, 'booking_id');
    }
}
