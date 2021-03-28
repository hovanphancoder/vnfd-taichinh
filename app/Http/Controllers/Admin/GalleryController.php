<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gallery;
use Session;
use File;

class GalleryController extends AppController {

    public function __construct(Gallery $gallery) {
        $this->defaultimage = "defaultimage.jpg";
        $this->gallery = $gallery;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
        return view('admin/gallery/list', [
            'listgallery' => $this->gallery->listGallery()
        ]);
    }
    
    public function add() {
        return view('admin/gallery/add');
    }
    
    public function doAdd(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $title = $request->input('title_vn');
        $description = $request->input('description_vn');
        $content = $request->input('content_vn');
        
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/gallery';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $this->defaultimage;
        }
        $created_at = date("Y-m-d H:i:s");
        
        $id = $this->gallery->addItem($title, $description, $content, $image, $created_at);
        

        Session::flash('status', 'Success');
        return redirect('admin/gallery/view/'.$id);
    }
    
    public function show($id) {
        //
        // kiem tra id co ton tai trong table post
        if (!in_array($id, $this->gallery->getListId())) {
            return redirect("admin/gallery/list");
        }

        return view('admin/gallery/view', [
            'view' => $this->gallery->viewGallery($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        //
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $title = $request->input('title_vn');
        $description = $request->input('description_vn');
        $content = $request->input('content_vn');
        
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/gallery';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('old_image');
        }
        $updated_at = date("Y-m-d H:i:s");
        $id = $this->gallery->updateItem($id, $title, $description, $content, $image, $updated_at);
        Session::flash('status', 'Cập nhật trang thành công.');
        return redirect()->back();
        
    }
    
    public function destroy($id) {
        //
        $item = $this->gallery->getItem($id);
        $this->gallery->delItem($id);
        File::delete(public_path('images/upload/gallery/' . $item->image));
        Session::flash('status', 'Deleted Gallery');
        return redirect('admin/gallery/list');
    }

}
