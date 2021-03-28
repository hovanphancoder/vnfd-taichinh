<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contact;
use App\Banner;
use Illuminate\Support\Facades\Session;
use DateTime;
use Mail;
class ContactController extends AppController {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Banner $banner, Contact $contact) {
        $this->banner = $banner;
        $this->contact = $contact;
    }
    public function index() {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function old_create(Request $request) {
        if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            return response()->json(['fail' => '<p>Please try again.</p>']);
        }
        $email = $request->input('email');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $subject = $request->input('subject');
        $message = $request->input('message');
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            return response()->json(['fail' => '<p>Email không đúng định dạng</p>']);
//        }
        //
//        echo "dsada";exit;
//        $validator = Validator::make($request->all(), [
//                    'name' => 'required|max:255',
//                    'email' => 'required|email|max:255',
//                    'phone' => 'required|max:12',
//                    'services' => 'required|max:255',
//                    'message' => 'required'
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['success' => '<p>aaaaVui lòng thông tin</p>']);
//        }
        $currentdate = date("Y-m-d h:i:s");
        $this->contact->add($name, $email, $phone, $subject, $message, $currentdate);
        return response()->json(['success' => '<p>Thanks for contact register.</p>']);
        // setting email
//        $mail = new Setting();        $sendmail = $mail->getMail();
//        $config = json_decode($sendmail->config);             /*echo "<br>";      print_r($config);       echo "<br>";        echo $config->cc;       echo $config->from;     if(empty($config->cc))      {           echo "dsada";       }       exit;*/
        // 
//        $data = array(
//            'name' => $name,
//            'email' => $email,
//            'title' => $config->title,
//            'from' => $config->from,
//            'cc' => $config->cc,
//            'sender' => $config->name
//        );
//
//        Mail::send('emails.contact', $data, function($message) use ($data){
//            $message->from($data['from'], $data['sender']);
//            $message->to($data['email'], $data['name']);          if(!empty($data['cc']))         {               $message->cc($data['cc']);          }           
//           $message->subject($data['title']);
//        });
//        Session::flash('form', 'Đã nhận được thông tin. Chúng tôi sẽ liên hệ bạn trong thời gian sớm.');
//        return redirect('/lien-he');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function create(Request $request) {
     
        if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            return response()->json(['result' => '<p>Please try again.</p>']);
        }
           Validator::extend('phone_count', function($attribute, $value, $parameters) {
            return strlen($value) == 10;
        });
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|phone_count',
            'message' => 'required|max:255'
        ];
        $messages = [
            // 'name.required' => 'Please fill name',
            // 'name.max' => 'Name is too long',
            // 'email.required' => 'Please fill email',
            // 'email.email' => 'The email incorrect',
            // 'message.max' => 'The message too long',
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ Tên quá dài',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email quá dài',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.phone_count' => 'Số điện thoại không đúng',
            'phone.numeric' => 'Vui lòng nhập đúng số điện thoại',
            'message.required' => 'Nội dung liên hệ của bạn là gì?',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator);
            return response()->json([
                'result' => $validator->messages(), 
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'message' => $request->input('message'), 
                'email' => $request->input('email')
            ]);
     
// return response()->json([
//                 'error' => $validator->messages(),
//                 'name' => $request->input('name'),
//                 'message' => $request->input('message'),
//                 'email' => $request->input('email')
//             ]);
        }
//        $email = $request->input('email');
//        if (empty($request->input('name')) || !is_numeric($request->input('phone')) || empty($request->input('course'))) {
//            return response()->json(['result' => '<p>Vui lòng điền đầy đủ thông tin</p>', 'status' => '']);
//        }
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $message = $request->input('message');
        $currentdate = date("Y-m-d h:i:s");
        $result = $this->contact->add($name, $email, $phone,'','', $subject = "", $message, $currentdate);
        if(!$result){
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
		$data = array(
            'name' => $name,
            'email' => $email,
            'title' => 'Khach hang lien he',
            'from' => 'anhbatan@gmail.com',
            'cc' => 'duytan387.pham@gmail.com',
			'message' => $message,
            'sender' => 'VNFG'
        );
        $mail = Mail::to('emails.contact', $data, function($message) use ($data){
            $message->from('duytan387.pham@gmail.com', 'Tap doan tai chinh viet nam');
            $message->to('hovanphantestmail@gmail.com', 'Tap doan tai chinh viet nam');
            $message->bcc('duytan387.pham@gmail.com');
            $message->subject('Khach Hang Lien he');
        });
		//dd($mail);
        if(!$mail){
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
        return response()->json(['result' => '<p style="color:#28a745  !important"><i style="  font-size: 20px;  padding: 10px;" class="fas fa-check-circle"></i>Thành công! Chúng tôi sẽ liên hệ trong thời gian sớm nhất.</p>']);    
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