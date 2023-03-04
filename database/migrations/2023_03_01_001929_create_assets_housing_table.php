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
        Schema::create('assets_housing', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('area');
            $table->integer('apartment_No');
            $table->integer('floor_No');
            $table->integer('bedrooms');
            $table->unsignedBigInteger('assetID');
            $table->foreign('assetID')->references('id')->on('user_assets');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_housing');
    }
};
