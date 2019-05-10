<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //
    protected $table ='product';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo('App\post');
        return $this->belongsTo('App\category');

    }



}
