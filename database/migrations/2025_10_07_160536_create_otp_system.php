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
        // Tambahkan field OTP ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('otp_enabled')->default(false);
            $table->json('otp_channel')->nullable(); // untuk mendukung multiple channels  
            $table->string('otp_identifier')->nullable(); // email atau telegram chat_id
            $table->string('telegram_chat_id')->nullable();
        });

        // Buat tabel untuk menyimpan token OTP
        Schema::create('otp_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token_hash');
            $table->enum('channel', ['email', 'telegram']);
            $table->string('identifier'); // email atau telegram chat_id
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'expires_at']);
        });                
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp_enabled', 'otp_channel', 'otp_identifier', 'telegram_chat_id']);
        });

        Schema::dropIfExists('otp_tokens'); 
    }
};
