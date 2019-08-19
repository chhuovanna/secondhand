<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table ='like';
    
}
public function likes()
{
return $this->belongsToMany('App\User', 'likes');
}