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
            $table->date('start_date_time')->nullable();
            $table->date('end_date_time')->nullable();
            $table->text('status')->nullable();
            $table->foreign('product_id')->references('product_id')->on('product'); //on product not seller
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            //add primary key
            $table->primary(['product_id', 'start_date_time']);

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
