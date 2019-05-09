<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\Category;
use App\Product;

class SellerController extends Controller

{
    public function index() {
        echo 'index';
    }
    public function create() {

        $categorys = category::all();
        $products = product::all();
        return view('sellercreate',['categorys'=>$categorys,'products'=>$products]);
    }
    public function store(Request $request) {
        $seller = new Seller();
        $seller->id = $request->get('id');
        $seller->name = $request->get('name');
        $seller->address = $request->get('address');
        $seller->email = $request->get('email');
        $seller->phone = $request->get('phone');
        $seller->instant_message_account = $request->get('instant_message_account');
        $seller->type = $request->get('type');
        $seller->image = $request->get('image');
        $seller->created_at = $request->get('created_at');
        $seller->updated_at = $request->get('updated_at');
        $seller->ratingDate = now();



        try {
            $seller->save();
            return redirect()->route('seller.index')->withFlashSuccess('Category is added');
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
