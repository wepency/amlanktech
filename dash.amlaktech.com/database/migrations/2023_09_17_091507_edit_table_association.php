<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->dropColumn('unit_fee_per_meter');
            $table->dropColumn('car_fee');
            $table->dropColumn('family_fee');
            $table->dropColumn('person_fee');

            $table->dropConstrainedForeignId('address_id');

            $table->string('address')->after('admin_id')->nullable();
            $table->foreignId('city_id')->after('admin_id')->constrained('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('associations', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropForeign('city_id');
        });
    }
};
