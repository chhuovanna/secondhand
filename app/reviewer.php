<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reviewer extends Model
{
    //
    protected $table ='reviewer';
    protected $primaryKey = 'rid';
    public $timestamps = false;

}
