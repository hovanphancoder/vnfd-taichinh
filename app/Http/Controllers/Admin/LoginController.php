<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index() {
        //
        if (Auth::check() && Auth::user()->group_id != 3) {
            // The user is logged in...
            if (!Session::has('locale')) {
                Session::put('locale', 'vn');
            }
            
            return redirect('admin/dashboard');
        }
        return view('admin/login');
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



    public function doLogin(Request $request) {
        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $msg = [
            'required' => ':attribute không được bỏ trống.',
            'password.min' => 'Password phải lớn hơn :min ký tự.',
            'username.min' => 'Username phải lớn hơn :min ký tự.',
            'username.max' => 'Username phải nhỏ hơn :max ký tự.',
        ];

        // run the validation rules on the inputs from the form

        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form

        if ($validator->fails()) {
            Session::flash('login', 'Email or password is error');
            return redirect('admin/login');
        } else {
            // $email = $request->input('email');
            // $password = $request->input('password');
            // attempt to do the login
            $credentials = [];
            $credentials['email'] = $request->email;
            $credentials['password'] = $request->password;
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if($user->customer_id > 0 || $user->group_id == 3){
                    Auth::logout();
                    return redirect('/');
                }
                Session::flash('status', 'Login Success');
                return redirect('admin/dashboard');
            } else {
                Session::flash('login', 'Login Failed');
                return redirect('admin/login');
            }
        }
    }



    public function logout() {

        if (Auth::check()) {

//            echo "dsadsa";exit;

            Auth::logout();

//            Session::flash('login', 'Logout Success');

            Session::flush();

            return redirect('admin/login');

        }

    }



}

