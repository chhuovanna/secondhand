<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\Product','product_id','product_id');
    }
}
