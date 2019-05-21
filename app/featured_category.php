<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class featured_category extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\product','product_id','product_id');
    }
}
