<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table ='image';
    protected $primaryKey = 'image_id';

    public function product()
    {
        return $this->belongsTo('App\product','product_id',' product_id'); //not seller
    }

    public function category()
    {
        return $this->hasOne('App\category', 'image_id', 'image_id');
    }

    public function seller()
    {
        return $this->hasOne('App\seller','image_id','image_id');
    }
}
