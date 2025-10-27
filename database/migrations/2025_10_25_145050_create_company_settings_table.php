<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone')->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('postal_code', 20);
            $table->string('city');
            $table->string('country', 100);
            $table->string('vat_number')->nullable();
            $table->string('siret')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->decimal('default_tax_rate', 5, 2)->default(20.00);
            $table->text('footer_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
