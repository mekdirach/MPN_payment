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
        Schema::create('app_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->nullable();
            $table->integer('table_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by', 32)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by', 32)->nullable();
            $table->string('user_id', 20)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('password', 255)->nullable();
            $table->integer('flow_transaksi_id', 32)->nullable();
            $table->integer('organisasi_id', 32)->nullable();
            $table->integer('flag_status_id', 32)->nullable();
            $table->integer('role_id', 32)->nullable();
            $table->boolean('is_locked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user');
    }
};
