<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRayonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rayon', function (Blueprint $table) {
            $table->after('nama_rayon', function ($table) {
                $table->string('foto_rayon')->nullable();
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
        Schema::table('rayon', function (Blueprint $table) {
            $table->dropColumn(['foto_rayon']);
        });
    }
}
