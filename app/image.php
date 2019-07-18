<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table ='image';
    protected $primaryKey = 'image_id';

    public function product()
    {
        return $this->belongsTo('App\Product','product_id',' product_id'); //not seller
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'image_id', 'image_id');
    }

    public function seller()
    {
        return $this->hasOne('App\Seller','image_id','image_id');
    }
}
