<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use App\Product;
use App\Category;
use App\Seller;
use App\About;
use PharIo\Manifest\Author;

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
        $categories = Category::all();

        if (Auth::check()){
            $products = Product::getProductsWithThumbnailCategoryLike();
        }else{
            $products = Product::getProductsWithThumbnailCategory();
        }
        return view('frontend.index2', ['categories' => $categories, 'products' => $products]);
    }

    public function test()
    {
    	$categories = Category::get();
    	$products = Product::with('thumbnail')->with('category')->skip(0)->take(10)->get();
        return view('frontend.index2',['products' => $products, 'categories' => $categories]);
    }



    public function shop(){
            $sellers = Seller::getSellersWithImage();

        return view('frontend.shop', ['sellers' => $sellers]);
        //return view('frontend.shop');
    }


    public function features(){
        $categories = Category::all();
        $products = Product::getProductsWithThumbnailCategoryLikeFeatured();

        return view('frontend.features', ['categories' => $categories, 'products' => $products]);

    }

    public function about(){

        $about = About::first();
        if (!$about){

            $about = new About();
            $about->phone = '012 123 456';
            $about->email = 'secondhand.gmail.com';
            $about->website = 'www.secondhand.com';
            $about->address = '#12, Happy Ave. Phnom Penh Cambodia';
            $about->save();

        }
        return view('frontend.about' , ['about' => $about]);



    }

    public function contact(){

        return view('frontend.contact');

    }

}
