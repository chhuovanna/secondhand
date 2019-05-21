<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class command extends Model
{

    protected $table ='command';
    protected $primaryKey = 'command_id';

    public function post(){
    return $this->belongTo(App\post,'seller_id',('id_post'));
}
}
//no command model