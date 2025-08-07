<?php

namespace App\Models;
use App\Models\CheckInOutLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
 protected static function booted()
    {
        static::created(function ($booking) {
            // إنشاء سجل الدخول والخروج تلقائيًا عند إنشاء الحجز
            CheckInOutLog::create([
                'booking_id' => $booking->id,
                'receptionist_id' => $booking->receptionist_id,
                'check_in_time' => null,
                'check_out_time' => null
            ]);
        });
    }
    protected $table = 'Bookings';

    protected $attributes = [
    'receptionist_id' => null, // أو أي قيمة افتراضية مناسبة
];

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
        ,'receptionist_id'
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
public function checkInOutLog()
{
    return $this->hasOne(CheckInOutLog::class);
}
}
