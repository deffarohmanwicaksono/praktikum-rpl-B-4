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
            $table->foreignId('product_id')-> constrained('products');
            $table->foreignId('buyer_id')-> constrained('users');
            $table->foreignId('purchase_link_id')->constrained('purchase_links')->cascadeOnDelete();
            
            $table->string('transaction_code')->unique()->nullable();;
            $table->integer('quantity')-> default(1);
            $table->decimal('total_price', 18, 2);
            $table->enum('status', ['menunggu_pembayaran', 'dibayar', 'selesai', 'gagal'])->default('menunggu_pembayaran');
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
