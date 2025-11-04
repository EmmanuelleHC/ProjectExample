<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            // Additional business fields
            $table->string('invoice_no')->unique()->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);

            // Payment and order tracking
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending'); // e.g., pending, paid, failed
            $table->string('order_status')->default('processing'); // e.g., processing, shipped, delivered
            $table->string('payment_reference')->nullable();

            // Optional shipping address
            $table->text('shipping_address')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transactions');
        Schema::enableForeignKeyConstraints();
    }
};
