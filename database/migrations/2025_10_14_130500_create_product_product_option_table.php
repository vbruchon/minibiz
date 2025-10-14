<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_product_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_option_id')->constrained()->onDelete('cascade');

            $table->string('default_value')->nullable();
            $table->decimal('default_price', 10, 2)->default(0);
            $table->boolean('is_default_attached')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_product_option');
    }
};
