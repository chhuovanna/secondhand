<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seller extends Model
{
    protected $table ='seller';
    protected $primaryKey = 'seller_ID';
    public $timestamps = false;
    public function post()
    {
        //return $this->hasMany('App\post');
    }

}
