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
            $table->string('company_name');
            $table->renameColumn('email', 'company_email');
            $table->renameColumn('phone', 'company_phone');
            $table->renameColumn('address', 'address_line1');
            $table->string('address_line2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('website')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->enum('status', ['active', 'inactive', 'prospect'])->default('prospect');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'address_line2',
                'postal_code',
                'city',
                'website',
                'vat_number',
                'contact_name',
                'contact_email',
                'contact_phone',
                'status',
            ]);

            $table->renameColumn('company_email', 'email');
            $table->renameColumn('company_phone', 'phone');
            $table->renameColumn('address_line1', 'address');
        });
    }
};
