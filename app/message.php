<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $table ='message';
    protected $primaryKey = 'message_id'; //id not ID
    public $timestamps = false;
}
