<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->increments('id');// seller_id
            $table->string('name');
            $table->string('address');
            $table->string('email'); 
            $table->integer('phone'); //string
            $table->text('image'); // fk int
            $table->string('instant_massage_account');
            $table->string('type');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /** // fk int
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller');
    }
}
