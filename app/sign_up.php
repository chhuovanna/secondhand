<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sign_up extends Model
{
    protected $table ='sign_up';
    protected $primaryKey = 'sign_up_ID';
    public $timestamps = false;
}
