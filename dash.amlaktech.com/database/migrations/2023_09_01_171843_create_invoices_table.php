<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_type');
            $table->double('amount');
            $table->date('invoice_date');
            $table->string('notes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
