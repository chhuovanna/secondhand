<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; //for deleting file
use App\category;
use App\image; //need to use it to call new Image();
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
        $category = Category::find($id);
        return view('category.categoryedit',['category'=>$category]);
    }
    public function update(Request $request, $id) {
        $category= Category::find($id);
        $category->category_id = $request->get('category_id');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->image_id = $request->get('image_id');
        $category->created_at = $request->get('created_at');
        $category->updated_at = $request->get('updated_at');
        try{
            $category->save();
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
            ->leftJoin('image','category.image_id', '=', 'image.image_id')
        ;

        return Datatables::of($categorys)
            ->addColumn('action', function ($category) {
                $html = '<a href="'.route('category.edit', ['category_id' => $category->category_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$category->category_id.'" class="btn btn-danger btn-sm category-delete"><i class="far fa-trash-alt"></i></i> Delete</a>' ;
                $html .= '<a data-id="'.$category->category_id.'"  class="btn btn-info btn-sm category-rate-info"><i class="fa fa-search" aria-hidden="true"></i></i></a>' ;
                return $html;
            })
            ->make(true);
    }

}
