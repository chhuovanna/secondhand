<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\product;
use App\category;
use App\seller;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::getProductsWithThumbnailCategory();
        $categories = Category::all();
        return view('frontend.index2', ['categories' => $categories, 'products' => $products]);
    }

    public function test()
    {
    	$categories = Category::get();
    	$products = Product::with('thumbnail')->with('category')->skip(0)->take(10)->get();
        return view('frontend.index2',['products' => $products, 'categories' => $categories]);
    }



    public function shop(){
            $sellers = Seller::getSellersWithThumbnailCategory();
            $categories = Category::all();
        return view('frontend.shop', ['categories' => $categories, 'sellers' => $sellers]);
        //return view('frontend.shop');
    }

    
    public function features(){
        
        return view('frontend.features');
    }

    public function about(){
    
        
        return view('frontend.about');
        
    }

    public function contact(){
        
        return view('frontend.contact');
        
    }

}
