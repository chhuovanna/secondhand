<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seller extends Model
{
    //
    protected $table ='seller';
    protected $primaryKey = 'seller_id';

    public static function getSeller($seller_id)
    {
        $sql = "select * from seller";
        return DB::select($sql);
    }

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
            ->limit(20)
            ->get();
        return $sellers;
    }
    public function user(){
        return $this->belongsTo('App\Models\Auth\User','user_id','id');
    }

//     public static function getactivefeatured($seller_id){
//         $sql = <<<EOT
//         select date(start_date_time) as start_date, date(end_date_time) as end_date
//         from featured_product
//         where seller_id = $seller_id and (date(end_date_time) > curdate()
//             or date(end_date_time) = '9999-01-01')
//         order by updated_at desc
//         limit 0, 1;
// EOT;
//         return DB::select($sql);


//     }

//     public static function savefeatured($seller_id, $start_date, $end_date){
//         $sql = <<<EOT
//         insert into featured_product(product_id, start_date_time, end_date_time)
//         values($product_id, '$start_date', '$end_date');
// EOT;
//         return DB::insert($sql);

//     }

//     public static function updatefeatured($product_id, $start_date, $end_date){
//         $old_featured = Product::getactivefeatured($product_id);
//         $old_featured = $old_featured[0];
//         $sql = <<<EOT
//         update featured_product set
//             start_date_time = '$start_date',
//             end_date_time = '$end_date'
//         where product_id = $product_id
//             and date(start_date_time) = '$old_featured->start_date'
//             and date(end_date_time) = '$old_featured->end_date';

// EOT;
//         return DB::update($sql);

//     }

    //





    // for seller
    public static function getSellersWithThumbnailCategory($offset=0){
        $sellers =  Seller::select(['seller_id', 'name', 'address', 'email', 'phone'
                , 'message_account', 'type', 'seller.image_id', 'seller.created_at'
                , 'seller.updated_at', 'location', 'file_name'])

        ->leftJoin(DB::raw('(select image_id, file_name, location from image) AS temp'), 'seller.image_id', '=', 'temp.image_id')
            ->with('category')

            ->offset($offset)
            ->take(4)
            ->orderBy('seller.seller_id','desc')
            ->get();
        return $sellers;
    }
}
