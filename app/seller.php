<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seller extends Model
{
    //
    protected $table ='seller';



    protected $primaryKey = 'seller_id';




    public function post()
    {
        return $this->hasMany('App\post');
    }

}
