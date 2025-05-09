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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pelanggan
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // user yang membuat transaksi (admin/superadmin)
            $table->decimal('total_service_price', 10, 2)->default(0);
            $table->decimal('total_product_price', 10, 2)->default(0);
            $table->decimal('total_payment', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'transfer', 'gateway'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
