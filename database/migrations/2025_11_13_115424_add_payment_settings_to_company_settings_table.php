<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->json('payment_methods')->nullable()->after('footer_note');
            $table->string('bank_iban')->nullable()->after('payment_methods');
            $table->string('bank_bic')->nullable()->after('bank_iban');
        });
    }

    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['payment_methods', 'bank_iban', 'bank_bic']);
        });
    }
};
