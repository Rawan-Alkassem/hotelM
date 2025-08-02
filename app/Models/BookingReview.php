<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingReview extends Model {

    protected $table = 'BookingReviews';

    protected $fillable = [
        'booking_id',
        'rating',
        'comment',
    ];

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}

