<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // for deleting file
use Illuminate\Support\Facades\Auth;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Seller;
use App\Image; //need to use it to call new Image();
use Datatables;


use DB;



class SellerController extends Controller
{


    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index() {
        return view('scrud.sellerindex');
    }
    public function create() {
        if (Auth::user()->hasRole('administrator')) {
            return view('scrud.sellercreate');
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
            $image->location = 'images/seller'; //seller is stored in public/images/seller
            try {

                $image->save();
                //seller the file to it's location on server
                $file->move(public_path($image->location), $image->file_name);

                //image of seller
                $seller->image_id = $image->image_id;

                //create new user for selelr

                $test = array(
                    'first_name'        => $seller->name,
                    'last_name'         => "",
                    'email'             => $seller->email,
                    'password'          => $seller->email,
                    'backend'         => 1
                );


                $user = $this->userRepository->create($test);
                if ($user){
                    $user->assignRole('executive');
                }

                $seller->user_id = $user->id;
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
            return view('scrud.selleredit', ['seller' => $seller]);
        }else{
            $user = Auth::id();
            $seller = Seller::where('user_id',$user)->first();
            if ($seller->seller_id == $id){
                $seller = Seller::with('image')->find($id);
                return view('scrud.selleredit', ['seller' => $seller]);
            }else{
                return redirect()->back()->withFlashDanger("You dont have the permission");
            }

        }

    }

    public function update(Request $request, $id) { // add access control
        $permit = false;
        $changeemail = false;
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
            if ($seller->email != $request->get('email')){
                $changeemail = true;
            }
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
                    $image->location = 'images/seller';

                    $file->move(public_path($image->location), $image->file_name);
                    $image->save();//save new image


                    $old_image = $seller->image_id; // Keep the old image for removing if it exists
                    $seller->image_id = $image->image_id;    //change the image to the new one

                }

                $seller->save();//save the update of category
                if($changeemail){
                    DB::update('update users set email = ? where id = ?', [$seller->email,$seller->user_id]);
                }
                if (isset($old_image)) {
                    $old_image = Image::find($old_image);
                    //remove old image from harddisk
                    $file = public_path($old_image->location) . '/' . $old_image->file_name;
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
//for shop
     public function getsellermore(Request $request){
        $sellers = Seller::getSellersWithImage($request->get('offset'));
        if(sizeof($sellers) > 0){
            $items = array();
            foreach ($sellers as $seller){
                $html = <<<eot
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item" data-seller_id="$seller->seller_id">
                    <!-- Block2 -->
                    <div class="block2" style="height:100%">
                        <div class="block2-pic hov-img0" >
eot;
                if($seller->file_name){
                    $location = asset($seller->location);
                    $html .= <<<eot
                            <img src="$location/$seller->file_name" alt="IMG-SELLER">
eot;
                }else{
                    $location = asset('images/thumbnail');
                    $html .= <<<eot
                            <img src="$location/default.png" alt="IMG-SELLER">
eot;
                }
                $location = asset('cozastore');
                $url = route('frontend.product.showbyshop', $seller->seller_id);
                $html .= <<<eot
                            <a href="$url" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-product-shop" data-seller_id="$seller->seller_id">
                                View Store
                            </a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                            <span class="stext-105 cl3 ">
                                    <b class="sname">Name: $seller->name</b>
                                </span>


                                <span class="stext-105 cl3 address">
                                    <strong>Address: </strong>$seller->address
                                </span>
                                <span class="stext-105 cl3 email">
                                    <strong>Email: </strong>$seller->email
                                </span>
                                <span class="stext-105 cl3 phone">
                                    <strong>Phone: </strong>$seller->phone
                                </span>
                                <span class="stext-105 cl3 message_account">
                                    <strong>Message Account: </strong>$seller->message_account
                                </span>
                                <span class="stext-105 cl3 type">
                                    <strong>Type: </strong>$seller->type
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
eot;
                $items[] = $html;
            }
            //return [1,$html];
            $totalSize = Seller::count();
            return [1,$totalSize,$items];
        }
        else{
            $totalSize = Seller::count();
            return [0,$totalSize];

        }

    }

}
