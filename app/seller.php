<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seller extends Model
{
    protected $table ='seller';
    protected $primaryKey = 'seller_id'; //id not ID
    public $timestamps = false;


    public function post()
    {
        return $this->hasMany('App\post','seller_id','seller_id');//ADD key
    }


    public function image(){
        return $this->belongTo('App\image','image_id','image_id');
    }

}
