<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //
    protected $table ='category';
    protected $primaryKey = 'category_id';
    //public $timestamps = false;

    public function product()
    {
        return $this->belongsToMany('App\seller');
    }

    public function thumbnail()
    {
        return $this->belongsTo('App\image');
    }

}
