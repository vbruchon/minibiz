<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('country')->default('France')->nullable(false)->change();
            $table->string('siret', 14)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('country')->nullable()->default(null)->change();
            $table->string('siret', 14)->nullable()->change();
        });
    }
};
