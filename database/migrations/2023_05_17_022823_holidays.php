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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->date('holiday_date', 6)->nullable();
            $table->string('holiday_desc')->nullable();
            $table->string('created_by', 4)->nullable(false);
            $table->timestamp('created_dt', 6)->nullable(false);
            $table->string('updated_by', 4)->nullable(false);
            $table->timestamp('updated_dt', 6)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
};
