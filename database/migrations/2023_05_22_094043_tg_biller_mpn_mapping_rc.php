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
        Schema::create('tg_biller_mpn_mapping_rc', function (Blueprint $table) {
            $table->string('tgb_mpn_mapping_rc', 4)->nullable(false);
            $table->string('tgb_mpn_mapping_desc', 200)->nullable();
            $table->string('tgb_mpn_mapping_desc_internal', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_biller_mpn_mapping_rc');
    }
};
