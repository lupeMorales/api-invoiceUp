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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('template');
            $table->string('logo')->nullable();
            $table->string('number_invoice');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('company_mail');
            $table->string('company_cif');
            $table->string('client_name');
            $table->string('client_address');
            $table->string('client_phone')->nullable();
            $table->string('client_mail')->nullable();
            $table->string('client_cif');
            $table->decimal('iva', 5, 2);
            $table->decimal('iva_amount', 8, 2)->nullable();
            $table->decimal('irpf', 5, 2);
            $table->decimal('irpf_amount', 8, 2)->nullable();
            $table->date('issue_date');
            $table->date('expiration_date');
            $table->string('service');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
