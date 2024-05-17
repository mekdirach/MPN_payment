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
        Schema::create('tg_biller_mpn_tran_main', function (Blueprint $table) {
            $table->string('tgb_tm_npwp', 16)->nullable();
            $table->string('tgb_tm_nama_wajib_pajak', 125)->nullable();
            $table->string('tgb_tm_alamat_wajib_pajak', 50)->nullable();
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

            $table->string('tgb_tm_unit_eselon_i', 2)->nullable();
            $table->string('tgb_tm_kode_satker', 6)->nullable();
            $table->string('tgb_tm_id', 36)->nullable();
            $table->string('tgb_tm_batch_id', 36)->nullable();
            $table->string('tgb_tm_bill_id', 15)->nullable();
            $table->string('tgb_tm_refnum', 15)->nullable();
            $table->string('tgb_tm_bank_refnum', 15)->nullable();
            $table->string('tgb_tm_cc', 16)->nullable();
            $table->string('tgb_tm_type_mpn', 5)->nullable();
            $table->string('tgb_tm_amount', 15)->nullable();
            $table->string('tgb_tm_amount_fee', 15)->nullable();
            $table->string('tgb_tm_pay_day', 8)->nullable();
            $table->string('tgb_tm_stan', 15)->nullable();
            $table->string('tgb_tm_gw_stan', 6)->nullable();
            $table->string('tgb_tm_account', 32)->nullable();
            $table->string('tgb_tm_currency', 4)->nullable();

            $table->string('tgb_tm_cmd', 4)->nullable();
            $table->string('tgb_tm_no_sakti', 16)->nullable();
            $table->string('tgb_tm_status', 1)->nullable();
            $table->string('tgb_tm_recon_status', 1)->nullable();
            $table->string('tgb_tm_pelaporan_status', 1)->nullable();
            $table->string('tgb_tm_pelimpahan_status', 1)->nullable();
            $table->string('tgb_tm_tran_dt', 20)->nullable();
            $table->text('tgb_tm_info')->nullable();
            $table->text('tgb_tm_setlement')->nullable();
            $table->text('tgb_tm_additional_data')->nullable();
            $table->text('tgb_tm_raw_stream')->nullable();
            $table->string('tgb_tm_saved_dt', 20)->nullable();
            $table->string('tgb_tm_pay_dt', 20)->nullable();
            $table->string('tgb_tm_msg_dt', 20)->nullable();
            $table->string('tgb_tm_msg_rc', 2)->nullable();
            $table->string('tgb_tm_msg_gw_stan', 11)->nullable();

            $table->string('tgb_tm_channel', 6)->nullable();
            $table->string('tgb_tm_settlement_hour', 8)->nullable();
            $table->text('tgb_tm_json_stream', 0)->nullable();
            $table->string('tgb_tm_user', 4)->nullable();
            $table->integer('tgb_tm_counter', 1)->nullable();
            $table->string('tgb_tm_jumlah_detil', 2)->nullable();
            $table->string('tgb_tm_ntb', 12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_tran_main');
    }
};
