<?php

namespace App\Http\Controllers;

use App\view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // for deleting file
use Illuminate\Support\Facades\Auth;
use App\Seller;
use App\Image; //need to use it to call new Image();
use App\Category;
use Datatables;

use DB;



class SellerController extends Controller
{
    public function index() {
        return view('category.sellerindex');
    }
    public function create() {
        if (Auth::user()->hasRole('administrator')) {
            return view('category.sellercreate');
        }else{
            return redirect()
                ->back()
                ->withFlashDanger("You don't have the permission"); // redirect back
        }
    }
    public function store(Request $request) { // add access control if else return you dont have pẻmission
        if (Auth::user()->hasRole('administrator')) {
            $seller = new Seller();
            //$seller->seller_ID = $request->get('seller_id');
            $seller->name = $request->get('name');
            $seller->address = $request->get('address');
            $seller->email = $request->get('email');
            $seller->phone = $request->get('phone');
            $seller->message_account = $request->get('message_account');
            $seller->type = $request->get('type');
            //$seller->created_at = $request->get('created_at');
            //$seller->updated_at = $request->get('updated_at');
            //$seller->image_id = $request->get('image_id');

            //validate if the upload file is image
            $validatedData = $request->validate([
                'image_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            //get file from input
            $file = $request->file('image_id');
            $image = new Image();
            $image->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $image->location = 'images\seller'; //seller is stored in public/images/seller
            try {

                $image->save();
                //seller the file to it's location on server
                $file->move(public_path($image->location), $image->file_name);

                //image of seller
                $seller->image_id = $image->image_id;
                $seller->save();
                //echo $seller->image_id;
                return redirect()->route('seller.index')->withFlashSuccess('seller is added');

            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withFlashDanger("Seller can't be added. " . $e->getMessage());

            }
        }else{
            return redirect()
                ->back()
                ->withFlashDanger("You don't have the permission"); // redirect back
        }
    }
    public function edit($id) {
        if(Auth::user()->hasRole('administrator')){
            $seller = Seller::with('image')->find($id);
            return view('category.selleredit', ['seller' => $seller]);
        }else{
            $user = Auth::id();
            $seller = Seller::where('user_id',$user)->first();
            if ($seller->seller_id == $id){
                $seller = Seller::with('image')->find($id);
                return view('category.selleredit', ['seller' => $seller]);
            }else{
                return redirect()->back()->withFlashDanger("You dont have the permission");
            }

        }

    }

    public function update(Request $request, $id) { // add access control
        $permit = false;
        if (Auth::user()->hasRole('administrator')) {
            $permit = true;
        }else{
            $user = Auth::id();
            $seller = Seller::where('user_id',$user)->first();
            if ($seller->seller_id == $id){
                $permit = true;
            }else{
                return redirect()
                    ->back()
                    ->withFlashDanger("You dont have the permission " );
            }
        }

        if($permit){
            $seller = Seller::find($id);
            $seller->seller_id = $request->get('seller_id');
            $seller->name = $request->get('name');
            $seller->address = $request->get('address');
            $seller->email = $request->get('email');
            $seller->phone = $request->get('phone');
            $seller->message_account = $request->get('message_account');
            $seller->type = $request->get('type');
            $seller->created_at = $request->get('created_at');
            $seller->updated_at = $request->get('updated_at');
            // $seller->image_id = $request->get('image_id');

            $validateData = $request->validate([
                'image_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


            try {
                // test if image is updated or not
                if ($request->hasFile('image_id')) {
                    $file = $request->file('image_id');
                    $image = new Image();
                    $image->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    $image->location = 'images\seller';

                    $file->move(public_path($image->location), $image->file_name);
                    $image->save();//save new image


                    $old_image = $seller->image_id; // Keep the old image for removing if it exists
                    $seller->image_id = $image->image_id;    //change the image to the new one

                }

                $seller->save();//save the update of category
                if (isset($old_image)) {
                    $old_image = Image::find($old_image);
                    //remove old image from harddisk
                    $file = public_path($old_image->location) . '\\' . $old_image->file_name;
                    if (File::exists($file)) {
                        File::delete($file);
                    }

                    $old_image->delete(); //delete the old image if user add a new one
                }


                return redirect()->route('seller.index')->withFlashSuccess('Seller is updated');
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withFlashDanger("Seller can't be updated. " . $e->getMessage());
            }
        }
    }
    public function destroy($id) {
        if (Auth::user()->hasRole('administrator')) {
            try {

                //to get image of the seller to be deleted. in Seller model, there is function called image
                $image = Seller::find($id)->image;

                //delete seller from database
                $res['seller'] = Seller::destroy($id);
                if ($image) {

                    $file = public_path($image->location) . '\\' . $image->file_name;

                    //test if the image file exists or not
                    if (File::exists($file)) {
                        //delete the file from the folder
                        if (File::delete($file)) {
                            //delete the image of the seller from database;
                            $res['image'] = $image->delete();
                        }
                    }
                }


                if ($res['seller'])
                    return [1];
                else
                    return [0];
            } catch (\Exception $e) {
                return [0, $e->getMessage()];
            }
        }else{
            return [0, "You don't have the permission"];
        }
    }

//    public function getform(){
//        $sellers = seller::all();
//        $views = view::all();
//        return view('sellersign_up', [ 'sellers' => $sellers, 'views' => $views  ]);
//    }

//    public function savesign_up(Request $request){
//
//        $sign_up = new Sign_up();
//        $sign_up->seller_ID = $request->get('seller_id');
//        $sign_up->username_or_email = $request->get('username_or_email');
//        $sign_up-> phone= $request->get('phone');
//        $sign_up-> password= $request->get('password');
//        $sign_up->sign_upDate = date('Y-m-d');
//        try {
//            $sign_up->save();
//            return redirect()->route('seller.sign_up')->withFlashSuccess('sign_up is added');
//        }
//        catch (\Exception $e) {
//            return redirect()
//                ->back()
//                ->withInput($request->all())
//                ->withFlashDanger("Sign_up can't be added. ". $e->getMessage());
//        }
//    }



//    public function showsign_up(){
//        $sellers = seller::all();
//        return view('sellersign_up', [ 'sellers' => $sellers]);
//    }
//
//    public function getsign_up(Request $request){
//        $seller_id = $request->input('seller_id');
//        $sign_ups = Sign_up::getRating($seller_id);
//        if (sizeof($sign_ups) > 0){
//            $stars = 0;
//            $body = "";
//
//            foreach ($sign_ups as $sign_up) {
//                $stars += $sign_up->stars;
//                $body .= <<<EOF
//	<tr>
//
//		<td>$sign_up->username</td>
//		<td>$sign_up->stars</td>
//		<td>$sign_up->sign_upDate</td>
//	</tr>
//EOF;
//            }
//
//            $stars = $stars/sizeof($sign_ups);
//            $html = <<<EOF
//<br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
//<table clas="table">
//	<thead>
//		<tr>
//			<th scope="col">view</th>
//			<th scope="col">stars</th>
//			<th scope="col">sign_upDate</th>
//		</tr>
//	</thead>
//	<tbody>
//	$body
//	</tdbody>
//</table>
//
//EOF;
//            return $html;
//        }else{
//            return "No Sign_up";
//        }
//    }

    public function getseller(){
        if(Auth::user()->hasRole('administrator')) {
            //$sellers = seller::select(['seller_id', 'name', 'address', 'email','phone','instant_massage_account','type','seller.created_at','seller.updated_at','seller.image_id','location','file_name']);
            $sellers = Seller::select(['seller_id', 'name', 'address', 'email', 'phone', 'message_account', 'type', 'seller.image_id', 'seller.created_at', 'seller.updated_at', 'location', 'file_name'])
                ->leftJoin(DB::raw('(select image_id, file_name, location from image) AS temp'), 'seller.image_id', '=', 'temp.image_id');
        }else{
            $user = Auth::id();
            $seller = Seller::where('user_id',$user)->first();
            $sellers = Seller::select(['seller_id', 'name', 'address', 'email', 'phone'
                , 'message_account', 'type', 'seller.image_id', 'seller.created_at'
                , 'seller.updated_at', 'location', 'file_name'])
                ->leftJoin(DB::raw('(select image_id, file_name, location from image) AS temp'), 'seller.image_id', '=', 'temp.image_id')
                ->where('seller.seller_id',$seller->seller_id);
                return Datatables::of($sellers)

                ->addColumn('action', function ($seller) {
                    $html = '<a href="'.route('seller.edit', ['seller_id' => $seller->seller_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                    //$html .= '<a data-id="'.$seller->seller_id.'" class="btn btn-danger btn-sm seller-delete"><i class="far fa-trash-alt"></i></i> Delete</a>&nbsp;&nbsp;&nbsp;' ;

                    return $html;
                })
                ->make(true);
        }
        return Datatables::of($sellers)

            ->addColumn('action', function ($seller) {
                $html = '<a href="'.route('seller.edit', ['seller_id' => $seller->seller_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$seller->seller_id.'" class="btn btn-danger btn-sm seller-delete"><i class="far fa-trash-alt"></i></i> Delete</a>&nbsp;&nbsp;&nbsp;' ;

                return $html;
            })
            ->make(true);
    }
//    //phan moi them
//
//    public function home(){
//
//        $sellers = Seller::getSellersWithImage();
//        return view('frontend.index',['sellers'=>$sellers]);
//    }
//
//    public function getsellermore(Request $request){
//
//        $sellers = Seller::getSellersWithImage($request->get('offset'));
//
//        if(sizeof($sellers) > 0){
//            //$items = array();
//            $html = "";
//
//            foreach ($sellers as $seller){
//                //$html = "";
//                $html .= <<<eot
//				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
//					<!-- Block2 -->
//					<div class="block2">
//						<div class="block2-pic hov-img0">
//eot;
//                if($seller->file_name){
//                    $location = asset($seller->location);
//                    $html .= <<<eot
//
//							<img src="$location/$seller->file_name" alt="IMG-PRODUCT">
//eot;
//                }else{
//                    $location = asset('images/seller');
//                    $html .= <<<eot
//
//							<img src="$location/default.png" alt="IMG-PRODUCT">
//eot;
//                }
//                $location = asset('cozastore');
//                $html .= <<<eot
//							<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
//								Quick View
//							</a>
//						</div>
//
//						<div class="block2-txt flex-w flex-t p-t-14">
//							<div class="block2-txt-child1 flex-col-l ">
//								<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
//									$seller->seller_id
//								</a>
//
//								<span class="stext-105 cl3">
//									$seller->Image
//								</span>
//
//								<span class="stext-105 cl3">
//									$seller->Name
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Address
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Email
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Phone
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Message_account
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Type
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Created_at
//								</span>
//								<span class="stext-105 cl3">
//									$seller->Updated_at
//								</span>
//							</div>
//
// 							<div class="block2-txt-child2 flex-r p-t-3">
//								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
//									<img class="icon-heart1 dis-block trans-04" src="$location/images/icons/icon-heart-01.png" alt="ICON">
//									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="$location/images/icons/icon-heart-02.png" alt="ICON">
//								</a>
//							</div>
// 						</div>
//					</div>
//				</div>
//eot;
//                //$items[] = $html;
//            }
//
//
//            return [1,$html];
//            //return [1,$items];
//        }
//        else
//            return [0];
//    }
}
