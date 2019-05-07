<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\product;
use App\seller;
use Datatables;

use DB;


class CategoryController extends Controller
{
    public function index() {
        return view('category.categoryindex');
    }
    public function create() {
        return view('categorycreate');
    }
    public function store(Request $request) {
        $category = new Category();
        $category->ID = $request->get('ID');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->image = $request->get('image');


        try {
            $category->save();
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
        return view('categoryupdate',['category'=>$category]);
    }
    public function update(Request $request, $id) {
        $category= Category::find($id);
        $category->Id = $request->get('ID');
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->image = $request->get('image');
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
            $res = Category::destroy($id);
            if ($res)
                return 1;
            else
                return 0;
        }catch(\Exception $e){
            return 0;
        }

    }

    public function getform(){
        $category = category::all();
        $products = product::all();
        return view('categoryrate', [ 'category' => $category, 'products' => $products  ]);
    }

    public function saveseller(Request $request){

        $seller = new Seller();
        $seller->ID = $request->get('ID');
        $seller->name = $request->get('name');
        $seller->address = $request->get('address');
        $seller->email = $request->get('email');
        $seller->phone = $request->get('phone');
        $seller->instant_massage_account = $request->get('instant_message_account');
        $seller->type = $request->get('type');
        $seller->image = $request->get('image');
        $seller->created_at = $request->get('created_at');
        $seller->updated_at = $request->get('updated_at');
        $seller->sellerDate = date('Y-m-d');
        try {
            $seller->save();
            return redirect()->route('category.rate')->withFlashSuccess('Seller is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("Seller can't be added. ". $e->getMessage());
        }
    }


    public function showrate(){
        $category = category::all();
        return view('categoryshowrate', [ 'category' => $category]);
    }

    public function getseller(Request $request){
        $add = $request->input('add');
        $sellers = seller::getSeller($add);
        if (sizeof($sellers) > 0){
            $stars = 0;
            $body = "";

            foreach ($sellers as $seller) {
                $stars += $seller->stars;
                $body .= <<<EOF
	<tr>
		
		<td>$seller->name</td>
		<td>$seller->stars</td>
		<td>$seller->sellerDate</td>
	</tr>
EOF;
            }

            $stars = $stars/sizeof($sellers);
            $html = <<<EOF
<br><label class='col-md-4 form-control-label'>Average stars : $stars</label><br><br>
<table clas="table">
	<thead>
		<tr>
			<th scope="col">product</th>
			<th scope="col">stars</th>
			<th scope="col">sellerDate</th>
		</tr>
	</thead>
	<tbody>
	$body
	</tdbody>
</table>

EOF;
            return $html;
        }else{
            return "No Seller";
        }
    }

    public function getcategory(){
        $categorys = Category::select(['ID', 'name', 'description', 'image'])->get();

        return Datatables::of($categorys)
            ->addColumn('action', function ($category) {
                $html = '<a href="'.route('category.edit', ['id' => $category->ID]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                $html .= '<a data-id="'.$category->ID.'" class="btn btn-danger btn-sm movie-delete"><i class="far fa-trash-alt"></i></i> Delete</a>' ;
                return $html;
            })
            ->make(true);
    }

}
