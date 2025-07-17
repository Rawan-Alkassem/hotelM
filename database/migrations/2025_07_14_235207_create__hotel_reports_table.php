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
        Schema::create('HotelReports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('Users')->onDelete('cascade');
            $table->enum('report_type', ['occupancy', 'revenue', 'popular_services']);
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HotelReports');
    }
};
