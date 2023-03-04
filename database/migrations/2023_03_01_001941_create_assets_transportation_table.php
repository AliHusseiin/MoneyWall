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
        Schema::create('assets_transportation', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('year');
            $table->double('millage');
            $table->string('color');
            $table->string('transmission_type');
            $table->string('condition');
            $table->string('brand');
            $table->integer('cc');
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
        Schema::dropIfExists('assets_transportation');
    }
};
