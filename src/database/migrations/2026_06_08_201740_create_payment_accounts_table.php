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
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ->constrained() ->cascadeOnDelete();

            $table->enum('payment_method', [
                'BCA',
                'BRI',
                'BNI',
                'Mandiri',
                'Dana',
                'ShopeePay'
            ]);

            $table->string('account_number', 30);
            $table->string('account_name', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_accounts');
    }
};
