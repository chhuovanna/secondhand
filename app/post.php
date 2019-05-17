<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class post extends Model
{
    public function command()
    {
        return $this->hasMany('App\command','seller_id','post_id');
    }
}
