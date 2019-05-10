<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\Category;


class ProductController extends Controller
{
    public function index() {
        echo 'index';
    }
    public function create() {
        $categorys = category::all();
        $sellers = seller::all();
        return view('productcreate',['categorys'=>$categorys,'sellers'=>$sellers]);
    }
    public function store(Request $request) {
        $product = new Product();
        $product->product_id = $request->get('product_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        $product->created_at = $request->get('created_at');
        $product->updated_at = $request->get('updated_at');
        $product->post_id = $request->get('post_id');
        $product->image_id = $request->get('image_id');
        $product->ratingDate = now();
        try {
            $product->save();
            return redirect()->route('product.index')->withFlashSuccess('Category is added');
        }
        catch (\Exception $e) {
            // print_r($request->all());
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("can't rate. ". $e->getMessage());
        }
    }
    public function show($id) {
        echo ' show';
    }
    public function edit($id) {
        echo 'save edit';
    }
    public function update(Request $request, $id) {
        echo 'update';
    }
    public function destroy($id) {
        echo 'destroy';
    }
}
