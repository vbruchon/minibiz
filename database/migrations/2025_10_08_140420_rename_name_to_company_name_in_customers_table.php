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
        Schema::table('customers', function (Blueprint $table) {
            // Supprime l'ancienne colonne
            $table->dropColumn('company_name');

            // Renomme 'name' en 'company_name'
            $table->renameColumn('name', 'company_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Renomme 'company_name' en 'name'
            $table->renameColumn('company_name', 'name');

            // Recrée l'ancienne colonne
            $table->string('company_name')->nullable();
        });
    }
};
