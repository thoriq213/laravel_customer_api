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
        Schema::create('address_stores', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->longText('address');
            $table->string('district');
            $table->string('city');
            $table->string('province');
            $table->integer('postal_code');
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_stores');
    }
};
