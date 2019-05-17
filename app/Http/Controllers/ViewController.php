<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index() {
        echo "index";
    }
    public function create() {
        return view('viewcreate');
    }
    public function store(Request $request) {
        $view = new View();
        $view->view_ID = $request->get('view_id');
        $view->name = $request->get('name');

        try {
            $view->save();
            return redirect()->route('view.index')->withFlashSuccess('view is added');
        }
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withFlashDanger("View can't be added. ". $e->getMessage());
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
