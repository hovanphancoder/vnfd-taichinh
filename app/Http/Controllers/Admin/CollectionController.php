<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Collection;
use Session;

class CollectionController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Collection $collection) {
//        $this->defaultimage = "defaultimage.jpg";
        $this->collection = $collection;
    }

    public function index() {
        //
        return view('admin/post/listcollection', [
            'getlistcollection' => $this->collection->getListCollection()
        ]);
    }
    
    public function viewCollectionPost($id) {
//        if (!in_array($id, $this->post->getListIdCategory())) {
//            return redirect("admin/post/listcategorypost");
//        }
        return view('admin/post/viewcollectionpost', [
            'viewcollectionpost' => $this->collection->viewCollectionPost($id),
//            'listcate' => $this->getlistcate
        ]);
    }
    
    public function editCollectionPost(Request $request, $id) {
//        if (!in_array($id, $this->post->getListIdCategory())) {
//            return redirect("admin/post/listcollectionpost");
//        }
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/post/listcollectionpost");
        }
        if (session('locale') == "en") {
            $title = $request->input('title_en');
            $description = $request->input('description_en');
        } else {
            $title = $request->input('title_vn');
            $description = $request->input('description_vn');
        }
        
        $updated_at = date("Y-m-d H:i:s");
        $this->collection->editCollectionPost($id, session('locale'), $title, $description, $updated_at);
        Session::flash('status', 'Success');
        return redirect("admin/post/viewcollectionpost/" . $id);
    }
    
    public function addCollectionPost() {
        return view('admin/post/addcollectionpost');
    }
    
    public function doAddCollectionPost(Request $request) {
//        echo "<pre>";
//        print_r($request);
//        echo "</pre>";
//        exit;
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Errors!');
            return redirect()->back();
        }
        if (session('locale') == "en") {
            $title = $request->input('title_en');
            $description = $request->input('description_en');
        } else {
            $title = $request->input('title_vn');
            $description = $request->input('description_vn');
        }
        

        $created_at = date("Y-m-d H:i:s");
        $id = $this->collection->addCollectionPost(session('locale'), $title, $description, $created_at);
        Session::flash('status', 'Success');
        return redirect("admin/post/viewcollectionpost/" . $id);
    }
    
    public function destroyCollectionPost($id) {
        //

        $this->collection->delCollectionPost($id);
        Session::flash('status', 'Xóa bài viết thành công');
        return redirect('admin/post/listcollectionpost');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
