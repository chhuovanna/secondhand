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
            $table->string('name')->unique();
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->integer('view_number')->nullable();
            $table->text('status')->nullable();
            $table->text('pickup_address')->nullable();
            $table->text('pickup_time')->nullable();
            $table->dateTime('created_at');//->nullable();
            $table->dateTime('updated_at');//->nullable();
            $table->integer('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('post_id')->on('post');
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')->references('image_id')->on('image');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seller');
    }
}
