<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeletecategoryController extends Controller
{
    //
    public function deletecategory(){
        return view('category.deletecategory');
    }
}
