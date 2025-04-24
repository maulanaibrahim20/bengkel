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
        Schema::create('components_cms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id'); // no FK constraint
            $table->string('type'); // e.g. hero, services, cta
            $table->unsignedInteger('order')->default(0);
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_cms');
    }
};
