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
        $messages = Message::select(['message_id', 'full_name','email','phone', 'message','status','message.created_at','message.updated_at'])->get();

       // if(Auth::user()->hasRole('administrator')){ //is admin, but need to modify
            //return Datatables::of($messages)
            return Datatables::of($messages)
             
                 ->addColumn('action', function ($message) {
                                                $html = '<a href="'.route('message.markread', ['id' => $message->message_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                                                

                                                return $html;
                                            })
                ->make(true);
       // }
    }

    public function markread(Request $request){
        $message_id = $request->get('message_id');
        $message = Message::find($message_id);
        $message->status = 1;
        $message->save();
    }

}
