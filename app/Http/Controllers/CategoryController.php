<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;//for deleting file
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\Image; //need to use it to call new Image();
use Datatables;
use DB;


class CategoryController extends Controller
{
    public function index() {
        return view('scrud.categoryindex');
    }
    public function create()
    {
        if (Auth::user()->hasRole('administrator')) {

            return view('scrud.categorycreate');

        }else{
            return redirect()
                ->back()
                ->withFlashDanger("You don't have the permission");
        }
        
    }
    public function store(Request $request)
    { //add access control
        if (Auth::user()->hasRole('administrator')) {
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
            $image->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $image->location = 'images/category'; //category is stored in public/images/category

            try {
                $image->save();
                //category the file to it's location on server
                $file->move(public_path($image->location), $image->file_name);

                //image of category
                $category->image_id = $image->image_id;
                $category->save();
                //echo $category->image_id;

                return redirect()->route('category.index')->withFlashSuccess('Category is added');

            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withFlashDanger("Category can't be added. " . $e->getMessage());

            }
        }else{
            return "You don't have the permission";
        }
    }
//    public function show($id) {
//        echo 'show';
//    }
    public function edit($id) {
        if (Auth::user()->hasRole('administrator')) {
            //we dont have image function in model category, we only have thumbnail()
            $category = Category::with('thumbnail')->find($id);
            return view('scrud.categoryedit', ['category' => $category]);
        }else{
            return redirect()
                ->back()
                ->withFlashDanger("You don't have the permission");
        }

    }
    public function update(Request $request, $id)
    { // add access control
        if (Auth::user()->hasRole('administrator')) {
            $category = Category::find($id);
            //$category->category_id = $request->get('category_id');
            $category->name = $request->get('name');
            $category->description = $request->get('description');
            //$category->image_id = $request->get('image_id');
            //$category->created_at = $request->get('created_at');
            //$category->updated_at = $request->get('updated_at');

            $validateData = $request->validate([
                'image_id' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


            try {
                // test if image is updated or not
                if ($request->hasFile('image_id')) {
                    $file = $request->file('image_id');
                    $image = new Image();
                    $image->file_name = rand(1111, 9999) . time() . '.' . $file->getClientOriginalExtension();
                    $image->location = 'images/category';

                    $file->move(public_path($image->location), $image->file_name);
                    $image->save();//save new image


                    $old_image = $category->image_id; // Keep the old image for removing if it exists
                    $category->image_id = $image->image_id;    //change the image to the new one


                }
                $category->save(); //save the update of seller
                if (isset($old_image)) {
                    $old_image = Image::find($old_image);
                    //remove old image from harddisk
                    $file = public_path($old_image->location) . '/' . $old_image->file_name;
                    if (File::exists($file)) {
                        File::delete($file);
                    }

                    $old_image->delete(); //delete the old image if user add a new one
                }
                

                return redirect()->route('category.index')->withFlashSuccess('Category is updated');
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withFlashDanger("Category can't be updated. " . $e->getMessage());
            }

        }else{
            return "You don't have the permission";
        }
    }

    public function destroy($id)
    {
        if (Auth::user()->hasRole('administrator')) {

            try {
                //to get image of the category to be deleted. in Category model, there is function called image
                $image = Category::find($id)->thumbnail;

                //delete category from database
                $res['category'] = Category::destroy($id);
                if ($image) {

                    $file = public_path($image->location) . '/' . $image->file_name;


                    //test if the image file exists or not
                    if (File::exists($file)) {
                        //delete the file from the folder
                        if (File::delete($file)) {
                            //delete the image of the category from database;
                            $res['image'] = $image->delete();
                        }
                    }
                }


                if ($res['category'])
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



    public function getcategory(){
        $categorys = Category::select(['category_id', 'name', 'description'
            ,'category.image_id','category.created_at','category.updated_at'
            ,'location','file_name'])
            ->leftJoin(DB::raw('(select image_id, file_name, location from image) AS temp'),'category.image_id', '=', 'temp.image_id')
        ;///need to use subquery with DB::raw to avoid ambigous of created_at and updated_at when search

        if(Auth::user()->hasRole('administrator')){ //is admin, but need to modify
            return Datatables::of($categorys)
                ->addColumn('action', function ($category) {
                    $html = '<a href="'.route('category.edit', ['category_id' => $category->category_id]).'" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>&nbsp;&nbsp;&nbsp;';
                    $html .= '<a data-id="'.$category->category_id.'" class="btn btn-danger btn-sm category-delete"><i class="far fa-trash-alt"></i></i> Delete</a>&nbsp;&nbsp;&nbsp;' ;

                    return $html;
                })
                ->make(true);
        }else{
            return Datatables::of($categorys)
            ->addColumn('action', function ($category) {
                                return "No action";
            })->make(true);
        }
    }



}
