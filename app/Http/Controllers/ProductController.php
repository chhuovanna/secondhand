<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Product;
use Datatables;
use DB;
//use App\category;


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
        $product->product_id = $request->get('product_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        $product->created_at = $request->get('created_at');
        $product->updated_at = $request->get('updated_at');
        $product->post_id = $request->get('post_id');
        $product->image_id = $request->get('image_id');
        $product->ratingDate = now();
        try {
            $product->save();
            return redirect()->route('product.index')->withFlashSuccess('product is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("product can't be added. ". $e->getMessage());

        }
    }
    public function view($id) {
        echo 'view';
    }
    public function sign_up($id) {
        echo 'sign_up';
    }
    public function edit($id) {
        $product = Product::find($id);
        return view('productedit',['product'=>$product]);
    }
    public function update(Request $request, $id) {
        $product = Product::find($id);
        $product = new Product();
        $product->product_id = $request->get('product_id');
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->view_number = $request->get('view_number');
        $product->status = $request->get('status');
        $product->pickup_address = $request->get('pickup_address');
        $product->pickup_time = $request->get('pickup_time');
        $product->created_at = $request->get('created_at');
        $product->updated_at = $request->get('updated_at');
        $product->post_id = $request->get('post_id');
        $product->image_id = $request->get('image_id');

        try{
            $product->save();
            return redirect()->route('product.index')->withFlashSuccess('productis updated');
        }catch(\Exception $e){
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("product can't be updated. ". $e->getMessage());
        }

    }
    public function destroy($id) {

        try{
            $res = product::destroy($id);
            if ($res)
                return 1;
            else
                return 0;
        }catch(\Exception $e){
            return 0;
        }

    }

    public function getform(){
        $products = product::all();
        $views = view::all();
        return view('productsign_up', [ 'products' => $products, 'views' => $views  ]);
    }

//    public function savesign_up(Request $request){
//
//        $sign_up = new Sign_up();
//        $sign_up->seller_ID = $request->get('product_id');
//        $sign_up->username_or_email = $request->get('username_or_email');
//        $sign_up-> phone= $request->get('phone');
//        $sign_up-> password= $request->get('password');
//        $sign_up->sign_upDate = date('Y-m-d');
//        try {
//            $sign_up->save();
//            return redirect()->route('product.sign_up')->withFlashSuccess('sign_up is added');
//        }
//        catch (\Exception $e) {
//            return redirect()
//                ->back()
//                ->withInput($request->all())
//                ->withFlashDanger("Sign_up can't be added. ". $e->getMessage());
//        }
//    }



//    public function showsign_up(){
//        $products = product::all();
//        return view('productsign_up', [ 'products' => $products]);
//    }

//    public function getsign_up(Request $request){
//        $product_id = $request->input('product_id');
//        $sign_ups = Sign_up::getRating($product_id);
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

    public function getproduct(){
        $products = product::select(['product_id', 'name', 'price', 'description','view_number','status','pickup_address','pickup_time','created_at','updated_at','post_id','image_id'])->get();

        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                $html = '<a href="'.route('product.edit', ['product_id' => $product->product_ID]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$product->product_ID.'" class="btn btn-danger btn-sm product-delete"><i class="far fa-trash-alt"></i></i> Delete</a>' ;
                return $html;
            })
            ->make(true);
    }


}
