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
        Schema::create('users', function (Blueprint $table) {
            $table->id("userID");
            $table->string('username');
            $table->string('fname');
            $table->string('lname');
            $table->string('mobile')->nullable()->change();  
            $table->string('birthday');
            $table->string('password');
            $table->string('accountNo');
            $table->string('zip');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('national_Id');
            $table->double("balance")->nullable()->change();      
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_email_token', 100)->nullable();
            $table->string('refresh_token',255)->nullable();
            $table->timestamp('refresh_token_expiration')->nullable();
            $table->timestamps();
            $table->boolean('isAdmin')->default(0)->change();

       
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
