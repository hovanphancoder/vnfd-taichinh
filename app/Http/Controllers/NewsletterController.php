<?php



namespace App\Http\Controllers;



use App\NotificationRegister;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use App\Newsletter;

use DateTime;

use Mail;





class NewsletterController extends AppController {

    public function __construct(Newsletter $newsletter) {

        parent::__construct();

        $this->newsletter = $newsletter;

    }



    public function setNewsletter(Request $request) {



        if(!$request->isMethod('get') || !$request->isMethod('GET')){

		
            return redirect()->back()->with(['result'=>'vui lòng điền email']);

        }

        $rules = [

            'email' => 'required|email|unique:newletter,email'

        ];

		$messages = [

            'email.required' => 'Vui lòng nhập email',

            'email.email' => 'email không đúng định dạng',

            'email.unique' => 'Email đã được đăng ký'

        ];

		

		// them validate phone_count

        // Validator::extend('phone_count', function($attribute, $value, $parameters) {

        //     return strlen($value) >= 10 && strlen($value) < 11;

        // });

		

		$validator = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
      

        }

        $email = $request->input('email');

        $currentDate = date("Y-m-d h:i:s");

        $this->newsletter->createForm($email, $currentDate);

		/* Setting Mail*/



        //$mail = new Setting();        

		//$sendmail = $mail->getMail();

        //$config = json_decode($sendmail->config);



        Session::flash('result', 'Chúng tôi đã nhận được yêu cầu . Cám ơn bạn!');

        return redirect()->back();



    }

    public function subcribe(Request $request){
    //    $b=$request->method();
        if(!$request->isMethod('get') || !$request->isMethod('GET')){
            return response()->json(['result'=>'lỗi phương thức']);
        }
        $email=$request->input('email');
        
        // // check email rong ->email rong
        // if($email==''){
        //     return response()
        //     ->json([
        //         'result'=>'email rong'
        //     ]);
        // }
        
        // $check=strpos($email,'@');
        // if($check==false){
        //     return response()->json([
        //                     'result'=>'email ko hop le'
        //                 ]);
        // }
        //   $a='1'; 
        //   $c=['s','ss'];
        $rules=[
            'email'=>'required|email|unique:newsletter,email|max:255'
        ];
        $messages=[
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',
            'email.max' =>'Email quá ký tự quy định'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['result'=> $validator->errors()]);
        }

        $currentDate = date("Y-m-d h:i:s");
        $this->newsletter->createForm($email, $currentDate);
         return response()->json(['result'=> 'Thành công']);
        }
    





    /**



     * Store a newly created resource in storage.



     *



     * @return Response



     */



    public function create(Request $request) {



        //

        if(!$request->isMethod('post') || !$request->isMethod('POST')){

            Session::flash('status', 'Vui lòng điền đây đủ thông tin');

            return redirect()->back();

        }

        $rules = [

            'email' => 'required'

        ];

        $messages = [

            'email.required' => 'Vui lòng nhập email'

        ];

        

        $validator = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {

            Session::flash('status', 'Email chưa đúng!');

            //return redirect()->back()->withErrors($validator->errors());

            return redirect()->back();

        }

        $email = $request->input('email');

        $date = date("Y-m-d H:i:s");

        $result = $this->newsletter->createForm($email, $date);

        if(!$result){

            Session::flash('status', 'Vui lòng thử lại!');

            return redirect()->back();

        }

        Session::flash('status', 'Đăng ký thành công!');

        return redirect('thong-bao');



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