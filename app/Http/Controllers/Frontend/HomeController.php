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
        $about = About::first();

        if (Auth::check()){
            $products = Product::getProductsWithThumbnailCategory(0,0,0,1);
        }else{
            $products = Product::getProductsWithThumbnailCategory(0,0,0,0);
        }
        $totalSize = Product::getSize(0,0);
        return view('frontend.index', ['categories' => $categories, 'products' => $products , 'about' => $about, 'totalSize' =>$totalSize]);
    } 

   

    public function shop(){
            $sellers = Seller::getSellersWithImage();
            $categories = Category::all();
            $about = About::first();
            $totalSize = Seller::count();
        return view('frontend.shop', ['sellers' => $sellers, 'categories' => $categories, 'about' => $about , 'totalSize' => $totalSize]);
        //return view('frontend.shop');
    }


    public function features(){
        $categories = Category::all();
        $about = About::first();
        $totalSize = Product::getSize(0,1);

        if(Auth::check()){
            $products = Product::getProductsWithThumbnailCategory(0,0,1,1);

        }else{
            $products = Product::getProductsWithThumbnailCategory(0,0,1,0);

        }

        return view('frontend.features', ['categories' => $categories, 'products' => $products
            , 'about' => $about , 'totalSize' => $totalSize]);

    }

    public function about(){
        $categories = Category::all();
        $about = About::first();
        if (!$about){

            $about = new About();
            $about->phone = '012 123 456';
            $about->email = 'shop.gmail.com';
            $about->website = 'www.shop.com';
            $about->address = '#12, Happy Ave. Phnom Penh Cambodia';
            $about->save();

        }
        return view('frontend.about' , ['about' => $about, 'categories' => $categories]);



    }

    public function contact(){
        $categories = Category::all();
        $about = About::first();
        return view('frontend.contact',[ 'categories' => $categories, 'about' => $about]);

    }

}
