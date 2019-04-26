<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\reviewer;

class ReviewerController extends Controller
{
	public function index() {
		echo "index";
	}
	public function create() {
		return view('reviewercreate');
	}
	public function store(Request $request) {
		$reviewer = new Reviewer();
		$reviewer->rid = $request->get('rid');
		$reviewer->name = $request->get('name');

		try {
			$reviewer->save();
			return redirect()->route('reviewer.index')->withFlashSuccess('reviewer is added');
		}
		catch (\Exception $e) {
			return redirect()
            ->back()
            ->withInput($request->all())
            ->withFlashDanger("Reviewer can't be added. ". $e->getMessage());
		}
	}
	public function show($id) {
		echo "show";
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

	
}
