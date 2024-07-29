<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit_number')->nullable();
            $table->integer('instrument_number')->nullable();
            $table->string('instrument_file')->nullable();
            $table->string('meter_price')->nullable();
            $table->string('area')->nullable();
            $table->foreignId('association_member_id')->nullable();

            //subscription paraneter
            $table->string('total')->nullable();
            $table->integer('unit_memebers')->nullable();
            $table->integer('unit_families')->nullable();
            $table->integer('car_numbers')->nullable();

            $table->string('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
