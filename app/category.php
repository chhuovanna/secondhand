<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //
    protected $table ='category';
    protected $primaryKey = 'category_id';

    public function product()
    {
        return $this->belongsToMany('App\product','product_category','category_id','product_id');//not seller ; add intermediate table and key name
    }
    public function thumbnail()
    {
        return $this->belongsTo('App\image','image_id','image_id');
    }
}
