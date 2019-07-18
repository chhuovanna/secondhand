<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    protected $table ='product';
    protected $primaryKey = 'product_id';

    public static function getProduct($product_id)
    {
        $sql = "select * from product";
        return DB::select($sql);
    }

    public function post()
    {
        return $this->belongsTo('App\Post','post_id','post_id');
    }


    public function category()
    {
        return $this->belongsToMany('App\Category','product_category', 'product_id','category_id'); //belong to many category
    }


    public function thumbnail()
    {
        return $this->belongsTo('App\Image','image_id','image_id');

    }

    public function photo()
    {
        return $this->hasMany('App\Image','product_id','product_id');

    }

    public function featured_product()//add function featured_product
    {
        return $this->hasMany('App\FeaturedProduct','product_id','product_id');

    }



}
