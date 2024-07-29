<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    
    public function up(): void
    {
        Schema::table('association_members', function (Blueprint $table) {
            $table->string('city_id')->after('association_id')->nullable();
        });
    }

   
    
    public function down(): void
    {
        Schema::table('association_members', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};
