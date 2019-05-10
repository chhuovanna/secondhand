<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class seller extends Model
{
    //
    protected $table ='seller';
    public $timestamps = false;
    public static function getSeller($id){
        $sql = "select * from seller natural join product where id = $id;";
        return DB::select($sql);
        //return $sql;

    }

    public function image()
    {
        return $this->belongsTo('App\image');
    }

}
