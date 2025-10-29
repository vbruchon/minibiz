<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['quote', 'invoice'])->default('quote');
            $table->string('number')->unique();
            $table->string('status')->default('draft');

            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_total', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->text('notes')->nullable();
            $table->text('footer_note')->nullable();
            $table->string('signature_path')->nullable();

            $table->foreignId('converted_from_id')->nullable()->constrained('bills')->nullOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_setting_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
