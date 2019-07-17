<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\product;
use App\category;
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
        return view('frontend.index');
    }

    public function test()
    {
    	$categories = Category::get();
    	$products = Product::with('thumbnail')->with('category')->skip(0)->take(10)->get();
        return view('frontend.index2',['products' => $products, 'categories' => $categories]);
    }


}
