<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerTable extends Migration
{

    public function up()
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->increments('seller_id');
            $table->string('name')->unique();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('message_account')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')->references('image_id')->on('image');
        });
    }
    public function down()
    {
        Schema::drop('seller');
    }
}
