<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::create('association_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();

            $table->foreignId('address_id')->nullable()->constrained(
                table: 'addresses', indexName: 'association_members_address_id_foreign'
            );

            $table->foreignId('association_id')->constrained(
                table: 'associations', indexName: 'association_members_association_id_foreign'
            );

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('association_members');
    }
};
