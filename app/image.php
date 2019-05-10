<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    public function seller()
    {
        return $this->hasOne('App\seller');
    }
}
