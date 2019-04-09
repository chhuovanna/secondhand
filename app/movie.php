<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class movie extends Model
{
    //
    protected $table ='movie';
    protected $primaryKey = 'mid';
    public $timestamps = false;

}
