<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    public function up(): void
    {
        Schema::table('polls', function (Blueprint $table) {
            
            $table->dropColumn(['weight', 'total', 'user_id']);

            $table->string('name')->after('id');

        });
    }

    
    public function down(): void
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->string('weight')->nullable();
            $table->decimal('total', 8, 2)->default(0);
            $table->unsignedBigInteger('user_id')->nullable();

             $table->dropColumn('name');

        });
    }
};
