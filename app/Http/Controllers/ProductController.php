<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // for deleting file
use App\product;
use App\reviewer;
use App\rating;
use App\image;
use Datatables;
use DB;
class ProductController extends Controller
{
    public function index() {
        return view('category.productindex');
    }
    public function create() {
        return view('category.productcreate');
    }
    public function store(Request $request) {
        $product = new Product();
        $product->product_id = $request->get('product');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        // $product->created_at = $request->get('created_at');
        // $product->update_at = $request->get('update_at');
        $product->post_id = $request->get('post_id');
        $product->image_id = $request->get('image_id');
        $validateData = $request->validate([
            'thumbnail_id' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ,'photos[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        //get file from input
        $file = $request->file('thumbnail_id');
        $thumbnail = new Image();
        $thumbnail->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
        $thumbnail->location = 'images\thumbnail'; //thumbnail is stored in public/images/thumbnail

        try {
            $thumbnail->save();
            //movie the file to it's location on server
            $file->move(public_path($thumbnail->location),$thumbnail->file_name);
            //thumbnail of movie
            $product->thumbnail_id = $thumbnail->image_id;
            $product->save();
            //test if user has upload other photos or not
            if($request->hasFile('photos')){
                //get the array of photos
                $photos = $request->file('photos');
                foreach ($photos as $key => $file) {
                    $photo = new Image();
                    $photo->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
                    //photos are stored on server in folder public/images/photos
                    $photo->location = 'images\photos';

                    //photo belongs to movie
                    $photo->product_id = $request->get('product_id');
                    $photo->save();
                    $file->move(public_path($photo->location),$photo->file_name);
                }
            }
            return redirect()->route('product.index')->withFlashSuccess('Product is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Product can't be added. ". $e->getMessage());
        }
    }
    public function show($id) {
        echo 'showlalal';
    }
    public function edit($id) {
        $product = Product::with('thumbnail')->with('photos')->find($id);
        return view('productupdate',['product'=>$product]);
    }
    public function update(Request $request, $id) {
        $product = new Product();
        $product->product_id = $request->get('product');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        $product->created_at = $request->get('created_at');
        $product->update_at = $request->get('update_at');
        $product->post_id = $request->get('post_id');
        $product->image_id = $request->get('image_id');
        $validateData = $request->validate([
            'thumbnail_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ,'photos[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        try {
            // test if thumbnail is updated or not
            if($request->hasFile('thumbnail_id')){
                $file = $request->file('thumbnail_id');
                $thumbnail = new Image();
                $thumbnail->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
                $thumbnail->location = 'images\thumbnail';

                $file->move(public_path($thumbnail->location),$thumbnail->file_name);
                $thumbnail->save();//save new thumbnail
                $old_thumbnail = $product->thumbnail; // Keep the old thumbnail for removing if it exists
                $product->thumbnail_id = $thumbnail->image_id;    //change the thumbnail to the new one
            }
            $product->save(); //save the update of movie

            if(isset($old_thumbnail)){
                //remove old thumbnail from harddisk
                $file = public_path($product->thumbnail->location).'\\'.$product->thumbnail->file_name;
                if ( File::exists($file)) {
                    File::delete($file);
                }
                $product->thumbnail->delete(); //delete the old thumbnail if user add a new one
            }
            $db_old_photos = $product->photos;//get old photos from db
            if($db_old_photos){// if there is any old photos in db
                $old_photos = $request->get('old_photos'); //get the list of old photos after use update

                foreach($db_old_photos as $db_old_photo){
                    //test if user has deleted all old photos, we remove it from db and hard disk
                    //or test if some old photos are deleted by user, we remove it form db and hard disk
                    if (!$old_photos or ($old_photos && !in_array($db_old_photo->image_id, $old_photos))){
                        if($db_old_photo->delete()){
                            //remove old thumbnail from harddisk
                            $file = public_path($db_old_photo->location).'\\'.$db_old_photo->file_name;
                            if ( File::exists($file)) {
                                File::delete($file);
                            }
                        }
                    }
                }
            }

            //test if user has upload other photos or not
            if($request->hasFile('photos')){
                //get the array of photos
                $photos = $request->file('photos');
                foreach ($photos as $file) {
                    $photo = new Image();
                    $photo->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
                    //photos are stored on server in folder public/images/photos
                    $photo->location = 'images\photos';

                    //photo belongs to movie
                    $photo->product_id = $request->get('product_id');
                    $photo->save();
                    $file->move(public_path($photo->location),$photo->file_name);

                }
            }
            return redirect()->route('product.index')->withFlashSuccess('Product is updated');
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Product can't be updated. ". $e->getMessage());
        }
    }
    public function destroy($id) {

        try{
            //to get the array of photos of the movie
            $photos = Product::find($id)->photos;
            $res['photos'] = true;
            foreach ($photos as $photo) {
                $file = public_path($photo->location).'\\'.$photo->file_name;
                if ( File::exists($file)) {

                    if(File::delete($file)){//delete the file from the folder
                        $res['photos'] = $res['photos'] && $photo->delete(); //delete the file from database
                    }
                }
            }

            //to get thumbnail of the movie to be deleted. in Movie model, there is function called thumbnail
            $thumbnail = Product::find($id)->thumbnail;
            //delete movie from database
            $res['product'] = Product::destroy($id);
            if ($thumbnail){
                $file = public_path($thumbnail->location).'\\'.$thumbnail->file_name;

                //test if the thumbnail file exists or not
                if ( File::exists($file)) {
                    //delete the file from the folder
                    if(File::delete($file)){
                        //delete the thumbnail of the movie from database;
                        $res['thumbnail'] = $thumbnail->delete();
                    }
                }

            }

            if ($res['product'] )
                return [1];
            else
                return [0];
        }catch(\Exception $e){
            return [0,$e->getMessage()];
        }
    }
    public function getform(){
        $products = product::all();
        $reviewers = reviewer::all();
        return view('productrate', [ 'products' => $products, 'reviewers' => $reviewers  ]);
    }
    public function saverating(Request $request){

        $rating = new Rating();
        $rating->mID = $request->get('mid');
        $rating->rID = $request->get('rid');
        $rating->stars = $request->get('stars');
        $rating->ratingDate = date('Y-m-d');
        try {
            $rating->save();
            return redirect()->route('product.rate')->withFlashSuccess('Rating is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Rating can't be added. ". $e->getMessage());
        }
    }
    public function showrate(){
        $products = product::all();
        return view('productshowrate', [ 'products' => $products]);
    }
    public function getrating(Request $request){
        $product_id = $request->input('product_id');
        $ratings = Rating::getRating($product_id);
        if (sizeof($ratings) > 0){
            $stars = 0;
            $body = "";
            foreach ($ratings as $rating) {
                $stars += $rating->stars;
                $body .= <<<EOF
    <tr>
        
        <td>$rating->name</td>
        <td>$rating->stars</td>
        <td>$rating->ratingDate</td>
    </tr>
EOF;
            }
            $stars = $stars/sizeof($ratings);
            $html = <<<EOF
<br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
<table clas="table">
    <thead>
        <tr>
            <th scope="col">reviewer</th>
            <th scope="col">stars</th>
            <th scope="col">ratingDate</th>
        </tr>
    </thead>
    <tbody>
    $body
    </tdbody>
</table>
EOF;
            return $html;
        }else{
            return "No Rating";
        }
    }
    public function getmovie(){
        //$movies = Movie::select(['mID', 'title', 'director', 'year']);
        $movies = Movie::select(['product.product_id', 'name','price', 'description', 'view_number','status','pickup_address','pickup_time','created_at','update_at','post_id','image_id', 'avgstars', 'image.file_name', 'image.location'])
            ->leftJoin(DB::raw('(select product_id, avg(stars) as avgstars from rating group by product_id) as temp'), 'temp.product_id','product.product_id')
            ->leftJoin('image','thumbnail_id', '=', 'image.image_id')
        ;
        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                $html = '<a href="'.route('product.edit', ['id' => $product->product_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;' ;
                $html .= '<a data-id="'.$product->product_id.'"  class="btn btn-info btn-sm product-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;

                return $html;
            })
            ->make(true);
    }
    public function getphotos(Request $request){
        $product_id = $request->get('product_id');
        $thumbnail = Product::find($product_id)->thumbnail;
        //get the list of photos of movie using relationship defined in model
        $photos = Product::find($product_id)->photos;
        if (sizeof($photos) > 0){
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
            $source = $source = asset(str_replace('\\','/',$thumbnail->location)) . "/" . $thumbnail->file_name;
            //add thumbnail to the list too
            $html .="<a href='" . $source . "'  ><img src='" . $source ."' height='40' width='40' ></a>";
            //list of photos must be in the div with id lightgallery, so in view we can apply the lightgallery library on it
            $html = "<div id='lightgallery'>" . $html . "</div>";
            return [1, $html];
        }else
            return [0];
    }
    public function home(){
        $products = Product::getProductsWithThumbnail();
        return view('frontend.index',['products'=>$products]);
    }
    public function getproductmore(Request $request){
        $products = Product::getProductsWithThumbnail($request->get('offset'));
        if(sizeof($products) > 0){
            //$items = array();
            $html = "";

            foreach ($products as $product){
                //$html = "";
                $html .= <<<eot
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
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
                            <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                Quick View
                            </a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    $product->title
                                </a>
                                <span class="stext-105 cl3">
                                    $product->year
                                </span>
                                <span class="stext-105 cl3">
                                    $product->director
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