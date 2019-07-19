<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{

    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('image_id');//->nullable();
            $table->text('location');//->nullable();
            $table->text('file_name');//->nullable();
            $table->integer('product_id')->unsigned()->nullable() ; //product_id can be null in case the image is for category etc.
            $table->engine = 'InnoDB';

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
