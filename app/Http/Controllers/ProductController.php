<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;

class ProductController extends Controller
{
    public function index() {
        echo "index";
    }
    public function create() {
        return view('productcreate');
    }
    public function store(Request $request) {
        $product = new Product();
        $product->ID = $request->get('id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->image = $request->get('image');
        $product->categories = $request->get('categories');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        $product->created_at = $request->get('created_at');
        $product->updated_at = $request->get('updated_at');
        try {
            $product->save();
            return redirect()->route('product.index')->withFlashSuccess('product is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Product can't be added. ". $e->getMessage());
        }
    }
    public function show($id) {
        echo "show";
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
