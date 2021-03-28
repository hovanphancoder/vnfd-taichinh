<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner;
use Session;
use Illuminate\Support\Facades\Validator;

class PartnerController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Partner $partner) {
        $this->partner = $partner;
    }
    public function index() {
        //        
        return view('admin/partner/list', [
            'partner' => $this->getListPartner(),
        ]);
    }

    public function getListPartner() {
        $partner = new Partner();
        return $partner->getAdminListPartner();
    }
    
    public function add() {
//        $listcate = new Post();
        return view('admin/partner/add');
    }

    public function doAdd(Request $request) {
        if ($request->method() == "POST" || $request->method() == "post") {
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
            $title = $request->input('title');
            $message = $request->input('message');
            $position = $request->input('position');
            $created_at = date("Y-m-d H:i:s");
            
            if ($request->hasFile('image')) {
                $image = time() . "-" . $request->file('image')->getClientOriginalName();
                $destinationPath = public_path() . '/images/upload/partner';
                $request->file('image')->move($destinationPath, $image);
            } else {
                $image = "#";
            }
            
            $id = $this->partner->addPartner($title, $message, $position, $image, $order, $created_at);
            Session::flash('status', 'Thêm thành công');
            return redirect('387/admin/partner/view/' . $id);
        }
        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function show($id) {
        //
        if (!is_int($id) || $id <= 0) {
            $id = (int) $id;
        }
        //  lay danh sach id
        $listid = $this->partner->getListId()->toArray();
        // dd($listid);
        // kiem tra id co ton tai trong table post
        if (!in_array($id, $listid)) {
            return redirect("admin/partner/list");
        }
        return view('admin/partner/view', [
            'viewPartner' => $this->partner->view($id)
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
        $title = $request->input('title');
        $message = $request->input('message');
        $position = $request->input('position');
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/partner';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('url');
        }

        $updated_at = date("Y-m-d H:i:s");

//        exit;
        // neu loi xuat ra "The title may not be greater than 255 characters."
        $update = new Partner();
        $update->updatePartner($id, $title, $message, $position, $image, $order, $updated_at);
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
        $this->partner->delPartner($id);
        Session::flash('status', 'Xóa bài viết thành công');
        return redirect('387/admin/partner/list');
    }

}
