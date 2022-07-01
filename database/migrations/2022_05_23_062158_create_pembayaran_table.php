<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sppt_id');
            $table->date('tanggal_bayar');
            $table->string('nama_pembayar_pajak')->nullable();
            $table->string('alamat_pembayar_pajak')->nullable();
            $table->enum('status', ['1', '2'])->nullable(); // 1 : Terhutang; 2 : Lunas
            $table->date('tanggal_setor')->nullable();
            $table->decimal('nilai_denda', 12, 2)->nullable();
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
        Schema::dropIfExists('pembayaran');
    }
}
