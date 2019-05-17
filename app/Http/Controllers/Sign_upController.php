<?php

namespace App\Http\Controllers;

use App\seller;
use Illuminate\Http\Request;

class Sign_upController extends Controller
{
    public function index() {
        echo 'index';
    }
    public function create() {

        $sellers = seller::all();
        $views = view::all();
        return view('sign_upcreate',['sellers'=>$sellers,'views'=>$views]);
    }
    public function store(Request $request) {
        $sign_up = new Sign-up();
        $sign_up->seller_id = $request->get('seller_id');
        $sign_up->username_or_email = $request->get('username_or_email');
        $sign_up->phone = $request->get('phone');
        $sign_up->password = $request->get('password');
        $sign_up->sign_upDate = now();


        try {
            $sign_up->save();
            return redirect()->route('sign_up.index')->withFlashSuccess('Seller is added');
        }
        catch (\Exception $e) {
            // print_r($request->all());
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Seller can't sign_up. ". $e->getMessage());

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
