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
        Schema::create('product_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique() ->constrained('products') ->cascadeOnDelete();
            $table->foreignId('admin_id') ->constrained('users');

            $table->enum('status', [ 'disetujui', 'ditolak',]);
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_verifications');
    }
};
