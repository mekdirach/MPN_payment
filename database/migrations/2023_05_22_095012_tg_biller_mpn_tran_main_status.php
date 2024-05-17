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
        Schema::create('tg_biller_mpn_tran_main_status', function (Blueprint $table) {
            $table->integer('tgb_tms_bill_id')->primary()->nullable(false)->length(32);
            $table->date('tgb_tms_create_date')->nullable();
            $table->date('tgb_tms_update_date')->nullable();
            $table->string('tgb_tms_post_status')->nullable();
            $table->string('tgb_tms_flag_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_tran_main_status');
    }
};
