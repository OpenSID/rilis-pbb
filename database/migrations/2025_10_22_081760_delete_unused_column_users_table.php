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
        // hapus kolom telegram_chat_id, twofa_method, twofa_contact dari tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telegram_chat_id', 'twofa_method', 'twofa_contact']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // tambahkan kembali kolom telegram_chat_id, twofa_method, twofa_contact ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->after('otp_identifier');
            $table->string('twofa_method')->nullable()->after('telegram_chat_id');
            $table->string('twofa_contact')->nullable()->after('twofa_method');
        });
    }
};
