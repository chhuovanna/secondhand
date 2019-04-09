<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\movie;
use App\reviewer;

class MovieController extends Controller
{
	public function index() {
		return view('movieindex');
	}
	public function create() {
		return view('moviecreate');
	}
	public function store(Request $request) {
		$movie = new Movie();
		$movie->mid = $request->get('mid');
		$movie->title = $request->get('title');
		$movie->year = $request->get('year');
		$movie->director = $request->get('director');

		try {
			$movie->save();
			return redirect()->route('movie.index')->withFlashSuccess('Movie is added');
		}
		catch (\Exception $e) {
			print_r($request->all());
			return redirect()
            ->back()
            ->withInput($request->all())
            ->withFlashDanger("Movie can't be added. ". $e->getMessage());
			//print_r($request->session('_flash')->all());
            //return back()->withInput()->withErrors("Movie can't be added. ". $e->getMessage());
			//return back()->with('flash_danger',"Movie can't be added. ". $e->getMessage())->withInput($request->all());
			//return back()->withInput()->withErrors("Movie can't be added. ". $e->getMessage());
			 
            // return redirect()->back()->withInput();
		}
	}
	public function show($id) {
		return view('movieedit');
	}
	public function edit($id) {
		echo 'save edit';
	}
	public function update(Request $request, $id) {
		echo 'update';
	}
	public function destroy($id) {
		echo 'destroy';
	}

	public function getform(){
		$movies = movie::all();
		$reviewers = reviewer::all();
		return view('ratemovie', [ 'movies' => $movies, 'reviewers' => $reviewers  ]);
	}

	public function saverating(){
		echo 'saverating';
	}
}
