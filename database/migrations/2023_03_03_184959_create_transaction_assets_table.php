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
        Schema::create('transaction_assets', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->text('description')->nullable();
            $table->unsignedBigInteger('assetID');
            $table->foreign('assetID')->references('id')->on('user_assets');
            $table->unsignedBigInteger('sellerID');
            $table->foreign('sellerID')->references('id')->on('users');
            $table->unsignedBigInteger('buyerID');
            $table->foreign('buyerID')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_assets');
    }
};
