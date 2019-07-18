<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table ='seller';
    protected $primaryKey = 'seller_id'; //id not ID
    public $timestamps = false;


    public function post()
    {
        return $this->hasMany('App\Post','seller_id','seller_id');//ADD key
    }


    public function image(){
        return $this->belongsTo('App\Image','image_id','image_id');
    }
    public static function getSellersWithImage($offset=0){
        $sellers = Seller::select(['seller_id', 'name', 'address', 'email','phone','message_account','type','seller.image_id','seller.created_at','seller.updated_at','location','file_name'])
            ->leftJoin('image','seller.image_id', '=', 'image.image_id')->orderBy('seller.seller_id','desc')->offset($offset)
            ->limit(20)->get();

        return $sellers;

    }
    public function user(){
        return $this->belongsTo('App\Models\Auth\User','user_id','id');
    }
}
