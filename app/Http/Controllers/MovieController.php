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
		echo 'store';
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
