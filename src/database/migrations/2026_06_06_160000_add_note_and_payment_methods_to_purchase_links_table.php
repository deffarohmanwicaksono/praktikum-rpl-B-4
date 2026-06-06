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
        Schema::table('purchase_links', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->json('payment_methods')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_links', function (Blueprint $table) {
            $table->dropColumn(['note', 'payment_methods']);
        });
    }
};
