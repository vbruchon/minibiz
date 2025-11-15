<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('bank_iban')->nullable(false)->change();
            $table->string('bank_bic')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('bank_iban')->nullable()->change();
            $table->string('bank_bic')->nullable()->change();
        });
    }
};
