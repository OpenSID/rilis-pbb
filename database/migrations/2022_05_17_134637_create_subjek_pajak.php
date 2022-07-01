<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjekPajak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjek_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('nama_subjek', 64);
            $table->string('alamat_subjek', 128)->nullable();
            $table->enum('kategori', ['1', '2', '3'])->nullable(); // 1 : penduduk; 2 : luar_penduduk, 3 : badan
            $table->string('npwp', 20)->nullable();
            $table->text('penduduk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjek_pajak');
    }
}
