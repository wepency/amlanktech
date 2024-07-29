<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->foreignId('address_id')->nullable();
            $table->boolean('is_admin')->nullable()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
