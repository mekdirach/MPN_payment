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
        Schema::create('tg_biller_mpn_log_tran_encaps', function (Blueprint $table) {
            $table->string('tgb_lte_id', 36)->nullable();
            $table->string('tgb_lte_mt', 4)->nullable();
            $table->string('tgb_lte_rc', 4)->nullable();
            $table->string('tgb_lte_fc', 10)->nullable();
            $table->string('tgb_lte_refnum', 32)->nullable();
            $table->string('tgb_lte_account_biller', 32)->nullable();
            $table->string('tgb_lte_account_source', 32)->nullable();
            $table->string('tgb_lte_account_fee', 32)->nullable();
            $table->string('tgb_lte_amount_fee', 12)->nullable();
            $table->string('tgb_lte_amount_total', 12)->nullable();
            $table->text('tgb_lte_raw_stream')->nullable();
            $table->text('tgb_lte_info')->nullable();
            $table->string('tgb_lte_tran_dt', 20)->nullable();
            $table->string('tgb_lte_saved_dt', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_log_tran_encaps');
    }
};
