<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id'); //product_id
            $table->string('name');
            $table->float('price'); //decimal
            $table->text('image'); //change thumpnail fk int references to table image 
            $table->string('categories'); //delete
            $table->text('description');
            $table->integer('view_number');
            $table->text('status');
            $table->text('pickup_address');
            $table->text('pickup_time');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            //$table->primary('product_id');

            //$table->foreign('image')->references('image_id')->on('image');
            //$table->foreign(fk in product)->references('pk in image')->on(name of table image);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
