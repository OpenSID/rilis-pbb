<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjekPajakDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objek_pajak_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('objek_pajak_id');
            $table->enum('kategori', ['1', '2'])->nullable(); // 1 : Bumi; 2 : Bangunan
            $table->decimal('luas_objek_pajak', 12, 2)->nullable();
            $table->string('klas', 3);
            $table->decimal('njop', 12, 2)->nullable();
            $table->decimal('total_njop', 12, 2)->nullable();
            $table->bigInteger('periode_id');
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
        Schema::dropIfExists('objek_pajak_detail');
    }
}
