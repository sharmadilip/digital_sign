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
        Schema::create('pdf_templates', function (Blueprint $table) {
        $table->id();
        $table->text('template_name')->nullable();;
        $table->longText('pdf_data_html');
        $table->timestamps();
        });
    
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pdf_templates');
    }
};
