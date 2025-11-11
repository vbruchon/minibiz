<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('siren', 9)->nullable()->after('company_name');
            $table->string('siret', 14)->nullable()->after('siren');
            $table->string('ape_code', 10)->nullable()->after('siret');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['siren', 'siret', 'ape_code']);
        });
    }
};
