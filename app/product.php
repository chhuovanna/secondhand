<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    protected $table ='product';
    protected $primaryKey = 'product_id';

    public static function getProduct($product_id)
    {
        $sql = "select * from product";
        return DB::select($sql);
    }

    public function post()
    {
        return $this->belongsTo('App\Post','post_id','post_id');
    }


    public function category()
    {
        return $this->belongsToMany('App\Category','product_category', 'product_id','category_id'); //belong to many category
    }


    public function thumbnail()
    {
        return $this->belongsTo('App\Image','image_id','image_id');

    }

    public function photo()
    {
        return $this->hasMany('App\Image','product_id','product_id');

    }

    public function featured_product()//add function featured_product
    {
        return $this->hasMany('App\FeaturedProduct','product_id','product_id');

    }

    public static function getactivefeatured($product_id){
        $sql = <<<EOT
        select date(start_date_time) as start_date, date(end_date_time) as end_date
        from featured_product
        where product_id = $product_id and (date(end_date_time) >= curdate())
            
        order by updated_at desc
        limit 0, 1;
EOT;
        return DB::select($sql);


    }

    public static function savefeatured($product_id, $start_date, $end_date){
        $sql = <<<EOT
        insert into featured_product(product_id, start_date_time, end_date_time)
        values($product_id, '$start_date', '$end_date');
EOT;
        return DB::insert($sql);

    }

    public static function updatefeatured($product_id, $start_date, $end_date){
        $old_featured = Product::getactivefeatured($product_id);
        $old_featured = $old_featured[0];
        $sql = <<<EOT
        update featured_product set
            start_date_time = '$start_date',
            end_date_time = '$end_date'
        where product_id = $product_id
            and date(start_date_time) = '$old_featured->start_date'
            and date(end_date_time) = '$old_featured->end_date';

EOT;
        return DB::update($sql);

    }

    public static function getProductsWithThumbnailCategory($offset=0,$seller_id=0, $features = 0, $like =0){
        $products = Product::select(['product.product_id', 'product.name', 'price'
        , 'description','like_number','status','pickup_address','pickup_time','created_at'
        ,'updated_at',  'file_name', 'location'])
        ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp')
            ,'product.image_id', '=', 'temp.image_id')
        ->where('status','Available')
        ->with('category');
        
        if ($seller_id != 0){
            $products = $products->leftJoin(DB::raw('(select post_id, seller_id from post) as temp1')
            ,'product.post_id', '=', 'temp1.post_id')
            ->where('temp1.seller_id',$seller_id);
        }

        if($like ==1){
            $products = $products->with('like');
        }
        if($features == 1){
            $products = $products->join(DB::raw('(select product_id from featured_product where (date(end_date_time) >= curdate() and date(start_date_time) <= curdate()) group by product_id ) as temp2')
            , 'temp2.product_id','product.product_id');
        }

        $products = $products->offset($offset)
            ->take(4)
            ->orderBy('product.product_id','desc')
            ->get();

        return $products;


    }

    public function like()
    {
        return $this->hasMany('App\Like','product_id', 'product_id'); //belong to many category
    }

    public static function getSize($seller_id, $features){
        $products = Product::where('status','Available');
        
        if ($seller_id != 0){
            $products = $products->leftJoin(DB::raw('(select post_id, seller_id from post) as temp1')
            ,'product.post_id', '=', 'temp1.post_id')
            ->where('temp1.seller_id',$seller_id);
        }

        if($features == 1){
            $products = $products->join(DB::raw('(select product_id from featured_product where (date(end_date_time) >= curdate() and date(start_date_time) <= curdate()) group by product_id ) as temp2')
            , 'temp2.product_id','product.product_id');
        }

        $size = $products->count();

        return $size;
    }

}
