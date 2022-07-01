<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppt', function (Blueprint $table) {
            $table->id();
            $table->string('nop', 30);
            $table->bigInteger('objek_pajak_id');
            $table->bigInteger('subjek_pajak_id');
            $table->decimal('nilai_pagu_pajak', 12, 2)->nullable();
            $table->enum('status', ['1', '2'])->nullable(); // 1 : Terhutang; 2 : Lunas
            $table->bigInteger('periode_id')->nullable();
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
        Schema::dropIfExists('sppt');
    }
}
