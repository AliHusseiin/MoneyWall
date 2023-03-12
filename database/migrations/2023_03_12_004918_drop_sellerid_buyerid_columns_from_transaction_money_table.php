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
        Schema::table('transaction_money', function (Blueprint $table) {
            $table->dropForeign(['sellerID']);
            $table->dropForeign(['buyerID']);
            $table->dropColumn(['sellerID', 'buyerID']);
            $table->unsignedBigInteger('senderID');
            $table->foreign('senderID')->references('id')->on('users');
            $table->unsignedBigInteger('receiverID');
            $table->foreign('receiverID')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_money', function (Blueprint $table) {
            //
        });
    }
};
