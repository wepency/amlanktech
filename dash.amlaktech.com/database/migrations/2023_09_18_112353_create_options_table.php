<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('option')->nullable();
            $table->foreignId('poll_id')->nullable();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
