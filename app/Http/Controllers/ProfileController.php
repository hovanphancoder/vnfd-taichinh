<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Province;
use App\District;
use App\Customer;
use App\User;
use App\Users;
use App\Receiver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ProfileController extends Controller {

	public function __construct(Receiver $receiver, Users $users, Customer $customer, Province $province, District $district){
		$this->province = $province;
		$this->district = $district;
		$this->customer = $customer;
		$this->users = $users;
		$this->receiver = $receiver;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function register(Request $request)
	{
		//
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
			return redirect()->back()->with('status','Lỗi! Vui lòng thử lại.');
		}
		$rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|phone_count',
            'email' => 'required|email|max:255|unique:users',
            'province' => 'required',
            'quan_huyen' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|same:password'
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập Họ tên',
            'name.max' => 'Họ tên quá dài',
            'phone.required' => 'Vui lòng nhập Số điện thoại',
            'phone.numeric' => 'Vui lòng nhập chính xác Số điện thoại',
            'phone.phone_count' => 'Số điện thoại không đúng',
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Vui lòng nhập Email',
            'email.unique' => 'Email đã được đăng ký',
            'email.max' => 'Email quá dài',
            'province.required' => 'Vui lòng chọn tỉnh/thành',
            'quan_huyen.required' => 'Vui lòng chọn quận/huyện',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.confirmed' => 'Mật khẩu chưa đúng',
            // 'register_password.required_with' => 'Mật khẩu nhập lại chưa đúng',
            'password_confirmation.same' => 'Mật khẩu nhập lại chưa đúng',
            'password_confirmation.required' => 'Vui lòng điền mật khẩu',

        ];
        // them validate phone_count
        Validator::extend('phone_count', function($attribute, $value, $parameters) {
            return strlen($value) >= 10 && strlen($value) < 11;
        });
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
            		->back()
            		->with([
            			'name' => $request->input('name'),
            			'phone' => $request->input('phone'),
            			'email' => $request->input('email'),
            			'address' => $request->input('address')
            		])
            		->withErrors(
            			$validator->messages()
        			)
        	;
        }
        $input = array();
        $input['name'] = $request->input('name');
        $input['phone'] = $request->input('phone');
        $input['email'] = $request->input('email');
        $input['city'] = $request->input('province');
        $input['district'] = $request->input('quan_huyen');
        $input['address'] = $request->input('address');
        $input['customer_code'] = $request->input('customer_code');
        $input['customer_type'] = 1;
        $input['created_at'] = date("Y-m-d h:i:s");
        $input['updated_at'] = date("Y-m-d h:i:s");
        $result = Customer::create($input);
        if(!$result){
        	return redirect()->back()->with('result', 'Đã xảy ra sự cố! Vui lòng thử lại.');
        }

        // $data_receiver = array();
        // $data_receiver['name'] = $request->input('name');
        // $data_receiver['phone'] = $request->input('phone');
        // $data_receiver['province'] = $request->input('province');
        // $data_receiver['district'] = $request->input('quan_huyen');
        // $data_receiver['address'] = $request->input('address');
        // $data_receiver['ward'] = '';
        // $data_receiver['active'] = 0;
        // $data_receiver['customer_id'] = $result->id;
        // $data_receiver['created_at'] = date("Y-m-d h:i:s");
        // $data_receiver['updated_at'] = date("Y-m-d h:i:s");
        // $result_receiver = $this->receiver->insert_receiver($data_receiver);
        // if(!$result_receiver){
        //     return redirect()->back()->with('result', 'Lỗi! Vui lòng thử lại');
        // }


        $user = array();
        $user['name'] = $request->input('name');
        $user['password'] = bcrypt($request->input('password'));
        $user['email'] = $request->input('email');
        $user['phone'] = $request->input('phone');
        $user['image'] = 'defaultimage.jpg';
        $user['status'] = 0;
        $user['active'] = 0;
        $user['group_id'] = 3;
        $user['customer_id'] = $result->id;
        $user['created_at'] = date("Y-m-d h:i:s");
        $user['updated_at'] = date("Y-m-d h:i:s");
        $result_user = User::create($user);



        if(!$result_user){
        	return redirect()->back()->with('result', 'Đã xảy ra sự cố! Vui lòng thử lại.');
        }
		// if(empty($request->input('name'))){
		// 	Session::flash('status', 'Vui lòng nhập họ tên.');
		// }
		// Session::flash('status', 'Vui lòng nhập họ tên.');
		// echo "dasdasda";
		// exit;
		return redirect()->route('f.login');
		
	}

	public function getDistrict(Request $request){
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        $province_id = $request->input('province_id');
		if(!$province_id){
			return response()->json([
				'result' => 'Lỗi! Không có quận huyện.',
			]);
		}
		$district = $this->district->getDistrict($province_id);
		if(!$district){
			return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
		}
		// $this->province->getProvince();
		return response()->json([
            'result' => 'Thành Công',
            'district' => $district
        ]);
		// return $district;
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function login(Request $request)
	{
		dd('dasd');
		//
        if (Auth::check()) {
            // The user is logged in...         
            return redirect()->to('/');
        }
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
            return redirect()->back()->with('result', 'Lỗi! Vui lòng thử lại.');
        }
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
        $messages = [
            'email.email' => 'Email không đúng định dạng',
            'email.required' => 'Vui lòng nhập Email',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn'

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
            		->back()
            		->withErrors(
            			$validator->messages()
        			)
        	;
        }
        // bat buoc ten file la password va password_confirmation
        $email = $request->input('email');
        $password = $request->input('password');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
        	Session::put('user_status', 1);
        	return redirect()->to('/');
        }
        return redirect()->back()->with('result', 'Lỗi! Vui lòng thử lại.');

	}

	public function edit(Request $request){
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
            Session::flash('result', '<i class="fa fa-exclamation"></i> Lỗi! Vui lòng thử lại.');
            return redirect()->back();
        }
		$rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|phone_count',
            'province' => 'required',
            'quan_huyen' => 'required',
            // 'password' => 'required|confirmed|min:6',
            // 'password_confirmation' => 'required|same:password'
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập Họ tên',
            'name.max' => 'Họ tên quá dài',
            'phone.required' => 'Vui lòng nhập Số điện thoại',
            'phone.numeric' => 'Vui lòng nhập chính xác số điện thoại',
            'phone.phone_count' => 'Số điện thoại không đúng',
            'province.required' => 'Vui lòng chọn tỉnh/thành',
            'quan_huyen.required' => 'Vui lòng chọn quận/huyện',
            // 'password.required' => 'Vui lòng nhập mật khẩu',
            // 'password.min' => 'Mật khẩu quá ngắn',
            // 'password.confirmed' => 'Mật khẩu chưa đúng',
            // 'register_password.required_with' => 'Mật khẩu nhập lại chưa đúng',
            'password_confirmation.same' => 'Mật khẩu nhập lại chưa đúng',
            'password_confirmation.required' => 'Vui lòng điền mật khẩu',

        ];

        Validator::extend('phone_count', function($attribute, $value, $parameters) {
            return strlen($value) >= 10 && strlen($value) < 11;
        });
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
            		->back()
            		->with([
            			'name' => $request->input('name'),
            			'phone' => $request->input('phone'),
            			'email' => $request->input('email'),
            			'address' => $request->input('address')
            		])
            		->withErrors(
            			$validator->messages()
        			)
        	;
        }

        // $user = Customer::find();
        // $user['name'] = $request->input('name');
        // $user['password'] = bcrypt($request->input('password'));
        // $user['email'] = $request->input('email');
        // $user['phone'] = $request->input('phone');
        // $user['image'] = 'defaultimage.jpg';
        // $user['status'] = 1;
        // $user['group_id'] = 3;
        // $user['customer_id'] = $result->id;
        // $user['created_at'] = date("Y-m-d h:i:s");
        // $user['updated_at'] = date("Y-m-d h:i:s");
        // $result_user = User::create($user);
        // echo $request->input('customer_id');exit;
        $getCustomer = $this->customer->getCustomer($request->input('customer_id'), ['id']);
        if(!$getCustomer){
            Session::flash('result', '<i class="fa fa-exclamation"></i> Tài khoản chưa đăng ký');
            return redirect('/');
        }
        // dd($getCustomer->id);
        $data_customer = [
        	'name' => $request->name,
        	'phone' => $request->phone,
        	'address' => $request->address,
        	'city' => $request->province,
        	'district' => $request->quan_huyen,
        	'updated_at' => date("Y-m-d h:i:s")
        ];
        $result_customer = $this->customer->updateCustomer($getCustomer->id, $data_customer);

        if(!$result_customer){
            Session::flash('result', '<i class="fa fa-exclamation"></i> Đã xảy ra sự cố! Vui lòng thử lại.');
        	return redirect()->back();
        }
        $data_user = [
        	'name' => $request->name,
        	'image' => 'defaultimage.jpg',
        	'updated_at' => date('Y-m-d h:i:s')
        ];
        if($request->password && $request->password == $request->password_confirmation){
        	$data_user['password'] = bcrypt($request->password);
        }
        // dd($data_user);

        $result_user = $this->users->updateUser($request->user_id, $data_user);
        if(!$result_user){
            Session::flash('result', '<i class="fa fa-exclamation"></i> Đã xảy ra sự cố! Vui lòng thử lại.');
        	return redirect()->back();
        }
        Session::flash('result', '<i class="fa fa-check"></i> Cập nhật tài khoản thành công.');
		return redirect()->back();
	}

	public function logout() {
        if (Auth::check()) {
            Auth::logout();
            Session::forget('user_status');
            // Session::flush();
            return redirect('/');
        }
    }

}
