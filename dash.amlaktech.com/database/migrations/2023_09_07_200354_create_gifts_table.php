<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->foreignId('association_member_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

       public function down(): void
    {
        Schema::dropIfExists('gifts');
    }
};
