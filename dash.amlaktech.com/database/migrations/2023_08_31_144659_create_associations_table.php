<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('map_link')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('registration_certificate')->nullable();
            $table->string('unit_fee_per_meter')->nullable();
            $table->string('car_fee')->nullable();
            $table->string('family_fee')->nullable();
            $table->string('person_fee')->nullable();
//            $table->foreignId('admin_id')->constrained('admins');

            $table->foreignId('admin_id')->constrained(
                table: 'admins', indexName: 'associations_admin_id_foreign'
            );

            $table->foreignId('address_id')->constrained(
                table: 'addresses', indexName: 'associations_address_id_foreign'
            );

            $table->softDeletes();
            $table->timestamps();


        });
    }


    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
