<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('association_members', function (Blueprint $table) {
            $table->dropConstrainedForeignId('address_id');
            $table->string('address')->nullable();
            $table->boolean('status')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::table('association_members', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('status');
        });
    }
};
