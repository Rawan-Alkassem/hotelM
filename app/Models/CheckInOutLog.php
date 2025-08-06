<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOutLog extends Model {

    protected $table = 'CheckInOutLogs';

    protected $fillable = [
        'booking_id',
        'receptionist_id',
        'check_in_time',
        'check_out_time',
    ];

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function receptionist() {
        return $this->belongsTo(User::class, 'receptionist_id');
    }
}
