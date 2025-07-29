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
            Schema::create('Bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('Users')->onDelete('cascade');
                $table->foreignId('receptionist_id')->constrained('Users')->onDelete('cascade');
                $table->foreignId('room_id')->constrained('Rooms')->onDelete('cascade');
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'finished'])->default('pending');
                $table->date('check_in_date');
                $table->date('check_out_date');
                    $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Bookings');
    }
};
