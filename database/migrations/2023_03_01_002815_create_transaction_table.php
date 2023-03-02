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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->double("amount");      
            $table->text('description');

            $table->unsignedBigInteger('sellerID');
            $table->foreign('sellerID')->references('userID')->on('users');
            $table->unsignedBigInteger('buyerID');
            $table->foreign('buyerID')->references('userID')->on('users');
            $table->unsignedBigInteger('assetID');
            $table->foreign('assetID')->references('assetID')->on('user_Assets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
