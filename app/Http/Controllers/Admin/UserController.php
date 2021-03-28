<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Users $users) {
        $this->user = $users;
    }

    public function index() {
        //
        return view("admin/user/list", [
            'users' => $this->user->getListUser()
        ]);
    }

    public function setProfile() {
//        $useradmin = new Users();
        return view('admin/user/profile', [
            'useradmin' => $this->user->getUserAdmin()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function add() {
        //
        return view('admin/user/add');
    }

    public function create(Request $request) {
        //
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Update error!');
            return redirect()->back();
        }
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
//            'feature' => 'required',
//            'image' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $group_id = $request->input('role');
        $password = Hash::make($request->input('password'));
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/users';
            $file = $request->file('image')->move($destinationPath, $image);
            if ($file == false) {
                Session::flash("status", "File error!");
                return redirect()->back();
            }
        } else {
            $image = "defaultimage.jpg";
        }
        $created_at = date("Y-m-d H:i:s");

        $id = $this->user->addUser($name, $email, $password, $image, $phone, $group_id, $created_at);
        Session::flash('status', 'Update Success');
        return redirect('admin/user/view/' . $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function view($id) {
        //
        if(!$this->user->getUser($id)){
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        return view('admin/user/view', [
            'user' => $this->user->getUser($id)
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
            Session::flash('status', 'Update error!');
            return redirect()->back();
        }
        if(!$this->user->getUser($id)){
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'role' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $group_id = $request->input('role');
        if (!empty($request->input('password')))
            $password = Hash::make($request->input('password'));
        else
            $password = $request->input('password');
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/users';
            $file = $request->file('image')->move($destinationPath, $image);
            if ($file == false) {
                Session::flash("status", "File error!");
                return redirect()->back();
            }
        } else {
            $image = $request->input('url');
        }
        $updated_at = date("Y-m-d H:i:s");

        $this->user->setUser($id, $name, $email, $password, $image, $phone, $group_id, $updated_at);
        Session::flash('status', 'Update Success');
        return redirect('admin/user/view/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        if(!$this->user->getUser($id)){
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $this->user->delUser($id);
        Session::flash('status', 'Delete Success!');
        return redirect()->back();
    }

}
