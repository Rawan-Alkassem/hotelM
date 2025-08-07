<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up(): void {
        Schema::create('CheckInOutLogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('Bookings')->onDelete('cascade');
            $table->foreignId('receptionist_id')->nullable()->constrained('Users')->onDelete('cascade');
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CheckInOutLogs');
    }
};
