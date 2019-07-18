<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
<<<<<<< HEAD

use App\Product;
use App\Image;
use App\Category;
use App\Post;
use App\Seller;
use Datatables;
use DB;
use Illuminate\Support\Facades\Auth;



=======
use App\product;
use App\image;
use App\category;
use App\post;
//use App\reviewer;
//use App\rating;
use Datatables;
use DB;
//use App\category;
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
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
<<<<<<< HEAD

    public function createwitholdpost($post_id)
=======
    public function createwitholdpost()
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
    {
        $categories = Category::getSelectOptions();
        $product = Product::where('post_id','=', $post_id)->first();

       return view('category.productcreate', ['categories' => $categories
                                            , 'post_id' =>$post_id
                                            ,'pickup_time'=>$product->pickup_time
                                            ,'pickup_address'=>$product->pickup_address]);
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
        $thumbnail->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
        $thumbnail->location = 'images\thumbnail'; //thumbnail is stored in public/images/thumbnail

<<<<<<< HEAD
        try {
=======

              try {
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
            $thumbnail->save();
            //product the file to it's location on server
            $file->move(public_path($thumbnail->location),$thumbnail->file_name);
<<<<<<< HEAD

            //thumbnail of product
=======
            //thumbnail of movie
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
            $product->image_id = $thumbnail->image_id;
            if ($request->get('post_id') !== null){
                $product->post_id = $request->get('post_id');
            }else{
                $user_id = Auth::id();
                $seller = Seller::where('user_id','=',$user_id)->first();
                $post = new Post();
                $post->seller_id = $seller->seller_id;
                $post->save();
                $product->post_id = $post->post_id;
            }
            //add seller is missing
            $product->save();
<<<<<<< HEAD


=======
            if($request->get('add_more') == 1){
                $this->productwithpost = new Product();
                $productwithpost->post_id = $product->post_id;
                $productwithpost->pickup_address = $product->pickup_address;
                $productwithpost->pickup_time = $product->pickup_time;
                return redirect()->route('product.create.with.oldpost')->withFlashSuccess('Product is added');
            }
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
            //test if user has upload other photos or not
            if($request->hasFile('photos')){
                //get the array of photos
                $photos = $request->file('photos');
                foreach ($photos as $key => $file) {
                    $photo = new Image();
                    $photo->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
                    //photos are stored on server in folder public/images/photos
                    $photo->location = 'images\photos';

<<<<<<< HEAD
                    //photo belongs to product
=======
                    //photo belongs to movie
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
                    $photo->product_id = $request->get('product_id'); //not (id) product_id
                    $photo->save();
                    $file->move(public_path($photo->location),$photo->file_name);
                }
            }
            $category = $request->get('category_id');
            if(sizeof($category)>0){
                $product->category()->attach($category);
            }

<<<<<<< HEAD


            //dd($category);


            if($request->get('add_more') == 1){


                return redirect()->route('product.create.with.oldpost',['post_id'=>$product->post_id])->withFlashSuccess('Product is added. You wish you add more product in the same post. We suggest the same pickup time and date');
            }
            return redirect()->route('product.index')->withFlashSuccess('Product is added');
        }
=======
            //dd($category);
            return redirect()->route('product.index')->withFlashSuccess('Product is added');

       }
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
        catch (\Exception $e) {
            return redirect()
            ->back()
            ->withInput($request->all())
            ->withFlashDanger("Product can't be added. ". $e->getMessage());
        }

<<<<<<< HEAD
        }
=======
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
    }
    public function show($id) {
        echo 'showlalal'.$id;
    }
    public function edit($id) {
        $product = Product::with('thumbnail')->with('photo')->find($id);
        $categories = Category::getSelectOptions();
        return view('category.productedit',['categories'=>$categories, 'product'=>$product]);
    }
    public function update(Request $request, $id) {
        $product = Product::find($id);
        $product->product_id = $request->get('product_id');
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
			,'photos[]' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


        try{
			// test if thumbnail is updated or not
			if($request->hasFile('thumbnail_id')){
				$file = $request->file('thumbnail_id');
				$thumbnail = new Image();
				$thumbnail->file_name = rand(1111,9999).time().'.'.$file->getClientOriginalExtension();
				$thumbnail->location = 'images\thumbnail';

				$file->move(public_path($thumbnail->location),$thumbnail->file_name);
				$thumbnail->save();//save new thumbnail


				$old_thumbnail = $product->thumbnail; // Keep the old thumbnail for removing if it exists
				$product->thumbnail_id = $thumbnail->image_id;	//change the thumbnail to the new one


			}



			$product->save(); //save the update of product

			if(isset($old_thumbnail)){
				//remove old thumbnail from harddisk
				$file = public_path($old_thumbnail->location).'\\'.$old_thumbnail->file_name;
				if ( File::exists($file)) {
					File::delete($file);
				}

				$old_thumbnail->delete(); //delete the old thumbnail if user add a new one
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

					//photo belongs to product
					$photo->product_id = $request->get('product_id');
					$photo->save();
					$file->move(public_path($photo->location),$photo->file_name);


				}
			}



			return redirect()->route('product.index')->withFlashSuccess('product is updated');
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Product can't be updated. ". $e->getMessage());
        }
    }
    public function destroy($id) {
<<<<<<< HEAD


        try{

            //to get the array of photos of the product
=======

        try{
            //to get the array of photos of the movie
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
            $photos = Product::find($id)->photos;
            $res['photos'] = true;
            foreach ($photos as $photo) {
                $file = public_path($photo->location).'\\'.$photo->file_name;
                if ( File::exists($file)) {

                    if(File::delete($file)){//delete the file from the folder
                        $res['photos'] = $res['photos'] && $photo->delete(); //delete the file from database
                    }
<<<<<<< HEAD

                }
            }




                //to get thumbnail of the product to be deleted. in product model, there is function called thumbnail
                $thumbnail = Product::find($id)->thumbnail;

                //delete product from database
                $res['product'] = Product::destroy($id);

            if ($thumbnail){


=======
                }
            }

            //to get thumbnail of the movie to be deleted. in Movie model, there is function called thumbnail
            $thumbnail = Product::find($id)->thumbnail;
            //delete movie from database
            $res['product'] = Product::destroy($id);
            if ($thumbnail){
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141


<<<<<<< HEAD

=======
                $file = public_path($thumbnail->location).'\\'.$thumbnail->file_name;
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141

                //test if the thumbnail file exists or not
                if ( File::exists($file)) {
                    //delete the file from the folder
<<<<<<< HEAD
                   if(File::delete($file)){
                        //delete the thumbnail of the product from database;
=======
                    if(File::delete($file)){
                        //delete the thumbnail of the movie from database;
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
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
        //$reviewers = reviewer::all();//???
        return view('productrate', [ 'products' => $products  ]);
    }
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


<<<<<<< HEAD



=======
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
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
        //$movies = Movie::select(['mID', 'title', 'director', 'year']);
        $products = Product::select(['product.product_id', 'product.name'/*DB::raw('product.name as pname')*/, 'price', 'description','view_number','status','pickup_address','pickup_time','created_at','updated_at',  'file_name', 'location'])
<<<<<<< HEAD

        ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp'),'product.image_id', '=', 'temp.image_id')
        ->with('category');
        ;
=======
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141

            ->leftJoin(DB::raw('(select image_id, file_name, location from image) as temp'),'product.image_id', '=', 'temp.image_id')
            ->with('category');
        ;
        return Datatables::of($products)
<<<<<<< HEAD
                        ->addColumn('action', function ($product) {
                                                $html = '<a href="'.route('product.edit', ['id' => $product->product_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                                                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;' ;
                                                /*$html .= '<a data-id="'.$product->product_id.'"  class="btn btn-info btn-sm product-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;*/

                                                return $html;
                                            })
                        ->make(true);
=======
            ->addColumn('action', function ($product) {
                $html = '<a href="'.route('product.edit', ['id' => $product->product_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$product->product_id.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;&nbsp;' ;
                /*$html .= '<a data-id="'.$product->product_id.'"  class="btn btn-info btn-sm product-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;*/

                return $html;
            })
            ->make(true);
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
    }
    public function getphotos(Request $request){
        $product_id = $request->get('product_id');
<<<<<<< HEAD

        //get the list of photos of product using relationship defined in model
=======
        //get the list of photos of movie using relationship defined in model
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
        $photos = Product::find($id)->photos;
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
            //list of photos must be in the dive with id lightgallery, so in view we can apply the lightgallery library on it
            $html = "<div id='lightgallery'>" . $html . "</div>";
            return [1, $html];
        }else
            return [0];
    }
}


<<<<<<< HEAD






=======
>>>>>>> f1a07632f028678956bbc14f8d002d13d7a63141
