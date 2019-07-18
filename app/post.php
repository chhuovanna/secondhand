<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\App;

class Post extends Model
{
    public $primaryKey = 'post_id';
    public $table = 'post';
    public function product()//not function command
    {
        return $this->hasMany('App\Product','post_id','post_id');
    }

    public function seller(){ //create seller function
        return $this->belongTo('App\Seller','seller_id','seller_id');

    }
}
