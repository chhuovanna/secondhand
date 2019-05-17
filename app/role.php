<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model


{
    public function user(){
        return $this->belongsToMany('App\user','role_user','role_id','id');
    }
}
//no need