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


<<<<<<< HEAD
    public function thumbnail()
    {
        return $this->belongsTo('App\Image','image_id','image_id');

    }

    public function photo()
    {
        return $this->hasMany('App\Image','product_id','product_id');

=======
    public function photo(){
        return $this->belongsTo('App\image','image_id','image_id');
    }

    public function thumbnail(){
        return $this->belongsTo('App\image','image_id','image_id');
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
    }

    public function featured_product()//add function featured_product
    {
<<<<<<< HEAD
        return $this->hasMany('App\FeaturedProduct','product_id','product_id');

=======
        return $this->hasMany('App\featured_product','product_id','product_id');
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
    }



<<<<<<< HEAD
}
=======


}
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
