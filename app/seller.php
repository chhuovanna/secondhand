<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class seller extends Model
{
    //
    protected $table ='seller';




    public function post()
    {
        return $this->hasMany('App\post');
    }

}
