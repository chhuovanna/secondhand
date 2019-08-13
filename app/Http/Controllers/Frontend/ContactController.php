<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Message;
use Illuminate\Http\Request;
/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.contact');
    }

    public function shop()
    {
        return view('frontend.shop');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        //Mail::send(new SendContact($request));
        $message = new Message();
        $message->full_name = $request->get('name');
        $message->email = $request->get('email');
        $message->phone = $request->get('phone');
        $message->message = $request->get('message');
        $message->status = 0;
        

        $message->save();
        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }

    public function store(Request $request){
        $message = new Message();
        $message->full_name = $request->get('');
        $message->save();
        return redirect(url('/'));
    }


}
