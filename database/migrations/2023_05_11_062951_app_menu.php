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
        Schema::create('app_menu', function (Blueprint $table) {

            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('table_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('parent_id')->nullable();
            $table->string('name', 150);
            $table->string('path', 255);
            $table->string('fa_icon', 50)->nullable();
            $table->smallInteger('position');
            $table->boolean('show');
            $table->text('description');
            $table->string('mod_prefix', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_menu', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('table_id')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by');
            $table->integer('parent_id');
            $table->string('name', 150)->nullable();
            $table->string('path', 255)->nullable();
            $table->string('fa_icon', 50);
            $table->smallInteger('position')->nullable();
            $table->boolean('show')->nullable();
            $table->text('description')->nullable();
            $table->string('mod_prefix', 100);
        });
    }
};
