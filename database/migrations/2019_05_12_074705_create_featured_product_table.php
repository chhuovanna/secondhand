<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_product', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->date('stard_date_time')->nullable();
            $table->date('end_date_time')->nullable();
            $table->text('status')->nullable();
            $table->foreign('product_id')->references('product_id')->on('seller');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('featured_product');
    }
}
