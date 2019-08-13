<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Datatables;
use DB;
use App\Message;


class MessageController extends Controller
{
    public function index() {

        if(Auth::user()->hasRole('administrator')){ //is admin, but need to modify
            return view('category.messageindex');
        }else{
            return redirect()->back()->withFlashDanger("You don't have the permission");
        }
    }

    public function getmessage(){

        // to be change
        $messages = Message::select(['category_id', 'name', 'description'
            ,'category.image_id','category.created_at','category.updated_at'
            ,'location','file_name']);

        if(Auth::user()->hasRole('administrator')){ //is admin, but need to modify
            return Datatables::of($categorys)
                ->make(true);
        }
    }

}
