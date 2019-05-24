<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\seller;
use App\image; 
use Datatables;
use DB;
//use App\category;


class SellerController extends Controller
{
    public function index() {
        return view('category.sellerindex');
    }
    public function create() {
        return view('category.sellercreate');
    }
    public function store(Request $request) {
        $seller = new Seller();
        //$seller->seller_ID = $request->get('seller_id');
        $seller->name = $request->get('name');
        $seller->address = $request->get('address');
        $seller->email = $request->get('email');
        $seller->phone = $request->get('phone');
        $seller->instant_massage_account = $request->get('instant_massage_account');
        $seller->type = $request->get('type');
        //$seller->created_at = $request->get('created_at');
        //$seller->updated_at = $request->get('updated_at');
        //$seller->image_id = $request->get('image_id');

        //validate if the upload file is image
        $validatedData = $request->validate([
                            'image_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);
        try {
            
            //move file to resource/images
            $file = $request->file('image_id');
            $imageName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);

            //save image to database
            $image = new Image();
            $image->location = public_path('images');
            $image->file_name = $imageName;
            $image->save();

            //assign new image to seller and save seller to database
            $seller->image_id = $image->image_id;
            $seller->save();

            return redirect()->route('seller.index')->withFlashSuccess('seller is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Seller can't be added. ". $e->getMessage());

        }
    }
    public function view($id) {
        echo 'view';
    }
    public function sign_up($id) {
        echo 'sign_up';
    }
    public function edit($id) {
        $seller = Seller::find($id);
        return view('selleredit',['seller'=>$seller]);
    }
    public function update(Request $request, $id) {
        $seller = Seller::find($id);
        $seller->seller_ID = $request->get('seller_id');
        $seller->name = $request->get('name');
        $seller->address = $request->get('address');
        $seller->email = $request->get('email');
        $seller->phone = $request->get('phone');
        $seller->instant_massage_account = $request->get('instant_massage_account');
        $seller->type = $request->get('type');
        $seller->created_at = $request->get('created_at');
        $seller->updated_at = $request->get('updated_at');
        $seller->image_id = $request->get('image_id');

        try{
            $seller->save();
            return redirect()->route('seller.index')->withFlashSuccess('Seller is updated');
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Seller can't be updated. ". $e->getMessage());
        }

    }
    public function destroy($id) {

        try{
            $res = seller::destroy($id);
            if ($res)
                return 1;
            else
                return 0;
        }catch(\Exception $e){
            return 0;
        }

    }

    public function getform(){
        $sellers = seller::all();
        $views = view::all();
        return view('sellersign_up', [ 'sellers' => $sellers, 'views' => $views  ]);
    }

    public function savesign_up(Request $request){

        $sign_up = new Sign_up();
        $sign_up->seller_ID = $request->get('seller_id');
        $sign_up->username_or_email = $request->get('username_or_email');
        $sign_up-> phone= $request->get('phone');
        $sign_up-> password= $request->get('password');
        $sign_up->sign_upDate = date('Y-m-d');
        try {
            $sign_up->save();
            return redirect()->route('seller.sign_up')->withFlashSuccess('sign_up is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Sign_up can't be added. ". $e->getMessage());
        }
    }



    public function showsign_up(){
        $sellers = seller::all();
        return view('sellersign_up', [ 'sellers' => $sellers]);
    }

    public function getsign_up(Request $request){
        $seller_id = $request->input('seller_id');
        $sign_ups = Sign_up::getRating($seller_id);
        if (sizeof($sign_ups) > 0){
            $stars = 0;
            $body = "";

            foreach ($sign_ups as $sign_up) {
                $stars += $sign_up->stars;
                $body .= <<<EOF
	<tr>
		
		<td>$sign_up->username</td>
		<td>$sign_up->stars</td>
		<td>$sign_up->sign_upDate</td>
	</tr>
EOF;
            }

            $stars = $stars/sizeof($sign_ups);
            $html = <<<EOF
<br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
<table clas="table">
	<thead>
		<tr>
			<th scope="col">view</th>
			<th scope="col">stars</th>
			<th scope="col">sign_upDate</th>
		</tr>
	</thead>
	<tbody>
	$body
	</tdbody>
</table>

EOF;
            return $html;
        }else{
            return "No Sign_up";
        }
    }

    public function getseller(){
        $sellers = seller::select(['seller_id', 'name', 'address', 'email','phone','instant_massage_account','type','seller.created_at','seller.updated_at','seller.image_id','location','file_name'])->join('image','seller.image_id','=','image.image_id')->get();

        return Datatables::of($sellers)
            ->addColumn('action', function ($seller) {
                $html = '<a href="'.route('seller.edit', ['seller_id' => $seller->seller_ID]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$seller->seller_ID.'" class="btn btn-danger btn-sm seller-delete"><i class="far fa-trash-alt"></i></i> Delete</a>' ;
                return $html;
            })
            ->make(true);
    }


}
