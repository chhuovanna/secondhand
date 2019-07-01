<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; //for deleting file
use App\category;
use App\image; //need to use it to call new Image();
use App\seller;
use App\product;
use Datatables;
use DB;


class CategoryController extends Controller
{
    public function index() {
        return view('category.categoryindex');
    }
    public function create() {
        return view('category.categorycreate');
    }
    public function store(Request $request) {
        $category = new Category();
        //$category->category_id = $request->get('category_id');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        //$category->image_id = $request->get('image_id');

        //validate if the upload file is image
        $validateData = $request->validate([
            'image_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        //get file from input
        $file = $request->file('image_id');
        $image = new Image();
        $image->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
        $image->location = 'images\category'; //category is stored in public/images/category

        try {
            $image->save();
            //category the file to it's location on server
            $file->move(public_path($image->location),$image->file_name);

            //image of category
            $category->image_id = $image->image_id;
            $category->save();
            //echo $category->image_id;

            return redirect()->route('category.index')->withFlashSuccess('Category is added');

        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Category can't be added. ". $e->getMessage());

        }
    }
    public function show($id) {
        echo 'show';
    }
    public function edit($id) {

        //we dont have image function in model category, we only have thumbnail()
        $category = Category::with('thumbnail')->find($id);
        return view('category.categoryedit',['category'=>$category]);
    }
    public function update(Request $request, $id) {
        $category= Category::find($id);
        $category->category_id = $request->get('category_id');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        //$category->image_id = $request->get('image_id');
        $category->created_at = $request->get('created_at');
        $category->updated_at = $request->get('updated_at');

        $validateData = $request->validate([
            'image_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


        try{
            // test if image is updated or not
            if($request->hasFile('image_id')){
                $file = $request->file('image_id');
                $image = new Image();
                $image->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
                $image->location = 'images\category';

                $file->move(public_path($image->location),$image->file_name);
                $image->save();//save new image


                $old_image = $category->image_id; // Keep the old image for removing if it exists
                $category->image_id = $image->image_id;	//change the image to the new one


            }
            $category->save(); //save the update of seller
            if(isset($old_image)){
                $old_image = Image::find($old_image);
                //remove old image from harddisk
                $file = public_path($old_image->location).'\\'.$old_image->file_name;
                if ( File::exists($file)) {
                    File::delete($file);
                }

                $old_image->delete(); //delete the old image if user add a new one
            }

               return redirect()->route('category.index')->withFlashSuccess('Category is updated');
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Category can't be updated. ". $e->getMessage());
        }

    }


    public function destroy($id) {

        try{
            //to get image of the category to be deleted. in Category model, there is function called image
            $image = Category::find($id)->thumbnail;

            //delete category from database
            $res['category'] = Category::destroy($id);
            if ($image) {

                $file = public_path($image->location) . '\\' . $image->file_name;


                //test if the image file exists or not
                if (File::exists($file)) {
                    //delete the file from the folder
                    if (File::delete($file)) {
                        //delete the image of the category from database;
                        $res['image'] = $image->delete();
                    }
                }
            }


            if ($res['category'] )
                return [1];
            else
                return [0];
        }catch(\Exception $e){
            return [0,$e->getMessage()];
        }


    }



    public function getform(){
        $category = category::all();
        $sellers = seller::all();
        return view('categoryrate', [ 'category' => $category, 'sellers' => $sellers  ]);
    }

//    public function saveseller_signup(Request $request){
//
//        $seller_signup = new product();
//        $seller_signup->seller_signup_ID = $request->get('seller_signup_ID');
//        $seller_signup->name = $request->get('name');
//        $seller_signup->address = $request->get('address');
//        $seller_signup->email = $request->get('email');
//        $seller_signup->phone = $request->get('phone');
//        $seller_signup->instant_massage_account = $request->get('instant_message_account');
//        $seller_signup->type = $request->get('type');
//        $seller_signup->image = $request->get('image');
//        $seller_signup->created_at = $request->get('created_at');
//        $seller_signup->updated_at = $request->get('updated_at');
//        $seller_signup->image = $request->get('image');
//        $seller_signup->sellerDate = date('Y-m-d');
//        try {
//            $seller_signup->save();
//            return redirect()->route('category.rate')->withFlashSuccess('Seller is added');
//        }
//        catch (\Exception $e) {
//            return redirect()
//                ->back()
//                ->withInput($request->all())
//                ->withFlashDanger("Seller can't be added. ". $e->getMessage());
//        }
//    }


    public function showrate(){
        $category = category::all();
        return view('categoryshowrate', [ 'category' => $category]);
    }

//    public function getseller_signup(Request $request){
//        $add = $request->input('add');
//        $sellers_signup = seller::getSeller_signup($add);
//        if (sizeof($sellers_signup) > 0){
//            $stars = 0;
//            $body = "";
//
//            foreach ($sellers_signup as $seller_signup) {
//                $stars += $seller_signup->stars;
//                $body .= <<<EOF
//	<tr>
//
//		<td>$seller_signup->name</td>
//		<td>$seller_signup->stars</td>
//		<td>$seller_signup->sellerDate</td>
//	</tr>
//EOF;
//            }

//            $stars = $stars/sizeof($sellers_signup);
//            $html = <<<EOF
//<br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
//<table clas="table">
//	<thead>
//		<tr>
//			<th scope="col">seller</th>
//			<th scope="col">stars</th>
//			<th scope="col">sellerDate</th>
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
//            return "No Seller_signup";
//        }
//    }

    public function getcategory(){
        $categorys = Category::select(['category_id', 'name', 'description'
            ,'category.image_id','category.created_at','category.updated_at'
            ,'location','file_name'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) AS temp'),'category.image_id', '=', 'temp.image_id')
        ;///need to use subquery with DB::raw to avoid ambigous of created_at and updated_at when search

        return Datatables::of($categorys)
            ->addColumn('action', function ($category) {
                $html = '<a href="'.route('category.edit', ['category_id' => $category->category_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$category->category_id.'" class="btn btn-danger btn-sm category-delete"><i class="far fa-trash-alt"></i></i> Delete</a>&nbsp;&nbsp;&nbsp;' ;
                $html .= '<a data-id="'.$category->category_id.'"  class="btn btn-info btn-sm category-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;
                return $html;
            })
            ->make(true);
    }

    //phan moi them

    public function home(){

        $categorys = Category::getCategorysWithImage();
        return view('frontend.index',['categorys'=>$categorys]);
    }

    public function getcategorymore(Request $request){

        $categorys = Category::getCategorysWithImage($request->get('offset'));

        if(sizeof($categorys) > 0){
            //$items = array();
            $html = "";

            foreach ($categorys as $category){
                //$html = "";
                $html .= <<<eot
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
eot;
                if($category->file_name){
                    $location = asset($category->location);
                    $html .= <<<eot
							
							<img src="$location/$category->file_name" alt="IMG-PRODUCT">
eot;
                }else{
                    $location = asset('images/category');
                    $html .= <<<eot

							<img src="$location/default.png" alt="IMG-PRODUCT">
eot;
                }
                $location = asset('cozastore');
                $html .= <<<eot
							<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
								Quick View
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									$category->category_id
								</a>

								<span class="stext-105 cl3">
									$category->Image
								</span>

								<span class="stext-105 cl3">
									$category->Name
								</span>
								<span class="stext-105 cl3">
									$category->Description
								</span>
								<span class="stext-105 cl3">
									$category->Created_at
								</span>
								<span class="stext-105 cl3">
									$category->Updated_at
								</span>
							</div>

 							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
									<img class="icon-heart1 dis-block trans-04" src="$location/images/icons/icon-heart-01.png" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="$location/images/icons/icon-heart-02.png" alt="ICON">
								</a>
							</div>
 						</div>
					</div>
				</div>
eot;
                //$items[] = $html;
            }


            return [1,$html];
            //return [1,$items];
        }
        else
            return [0];
    }


}
