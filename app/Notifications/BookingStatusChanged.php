<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusChanged extends Notification
{
    use Queueable;

    public Booking $booking;

    /**
     * إنشاء إشعار جديد.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * القنوات التي سيتم إرسال الإشعار من خلالها.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * شكل الإيميل المرسل.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusAr = [
            'pending' => ' pending ',
            'confirmed' => ' confirmed ',
            'cancelled' => 'cancelled',
            'finished' => 'finished',
        ];

        return (new MailMessage)
            ->subject('🛎️ Your Booking Status')
            ->greeting('Hello ' . $notifiable->name . ' 👋')
            ->line('Your booking status is : **' . ($statusAr[$this->booking->status] ?? $this->booking->status) . '**')

            ->line('🛏️ Check-in Date:' . $this->booking->check_in_date)
            ->line('🏁 Check-out Date: ' . $this->booking->check_out_date)
            ->line('💰  Total Amount: ' . number_format($this->booking->total_price, 2) . ' USD ')
            ->line('')
            ->line(' Thanks ! 🌟');
    }

    /**
     * تمثيل الإشعار كمصفوفة (اختياري).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
        ];
    }
}
