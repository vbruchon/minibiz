<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('siren', 9)->nullable(false)->change();
            $table->string('siret', 14)->nullable(false)->change();
            $table->string('ape_code', 10)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('siren', 9)->nullable()->change();
            $table->string('siret', 14)->nullable()->change();
            $table->string('ape_code', 10)->nullable()->change();
        });
    }
};
