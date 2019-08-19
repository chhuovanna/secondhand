<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table ='like';
    
    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id','product_id');
    }
    
}
