<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      

    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->foreignId('subscription_type_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('total')->nullable();
            $table->date('start_payment')->nullable();
            $table->date('end_payment')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

      

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
