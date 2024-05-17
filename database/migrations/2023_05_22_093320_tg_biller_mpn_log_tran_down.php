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
        Schema::create('tg_biller_mpn_log_tran_down', function (Blueprint $table) {
            $table->string('tgb_ltd_id', 36)->nullable();
            $table->string('tgb_ltd_account', 32)->nullable();
            $table->string('tgb_ltd_bill_id', 32)->nullable();
            $table->string('tgb_ltd_refnum', 32)->nullable();
            $table->string('tgb_ltd_gw_stan', 11)->nullable();
            $table->string('tgb_ltd_stan', 11)->nullable();
            $table->string('tgb_ltd_cmd', 4)->nullable();
            $table->string('tgb_ltd_rc', 4)->nullable();
            $table->string('tgb_ltd_wid', 10)->nullable();
            $table->text('tgb_ltd_raw_stream')->nullable();
            $table->string('tgb_ltd_logged_dt', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_log_tran_down');
    }
};
