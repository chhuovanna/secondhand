<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Datatables;

use DB;


class PostController extends Controller

{

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function datatable()

    {

        return view('datatable');

    }


    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function getPosts()

    {

    	$users = DB::table('movie')->select('*');

        return Datatables::of($users)

            ->make(true);

    }

}