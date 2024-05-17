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
        Schema::create('app_permission', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('table_id')->default(2);
            $table->timestamps();
            $table->softDeletes();
            $table->string('name', 255);
            $table->string('path', 255);
            $table->text('description')->nullable();
            $table->integer('menu_id')->nullable();
            $table->string('type', 10)->nullable();
            $table->string('nama_external', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_permission');
    }
};
