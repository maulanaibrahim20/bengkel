<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code');
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('booking_slot_id')->constrained('booking_slots')->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'registered'])->default('pending');
            $table->text('complaint')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
