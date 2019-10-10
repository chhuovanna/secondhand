<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{

    public function up()
    {
        Schema::create('product', function (Blueprint $table) {//create product not seller
            $table->increments('product_id');
            $table->string('name');
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->integer('like_number')->nullable();
            $table->text('status')->nullable();
            $table->text('pickup_address')->nullable();
            $table->text('pickup_time')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('post_id')->on('post');
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')->references('image_id')->on('image');
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
        Schema::drop('product');
    }
}
