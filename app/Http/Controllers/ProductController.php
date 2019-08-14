<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Image;
use App\Category;
use App\Post;
use App\Seller;
use Datatables;
use DB;




class ProductController extends Controller
{
    protected $productwithpost;

    public function index()
    {

        return view('category.productindex');
    }

    public function create()
    {
        $categories = Category::getSelectOptions();
        return view('category.productcreate', ['categories' => $categories]);
    }

    public function createwitholdpost($post_id)
    {
        $categories = Category::getSelectOptions();
        $product = Product::where('post_id', '=', $post_id)->first();

        return view('category.productcreate', ['categories' => $categories
            , 'post_id' => $post_id
            , 'pickup_time' => $product->pickup_time
            , 'pickup_address' => $product->pickup_address]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        //$product->product_id = $request->get('product_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        //$product->created_at = $request->get('created_at');
        //$product->updated_at = $request->get('updated_at');
        //$product->post_id = $request->get('post_id');
        //$product->image_id = $request->get('image_id');
        $validateData = $request->validate([
            'thumbnail_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photos[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        //get file from input
        $file = $request->file('thumbnail_id');
        $thumbnail = new Image();
        $thumbnail->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
        $thumbnail->location = 'images\thumbnail'; //thumbnail is stored in public/images/thumbnail

        try {
            $thumbnail->save();
            //product the file to it's location on server
            $file->move(public_path($thumbnail->location), $thumbnail->file_name);

            //thumbnail of product
            $product->image_id = $thumbnail->image_id;
            if ($request->get('post_id') !== null) {
                $product->post_id = $request->get('post_id');
            } else {
                $user_id = Auth::id();
                $seller = Seller::where('user_id', '=', $user_id)->first();
                $post = new Post();
                $post->seller_id = $seller->seller_id;
                $post->save();
                $product->post_id = $post->post_id;
            }
            //add seller is missing
            $product->save();


            //test if user has upload other photos or not
            if ($request->hasFile('photos')) {
                //get the array of photos
                $photos = $request->file('photos');
                foreach ($photos as $key => $file) {
                    $photo = new Image();
                    $photo->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    //photos are stored on server in folder public/images/photos
                    $photo->location = 'images\photos';

                    //photo belongs to product
                    $photo->product_id = $product->product_id; //not (id) product_id
                    $photo->save();
                    $file->move(public_path($photo->location), $photo->file_name);
                }
            }
            $category = $request->get('category_id');
            if (sizeof($category) > 0) {
                $product->category()->attach($category);
            }


            //dd($category);


            if ($request->get('add_more') == 1) {


                return redirect()->route('product.create.with.oldpost', ['post_id' => $product->post_id])->withFlashSuccess('Product is added. You wish you add more product in the same post. We suggest the same pickup time and date');
            }
            return redirect()->route('product.index')->withFlashSuccess('Product is added');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Product can't be added. " . $e->getMessage());
        }
    }

    public function show($id)
    {
        echo 'showlalal' . $id;
    }

    public function edit($id)
    {

        $product = Product::with('thumbnail')->with('photo')->with('post')->find($id);
        $post = $product->post;
        $seller = Seller::find($post->seller_id);

        $categories = Category::getSelectOptions();


        if (Auth::user()->hasRole('administrator')) {
            return view('category.productedit', ['categories' => $categories, 'product' => $product]);
        } elseif ($seller->user_id == Auth::id()) {
            return view('category.productedit', ['categories' => $categories, 'product' => $product]);
        } else {
            return redirect()->back()->withFlashDanger("You don't have the permission");
        }

    }

    public function update(Request $request, $id)
    {
        $product = Product::with('thumbnail')->with('photo')->with('post')->find($id);

        $permit = false;
        if (Auth::user()->hasRole('administrator')) {
            $permit = true;
        } else {
            $post = $product->post;
            $seller = Seller::find($post->seller_id);
           // $user = Auth::id();
            //$seller = Seller::where('user_id', $user)->first();
            if ($seller->user_id == Auth::id()) {
                $permit = true;
            } else {
                return redirect()
                    ->back()
                    ->withFlashDanger("You dont have the permission ");
            }
        }
        if ($permit) {
            //$product = Product::find($id);
            //$product->product_id = $request->get('product_id');
            $product->name = $request->get('name');
            $product->price = $request->get('price');
            $product->description = $request->get('description');
            //$product->view_number = $request->get('view_number');
            $product->status = $request->get('status');
            $product->pickup_address = $request->get('pickup_address');
            $product->pickup_time = $request->get('pickup_time');
            //$product->created_at = $request->get('created_at');
            //$product->updated_at = $request->get('updated_at');
            //$product->post_id = $request->get('post_id');
            //$product->image_id = $request->get('image_id');

            $validateData = $request->validate([
                'thumbnail_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                , 'photos[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


            try {
                // test if thumbnail is updated or not
                if ($request->hasFile('thumbnail_id')) {
                    $file = $request->file('thumbnail_id');
                    $thumbnail = new Image();
                    $thumbnail->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    $thumbnail->location = 'images\thumbnail';

                    $file->move(public_path($thumbnail->location), $thumbnail->file_name);
                    $thumbnail->save();//save new thumbnail


                    $old_thumbnail = $product->thumbnail; // Keep the old thumbnail for removing if it exists
                    $product->image_id = $thumbnail->image_id;    //change the thumbnail to the new one


                }


                $product->save(); //save the update of product

                if (isset($old_thumbnail)) {
                    //remove old thumbnail from harddisk
                    $file = public_path($old_thumbnail->location) . '\\' . $old_thumbnail->file_name;
                    if (File::exists($file)) {
                        File::delete($file);
                    }

                    $old_thumbnail->delete(); //delete the old thumbnail if user add a new one
                }


                $db_old_photos = $product->photo;//get old photos from db
                if ($db_old_photos) {// if there is any old photos in db

                    $old_photos = $request->get('old_photos'); //get the list of old photos after use update

                    //            print_r($old_photos);
                    foreach ($db_old_photos as $db_old_photo) {

                        //test if user has deleted all old photos, we remove it from db and hard disk
                        //or test if some old photos are deleted by user, we remove it form db and hard disk
                        if (!$old_photos or ($old_photos && !in_array($db_old_photo->image_id, $old_photos))) {

                            if ($db_old_photo->delete()) {
                                //remove old thumbnail from harddisk
                                $file = public_path($db_old_photo->location) . '\\' . $db_old_photo->file_name;
                                if (File::exists($file)) {
                                    File::delete($file);
                                }
                            }
                        }
                    }
                }


                //test if user has upload other photos or not
                if ($request->hasFile('photos')) {


                    //get the array of photos
                    $photos = $request->file('photos');


                    foreach ($photos as $file) {
                        $photo = new Image();
                        $photo->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();

                        //photos are stored on server in folder public/images/photos
                        $photo->location = 'images\photos';

                        //photo belongs to product
                        $photo->product_id = $request->get('product_id');
                        $photo->save();
                        $file->move(public_path($photo->location), $photo->file_name);


                    }
                }
                $category = $request->get('category_id');
                $old_category = $product->category;
                $array_old_category = $old_category->pluck('category_id')->toArray();
                print_r($array_old_category);

                foreach ($old_category as $ele){
                    if (!in_array ( $ele->category_id, $category )){
                        $product->category()->detach($ele->category_id);
                    }
                }

                foreach ($category as $ele){
                    if (!in_array ( $ele, $array_old_category )){
                        $product->category()->attach($ele);
                    }
                }


                return redirect()->route('product.index')->withFlashSuccess('product is updated');
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withFlashDanger("Product can't be updated. " . $e->getMessage());
            }
        }
    }

    public function destroy($id){
                $product = Product::with('thumbnail')->with('photo')->with('post')->find($id);
                $permit = false;
                if (Auth::user()->hasRole('administrator')) {
                    $permit = false;
                } else {
                    $post = $product->post;
                    $seller = Seller::find($post->seller_id);
                    // $user = Auth::id();
                    //$seller = Seller::where('user_id', $user)->first();
                    if ($seller->user_id == Auth::id()) {
                        $permit = true;
                    } else {
                        return redirect()
                            ->back()
                            ->withFlashDanger("You dont have the permission ");
                    }
                }
                if ($permit) {
                try {

                    //to get the array of photos of the product
                    $product = Product::with('photo')->with('thumbnail')->find($id);
                    $photos = $product->photo;
                    $res['photos'] = true;
                    if ($photos) {
                        foreach ($photos as $photo) {
                            $file = public_path($photo->location) . '\\' . $photo->file_name;
                            if (File::exists($file)) {

                                if (File::delete($file)) {//delete the file from the folder
                                    $res['photos'] = $res['photos'] && $photo->delete(); //delete the file from database
                                }

                            }
                        }

                    }


                    //to get thumbnail of the product to be deleted. in product model, there is function called thumbnail
                    $thumbnail = $product->thumbnail;

                    $post = $product->post;

                    //delete product from database
                    $res['product'] = Product::destroy($id);

                    $otherproduct = $post->product;
                    if (sizeof($otherproduct) == 0) {
                        $post->delete();
                    }

                    if ($thumbnail) {
                        $file = $file = public_path($thumbnail->location) . '\\' . $thumbnail->file_name;
                        //test if the thumbnail file exists or not
                        if (File::exists($file)) {
                            //delete the file from the folder
                            if (File::delete($file)) {
                                //delete the thumbnail of the product from database;
                                $res['thumbnail'] = $thumbnail->delete();
                            }
                        }
                    }


                    if ($res['product'])
                        return [1];
                    else
                        return [0];
                } catch (\Exception $e) {
                    return [0, $e->getMessage()];
                }
            }
}



//    public function getform(){
//        $products = product::all();
//        //$reviewers = reviewer::all();//???
//        return view('productrate', [ 'products' => $products  ]);
//    }
    // public function saverating(Request $request){

    //     $rating = new Rating();
    //     $rating->product_id = $request->get('product_id');
    //     $rating->rID = $request->get('rid');
    //     $rating->stars = $request->get('stars');
    //     $rating->ratingDate = date('Y-m-d');
    //     try {
    //         $rating->save();
    //         return redirect()->route('product.rate')->withFlashSuccess('Rating is added');
    //     }
    //     catch (\Exception $e) {
    //         return redirect()
    //         ->back()
    //         ->withInput($request->all())
    //         ->withFlashDanger("Rating can't be added. ". $e->getMessage());
    //     }
    // }





//             return $html;
//         }else{
//             return "No Rating";
//         }}public function showrate(){
//         $products = product::all();
//         return view('productshowrate', [ 'products' => $products]);
//     }
//     public function getrating(Request $request){
//         $Product_id = $request->input('product_id');
//         $ratings = Rating::getRating($product_id);
//         if (sizeof($ratings) > 0){
//             $stars = 0;
//             $body = "";
//             foreach ($ratings as $rating) {
//                 $stars += $rating->stars;
//                 $body .= <<<EOF
//     <tr>

//         <td>$rating->name</td>
//         <td>$rating->stars</td>
//         <td>$rating->ratingDate</td>
//     </tr>
// EOF;
//             }
//             $stars = $stars/sizeof($ratings);
//             $html = <<<EOF
// <br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
// <table clas="table">
//     <thead>
//         <tr>
//             <th scope="col">reviewer</th>
//             <th scope="col">stars</th>
//             <th scope="col">ratingDate</th>
//         </tr>
//     </thead>
//     <tbody>
//     $body
//     </tdbody>
// </table>
// EOF;
    public function getproduct(){

        if(Auth::user()->hasRole('administrator')){ //is admin, but need to modify
            $products = Product::select(['product.product_id', 'product.name'/*DB::raw('product.name as pname')*/, 'price'
                                    , 'description','view_number','status','pickup_address','pickup_time','created_at'
                                    ,'updated_at',  'file_name', 'location'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp'),'product.image_id', '=', 'temp.image_id')
            ->with('category')
            ;
        }else{
            $user = Auth::id();
            $seller = Seller::where('user_id',$user)->first();

            $products = Product::select(['product.product_id', 'product.name'/*DB::raw('product.name as pname')*/, 'price'
                                    , 'description','view_number','status','pickup_address','pickup_time','created_at'
                                    ,'updated_at',  'file_name', 'location', 'temp1.seller_id'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp'),'product.image_id', '=', 'temp.image_id')
            ->leftJoin(DB::raw('(select seller.seller_id, post.post_id  from seller join post on post.seller_id = seller.seller_id) as temp1')
                ,'product.post_id', '=', 'temp1.post_id')
            ->with('category')
            ->where('temp1.seller_id' , $seller->seller_id)
            ;
            return Datatables::of($products)
                        ->addColumn('action', function ($product) {
                                                $html = '<a href="'.route('product.edit', ['id' => $product->product_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                                                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;' ;
                                                //$html .= '<a data-id="'.$product->product_id.'" class="btn btn-info btn-sm product-featured" data-toggle="modal" data-target="#featured_product_modal"><i class="fas fa-cog"></i></a>' ;
                                                /*$html .= '<a data-id="'.$product->product_id.'"  class="btn btn-info btn-sm product-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;*/

                                                return $html;
                                            })
                        ->make(true);
        }



        return Datatables::of($products)
                        ->addColumn('action', function ($product) {
                                                $html = '<a href="'.route('product.edit', ['id' => $product->product_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                                                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;' ;
                                                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-info btn-sm product-featured" data-toggle="modal" data-target="#featured_product_modal"><i class="fas fa-cog"></i></a>' ;
                                                /*$html .= '<a data-id="'.$product->product_id.'"  class="btn btn-info btn-sm product-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;*/

                                                return $html;
                                            })
                        ->make(true);
    }
    public function getphotos(Request $request){
        $product_id = $request->get('product_id');

        //get the list of photos of product using relationship defined in model
        $photos = Product::find($product_id)->photo;
        $thumbnail = Product::find($product_id)->thumbnail;
        if($thumbnail){
            $photos->push($thumbnail);
        }
        if (sizeof($photos) > 0 || $thumbnail){
            $html = "";
            $source = "";
            $eleclass = "";
            $i=0;
            foreach ($photos as $photo) {

                //get url of each photo
                $source = asset(str_replace('\\','/',$photo->location)) . "/" . $photo->file_name;
                if ($i==0){
                    //set class start to the first photo, so we can use js to click it
                    $eleclass = "class='start'";
                    $i = 1;
                }
                else
                    $eleclass = "";
                //html code for each photo html element
                $html .=  "<a href='" . $source . "' " . $eleclass . " ><img src='" . $source ."' height='40' width='40' ></a>";
            }
            //list of photos must be in the dive with id lightgallery, so in view we can apply the lightgallery library on it
            $html = "<div id='lightgallery'>" . $html . "</div>";
            return [1, $html];
        }else
            return [0];
    }


    //add access control
    public function getactivefeatured(Request $request){
        $product_id = $request->get('product_id');
        $product = Product::with('thumbnail')->with('photo')->with('post')->find($product_id);
        $permit = false;
        if (Auth::user()->hasRole('administrator')) {
            $permit = true;
        }

        if ($permit) {

            $featured_product = Product::getactivefeatured($product_id);
            if (sizeof($featured_product) > 0) {
                return [1, $featured_product];
            } else {
                return [0];
            }
        }else{
            return [2,"You don't have the permission. "];
        }
    }

    //add access control

    public function savefeatured(Request $request)
    {
        $product_id = $request->get('product_id');
        $product = Product::with('thumbnail')->with('photo')->with('post')->find($product_id);
        $permit = false;
        if (Auth::user()->hasRole('administrator')) {
            $permit = true;
        }

        if ($permit) {


            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $featured_product = Product::getactivefeatured($product_id);

            if ($end_date == null) {
                $end_date = '9999-01-01';
            }
            if (sizeof($featured_product) == 1) {

                try {
                    Product::updatefeatured($product_id, $start_date, $end_date);
                    return [1];
                } catch (\Exception $e) {
                    return [0, $e->getMessage()];
                }

            } else {
                try {
                    Product::savefeatured($product_id, $start_date, $end_date);
                    return [1];
                } catch (\Exception $e) {
                    return [0, $e->getMessage()];
                }

            }
        }else{
            return [2,"You don't have the permission. "];
        }
    }
    /*public function home(){

        $products = Product::getProductsWithThumbnailCategory();
        $categorys = Category::all();
        return view('frontend.index',['products'=>$products
            , 'categorys'=>$categorys]);
    }*/
    public function getproductmore(Request $request){

        $products = Product::getProductsWithThumbnailCategory($request->get('offset'));

        if(sizeof($products) > 0){
            $items = array();

            foreach ($products as $product){
                $category = "";
                $category_name = "";
                $categories = $product->category;
                foreach ($categories as $ele){
                    $category .= str_replace(' ','-',$ele->name). " ";
                    $category_name .= $ele->name. ", ";
                }
                $category_name = substr($category_name,0,strlen($category_name )-2);
                $html = "";
                $html .= <<<eot
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item $category" data-product_id="$product->product_id">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
eot;
                if($product->file_name){
                    $location = asset($product->location);
                    $html .= <<<eot

							<img src="$location/$product->file_name" alt="IMG-PRODUCT">
eot;
                }else{
                    $location = asset('images/thumbnail');
                    $html .= <<<eot

							<img src="$location/default.png" alt="IMG-PRODUCT">
eot;
                }
                $location = asset('cozastore');
                $html .= <<<eot
							<a href="javascript:void(0);" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-product_id="$product->product_id">
								Quick View
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">


								<span class="stext-105 cl3">
									<b class='pname'>$product->name</b>
								</span>

								<span class="stext-105 cl3 price">
									$product->price
								</span>

								<span class="stext-105 cl3 category">
									$category_name
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
                $items[] = $html;
            }


            //return [1,$html];
            return [1,$items];
        }
        else
            return [0];
    }
    public function getproductdetail(Request $request){
        $product = Product::with('photo')->with('thumbnail')->with('category')->find($request->get('product_id'));

        $post = Post::where('post_id',$product->post_id)->first();
        $seller = Seller::where('seller_id',$post->seller_id)->first();

        if(isset($product->thumbnail)){
            $location = asset(str_replace('\\','/',$product->thumbnail->location));
            $product->thumbnail->location = $location;
        }else{
            $product->thumbnail_id = asset('images/thumbnail').'/default.png';
        }

        if(isset($product->photos)){
            $size = sizeof($product->photo);
            for($i = 0 ; $i < $size; $i ++){
                $location = asset(str_replace('\\','/',$product->photos[$i]->location));
                $product->photos[$i]->location = $location;
            }

        }
        return [1,$product, $seller];
    }
}
