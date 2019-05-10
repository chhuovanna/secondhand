<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{

    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('image_id')->nullable();
            $table->text('location')->nullable();
            $table->text('file_name')->nullable();
            $table->integer('product_id')->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image');
    }
}
