<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model
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
        return $this->belongsTo('App\post','post_id','post_id');
    }


    public function category()
    {
        return $this->belongsToMany('App\category','product_category', 'product_id','category_id'); //belong to many category
    }


    public function thumbnail()
    {
        return $this->belongsTo('App\image','image_id','image_id');

    }

    public function photo()
    {
        return $this->belongsTo('App\image','image_id','image_id');

    }


    public function featured_product()//add function featured_product
    {
        return $this->hasMany('App\featured_product','product_id','product_id');

    }


}