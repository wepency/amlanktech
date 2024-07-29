<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('official_mail')->nullable();
            $table->string('address_mail')->nullable();
            $table->string('box_mail')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

     
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
