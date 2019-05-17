<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class post extends Model
{
    public function product()//not function command
    {
        return $this->hasMany('App\product','post_id','post_id');
    }

    public function seller(){ //create seller function
    	return $this->belongTo('App\seller','seller_id','seller_id');
    }
}
