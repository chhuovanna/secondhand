<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seller extends Model
{
    //
    protected $table ='seller';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo('App\image');
    }

}
