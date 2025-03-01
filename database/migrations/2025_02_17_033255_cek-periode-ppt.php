<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Memastikan periode_id terisi dengan benar
        DB::table('sppt')
            ->whereNull('periode_id')  // Filter hanya yang periode_id NULL
            ->get()
            ->each(function ($item) {
                // Ambil tahun dari created_at
                $tahun = Carbon::parse($item->created_at)->year;

                // Cari periode_id yang sesuai dengan tahun
                $periode = DB::table('periode')->where('tahun', $tahun)->first();

                // Jika periode ditemukan, update periode_id
                if ($periode) {
                    DB::table('sppt')
                        ->where('id', $item->id)
                        ->update(['periode_id' => $periode->id]);
                }
            });

        // Pastikan tidak ada nilai NULL pada periode_id
        $countNull = DB::table('sppt')->whereNull('periode_id')->count();
        if ($countNull > 0) {
            throw new \Exception("Masih ada data dengan periode_id NULL. Harap periksa kembali data di tabel sppt.");
        }

        // Mengubah kolom periode_id menjadi NOT NULL
        DB::statement('ALTER TABLE sppt MODIFY periode_id BIGINT NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Tidak ada perubahan yang perlu dibatalkan
    }
};
