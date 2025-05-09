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
        Schema::create('motor_cycle_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('motorcycle_id')->constrained('motorcycles')->onDelete('cascade');
            $table->integer('year_of_manufacture')->nullable();
            $table->integer('kilometer_before')->nullable();
            $table->string('oil_before')->nullable();
            $table->integer('kilometer_after')->nullable();
            $table->string('oil_after')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor_cycle_details');
    }
};
