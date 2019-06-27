<?php

namespace App\Http\Controllers;

use App\seller;
use App\view;
use Illuminate\Http\Request;

class Sign_upController extends Controller
{
    public function signup()
    {
        return view ('category.signup');
    }
    public  function postSignup(Request $request){

    }
}