<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\movie;
use App\reviewer;
use App\rating;

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
		return view('movierate', [ 'movies' => $movies, 'reviewers' => $reviewers  ]);
	}

	public function saverating(Request $request){
		
		$rating = new Rating();
		$rating->mID = $request->get('mid');
		$rating->rID = $request->get('rid');
		$rating->stars = $request->get('stars');
		$rating->ratingDate = date('Y-m-d');
		try {
			$rating->save();
			return redirect()->route('movie.rate')->withFlashSuccess('Rating is added');
		}
		catch (\Exception $e) {
			return redirect()
            ->back()
            ->withInput($request->all())
            ->withFlashDanger("Rating can't be added. ". $e->getMessage());
		}
	}



	public function showrate(){
		$movies = movie::all();
		return view('movieshowrate', [ 'movies' => $movies]);
	}

	public function getrating(Request $request){
		$mid = $request->input('mid');
		$ratings = Rating::getRating($mid);
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

}
