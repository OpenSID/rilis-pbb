<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySubjekPajakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjek_pajak', function (Blueprint $table) {
            $table->after('penduduk', function ($table) {
                $table->string('nik', 16)->nullable();
                $table->string('no_hp', 16)->nullable();
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
        Schema::table('subjek_pajak', function (Blueprint $table) {
            $table->dropColumn(['nik']);
            $table->dropColumn(['no_hp']);
        });
    }
}
