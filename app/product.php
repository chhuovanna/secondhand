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
        where product_id = $product_id and (date(end_date_time) > curdate()
            or date(end_date_time) = '9999-01-01')
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

    public static function getProductsWithThumbnailCategory($offset=0){
        $products = Product::select(['product.product_id', 'product.name', 'price'
            , 'description','view_number','status','pickup_address','pickup_time','created_at'
            ,'updated_at',  'file_name', 'location'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp')
                ,'product.image_id', '=', 'temp.image_id')
            ->where('status','Available')
            ->with('category')
            ->offset($offset)
            ->take(4)
            ->orderBy('product.product_id','desc')
            ->get();

        return $products;

    }

    public function like()
    {
        return $this->hasMany('App\Like','product_id', 'product_id'); //belong to many category
    }

    public static function getProductsWithThumbnailCategoryLike($offset=0){
        $products = Product::select(['product.product_id', 'product.name', 'price'
            , 'description','view_number','status','pickup_address','pickup_time','created_at'
            ,'updated_at',  'file_name', 'location'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp')
                ,'product.image_id', '=', 'temp.image_id')
            ->where('status','Available')
            ->with('category')
            ->with('like')
            ->offset($offset)
            ->take(4)
            ->orderBy('product.product_id','desc')
            ->get();

        return $products;

    }

    public static function getProductsWithThumbnailCategoryLikeFeatured($offset=0){
        $products = Product::select(['product.product_id', 'product.name', 'price'
            , 'description','view_number','status','pickup_address','pickup_time','created_at'
            ,'updated_at',  'file_name', 'location'])
            ->join(DB::raw('(select product_id from featured_product where (date(end_date_time) > curdate() or date(end_date_time) = "9999-01-01") group by product_id ) as temp1')
                , 'temp1.product_id','product.product_id')
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp')
                ,'product.image_id', '=', 'temp.image_id')
            ->where('status','Available')
            ->with('category')
            ->with('like')
            ->offset($offset)
            ->take(4)
            ->orderBy('product.product_id','desc')
            ->get();

        return $products;

    }

    public static function getProductsWithThumbnailCategoryFeatured($offset=0){
        $products = Product::select(['product.product_id', 'product.name', 'price'
            , 'description','view_number','status','pickup_address','pickup_time','created_at'
            ,'updated_at',  'file_name', 'location'])
            ->join(DB::raw('(select product_id from featured_product where (date(end_date_time) > curdate() or date(end_date_time) = "9999-01-01") group by product_id ) as temp1')
                , 'temp1.product_id','product.product_id')
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp')
                ,'product.image_id', '=', 'temp.image_id')
            ->where('status','Available')
            ->with('category')
            ->offset($offset)
            ->take(4)
            ->orderBy('product.product_id','desc')
            ->get();

        return $products;

    }


}
