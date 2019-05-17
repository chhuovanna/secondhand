<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table ='image';
    protected $primaryKey = 'image_id';

    public function product()
    {
        return $this->belongsTo('App\product'); //not seller
    }
}
