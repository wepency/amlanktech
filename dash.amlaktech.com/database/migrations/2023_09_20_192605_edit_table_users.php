<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address_id');
            $table->string('address')->after('salary')->nullable();
            $table->foreignId('city_id')->after('address')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('address_id');
            $table->dropColumn('address');
            $table->dropColumn('city_id');
        });
    }
};
