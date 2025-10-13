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
        Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['time_unit', 'package'])->default('time_unit');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->string('unit')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['number', 'select', 'checkbox'])->default('number');
            $table->string('default_value')->nullable();
            $table->decimal('default_price', 10, 2)->default(0);
            $table->json('values')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('products');
    }
};
