<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table ='category';
    protected $primaryKey = 'category_id';

    public function product()
    {
        return $this->belongsToMany('App\Product','product_category','category_id','product_id');//not seller ; add intermediate table and key name
    }
    public function thumbnail()
    {
        return $this->belongsTo('App\Image','image_id','image_id');
    }
    public static function getCategorysWithImage($offset=0){
        $categorys = Category::select(['category_id', 'name', 'description'
            ,'category.image_id','category.created_at','category.updated_at'
            ,'location','file_name'])
            ->leftJoin('image','category.image_id', '=', 'image.image_id')->orderBy('category.category_id','desc')->offset($offset)
            ->limit(20)->get();

        return $categorys;

    }

    public static function getSelectOptions(){
        $rows = Category::all();
        $result = [];
        foreach ($rows as $row) {
            $id       = $row->category_id;
            $name     = $row->name;
            $result[$id] = "$id:$name";
        }
        return $result;
    }
}
