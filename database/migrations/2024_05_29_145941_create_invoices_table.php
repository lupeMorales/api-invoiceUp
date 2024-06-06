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
            $table->id(); // autoincremental por defecto
            $table->timestamps(); // fecha de cración fecha de actualización
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('template');
            /*    $table->string('logo')->nullable(); */
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('company_mail');
            $table->string('company_cif');
            $table->string('client_name');
            $table->string('client_address');
            $table->string('client_phone');
            $table->string('client_mail');
            $table->string('client_cif');

            $table->float('iva');
            $table->float('iva_amount');
            $table->float('irpf');
            $table->float('irpf_amount');
            $table->string('issue_date');
            $table->string('expiration_date');
            $table->string('service');
            $table->integer('quantity');
            $table->float('price');
            $table->float('total_invoice');

            $table->timestamp('')

            $table->string("number_invoice");
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
