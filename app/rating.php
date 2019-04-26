<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class rating extends Model
{
    //
    protected $table ='rating';
    public $timestamps = false;
    public static function getRating($mid){
    	$sql = "select * from rating natural join reviewer where mid = $mid;";
    	return DB::select($sql);
    	//return $sql;

    }

}
