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
         Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('discount_id')->nullable()->constrained()->onDelete('set null');
            $table->string('status')->default('pending'); // Ej. pending, processing, ready, completed
            $table->decimal('total_price', 8, 2);
            $table->enum('delivery_option', ['pickup', 'delivery']);
            $table->string('delivery_address')->nullable();
            $table->time('pickup_time')->nullable();
            $table->string('tracking_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
