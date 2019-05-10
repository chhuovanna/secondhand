<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //
    protected $table ='category';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsToMany('App\product');
    }

}
