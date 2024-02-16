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
        Schema::create('invoice_table', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('user_email_id')->nullable();
            $table->string('client_name');
            $table->string('client_company_name')->nullable();
            $table->string('client_email_id');
            $table->string('client_location')->nullable();
            $table->string('client_ip')->nullable();
            $table->string('client_street')->nullable();
            $table->string('client_postcode')->nullable();
            $table->string('contract_type')->nullable();
            $table->integer('email_template')->nullable();
            $table->integer('template_id')->nullable();
            $table->string('client_functie')->nullable();
            $table->longText('pdf_html_data')->nullable();
            $table->longText('client_sing')->nullable();
            $table->integer('order_status')->comment("0 for not send 1 for send to client 2 for sign by client");
            $table->timestamp('send_to_client')->nullable();
            $table->timestamp('sign_in_date')->nullable();
            $table->tinyInteger('resend_status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
