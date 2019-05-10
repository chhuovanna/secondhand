<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model
{
    //
    protected $table ='product';
    public $timestamps = false;
    public static function getProduct($id){
        $sql = "select * from product natural join seller where id = $id;";
        return DB::select($sql);
        //return $sql;

    }

    public function post()
    {
        return $this->belongsTo('App\post');
        return $this->belongsTo('App\category');

    }



}
