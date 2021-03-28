<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Consultant;
use Mail;
use Illuminate\Http\Request;

class ConsultantController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Consultant $consultant) {
        parent::__construct();
        $this->consultant = $consultant;
    }
    public function index() {
        //
    }

    public function create(Request $request) {
//        echo "dsadasd";exit;
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
        $rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|phone_count'
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ tên quá dài',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.phone_count' => 'Số điện thoại không đúng',
            'phone.numeric' => 'Vui lòng nhập đúng số điện thoại',
        ];
        // them validate phone_count
        Validator::extend('phone_count', function($attribute, $value, $parameters) {
            return strlen($value) >= 10 && strlen($value) < 11;
        });

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator);
            return response()->json(['result' => $validator->messages(), 'name' => $request->input('name'), 'phone' => $request->input('phone'), 'message' => $request->input('message'), 'email' => $request->input('email')]);
        }

        $email = $request->input('email')?$request->input('email'):"";
        $name = $request->input('name');
        $phone = $request->input('phone');
        $utm_source = $request->input('utm_source');
        $utm_medium = $request->input('utm_medium');
        $utm_campaign = $request->input('utm_campaign');
        $utm_content = $request->input('utm_content');
        $message = $request->input('message');
        $currentdate = date("Y-m-d h:i:s");

//        $data = array(
//            'name' => $name,
//            'email' => $email,
//            'title' => '[PKCK Anh Nga] Khach Hang Dat Cau Hoi',
//            'from' => 'anhbatan@gmail.com',
//            'cc' => 'duytan387.pham@gmail.com',
//			'message' => $message,
//            'sender' => 'Tan Pham'
//        );
//        $mail = Mail::to('emails.contact', $data, function($message) use ($data){
//            $message->from('chuyenkhoakysinhtrung@gmail.com', 'Phong Kham Chuyen Khoa Anh Nga');
//            $message->to('chuyenkhoakysinhtrung@gmail.com', 'PKCK Anh Nga');
//            $message->bcc('duytan387.pham@gmail.com');
//            $message->subject('Khach Hang Dat Cau Hoi');
//        });
//        if(!$mail){
//            return redirect()->back();
//        }
        $result = $this->consultant->set($name, $phone, $email, $address = "", $message, $utm_source, $utm_medium, $utm_campaign, $utm_content, $currentdate);
        if(!$result){
            return response()->json(['result' => '<p>Đã xãy ra sự cố, vui lòng thử lại!</p>']);
        }
        return response()->json(['result' => '<p>Bạn đã đăng ký tư vấn thành công.</p>']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function creasste() {
        //
        if(!$request->isMethod('post') || !$request->isMethod('POST')){
            Session::flash('result', 'Vui lòng điền đây đủ thông tin');
            return redirect()->back();
        }
        $rules = [
            'email' => 'required',
            'phone'
        ];
        $messages = [
            'email.required' => 'Vui lòng nhập email'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('result', 'Email chưa đúng!');
            //return redirect()->back()->withErrors($validator->errors());
            return redirect()->back();
        }
        $email = $request->input('email');
        $date = date("Y-m-d H:i:s");
        $result = $this->newsletter->createForm($email, $date);
        if(!$result){
            Session::flash('result', 'Vui lòng thử lại!');
            return redirect()->back();
        }
        Session::flash('result', 'Đăng ký thành công!');
        return redirect('thong-bao');
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
