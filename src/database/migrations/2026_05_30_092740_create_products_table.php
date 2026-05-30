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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') ->constrained();
            $table->foreignId('category_id') ->nullable() ->constrained('categories') ->nullOnDelete();

            $table->string('name', 200);
            $table->string('description') ->nullable();
            $table->decimal('price', 18, 2);
            $table->enum('status', [ 'menunggu_verifikasi', 'dijual', 'sold_out', 'ditolak' ])->default('menunggu_verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
