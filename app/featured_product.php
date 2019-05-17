<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class featured_product extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\product','product_id','product_id');
    }
}
// no featured_category
// we only have featured_product