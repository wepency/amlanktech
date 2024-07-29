<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('is_manager')->nullable()->after('phone_number');
        });
    }

    
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('is_manager');

        });
    }
};
