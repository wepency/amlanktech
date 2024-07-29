<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      
    public function up(): void
    {
        Schema::create('investment_company_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('investment_type');
            $table->string('amount');
            $table->foreignId('company_id');
            $table->string('contract_file');
            $table->softDeletes();
            $table->timestamps();
        });
    }
 
    
    public function down(): void
    {
        Schema::dropIfExists('investment_company_contracts');
    }
};
