<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Screenshot;
use Session;
use Illuminate\Support\Facades\Validator;

class ScreenshotController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Screenshot $screenshot) {
        $this->screenshot = $screenshot;
    }
    public function index() {
        //        
        return view('admin/screenshot/list', [
            'screenshot' => $this->getListScreenshot(),
        ]);
    }

    public function getListScreenshot() {
        $screenshot = new Screenshot();
        return $screenshot->getAdminListScreenshot();
    }
    
    public function add() {
//        $listcate = new Post();
        return view('admin/screenshot/add');
    }

    public function doAdd(Request $request) {
        if ($request->method() == "POST") {
            $rules = [
                'image' => 'required',
            ];
            $messages = [
                'required' => 'Chosen image'
            ];
            

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $order = $request->input('order');
            
            $created_at = date("Y-m-d H:i:s");
            
            if ($request->hasFile('image')) {
                $image = time() . "-" . $request->file('image')->getClientOriginalName();
                $destinationPath = public_path() . '/images/upload/screenshot';
                $request->file('image')->move($destinationPath, $image);
            } else {
                $image = "#";
            }
            
            $id = $this->screenshot->addScreen($image, $order, $created_at);
            Session::flash('status', 'Thêm thành công');
            return redirect('admin/screenshot/view/' . $id);
        }
        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
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
        if (!is_int($id) || $id <= 0) {
            $id = (int) $id;
        }
        $screen = new Screenshot();
        //  lay danh sach id
        $listid = $screen->getListId();
        // kiem tra id co ton tai trong table post
        if (!in_array($id, $listid)) {
            return redirect("admin/screenshot/list");
        }

        return view('admin/screenshot/view', [
            'viewscreenshot' => $screen->viewScreen($id)
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
        if (!is_int($id) || $id <= 0)
            $id = (int) $id;


        $rules = [
            'order' => 'required|integer',
            'url' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $order = $request->input('order');
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/screenshot';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('url');
        }

        $updated_at = date("Y-m-d H:i:s");

//        exit;
        // neu loi xuat ra "The title may not be greater than 255 characters."
        $update = new Screenshot();
        $update->updateScreen($id, $image, $order, $updated_at);
        Session::flash('status', 'Cập nhật bài viết thành công.');
        return redirect()->back();
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
        if (!is_int($id) || $id <= 0)
            $id = (int) $id;
        $del = new Screenshot();
        $del->delScreen($id);
        Session::flash('status', 'Xóa bài viết thành công');
        return redirect('admin/screenshot/list');
    }

}
