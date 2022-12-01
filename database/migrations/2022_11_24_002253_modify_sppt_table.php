<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sppt', function (Blueprint $table) {
            $table->after('subjek_pajak_id', function ($table) {
                $table->bigInteger('pemilik')->nullable(); // relasi subjek pajak id
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sppt', function (Blueprint $table) {
            $table->dropColumn(['pemilik']);
        });
    }
}
