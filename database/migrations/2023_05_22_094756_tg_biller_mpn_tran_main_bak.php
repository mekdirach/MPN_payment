<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_biller_mpn_tran_main_bak', function (Blueprint $table) {
            $table->string('tgb_tm_npwp', 16)->nullable();
            $table->string('tgb_tm_nama_wajib_pajak', 125)->nullable();
            $table->string('tgb_tm_alamat_wajib_pajak', 100)->nullable();
            $table->string('tgb_tm_akun', 6)->nullable();
            $table->string('tgb_tm_kode_jenis_setoran', 6)->nullable();
            $table->string('tgb_tm_masa_pajak', 8)->nullable();
            $table->string('tgb_tm_nomor_sk', 15)->nullable();
            $table->string('tgb_tm_nop', 18)->nullable();
            $table->string('tgb_tm_ntpn', 16)->nullable();
            $table->string('tgb_tm_nama_wajib_bayar', 50)->nullable();
            $table->string('tgb_tm_id_wajib_bayar', 20)->nullable();
            $table->string('tgb_tm_jenis_dokumen', 2)->nullable();
            $table->string('tgb_tm_nomor_dokumen', 30)->nullable();
            $table->string('tgb_tm_tanggal_dokumen', 10)->nullable();
            $table->string('tgb_tm_kode_kpbc', 6)->nullable();
            $table->string('tgb_tm_k_l', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_tran_main_bak');
    }
};
