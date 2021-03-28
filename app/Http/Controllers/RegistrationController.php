<?php
 
namespace App\Http\Controllers;
 
use App;
use App\Province;
use App\District;
use App\Ward;
use App\User;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
 
class RegistrationController extends AppController
{
	 public function __construct() {
	 	// dd(Hash::make('tanWeb@387'));
  //       parent::__construct();
		// if(is_null(session('locale')))
		// {
		// 	if(App::getLocale() == '') $t = 'en';else $t = App::getLocale();
		//   session(['locale'=> $t]);
		// }
		// app()->setLocale(session('locale'));
    }
    public function create()
    { 
		$province = Province::get();
        return view('register.register',[
            'province' => $province
        ]);
    }
	public function getDistrict($id)
    {
        $district = District::where('province_id', $id)->get();

        return $district;
    }
	public function getWard($id)
    {
        $district = Ward::where('_district_id', $id)->get();

        return $district;
    }
	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
	public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'phone'=>'required',
            'password' => 'required|string|min:6|confirmed',
			'password_confirmation'=>'required|same:password',
        ]);
        
        $customer = Customer::create([
            'name' => $request->company,
            'contact' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'ward' => $request->ward,
            'district' => $request->district,
            'city' => $request->city,
        ]);
        $user = User::create([
            'name' => $customer['_customer_id'],
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 1,// customer active luon
            'group_id' => 3,// customer
            'password' => bcrypt($request->password),
        ]);
        auth()->login($user);
        
        return redirect()->to('/');
    }
	public function login(Request $request) {
		// dd(bcrypt('tanWeb@387'));
		if (Auth::check()) {
            // The user is logged in...

            return redirect()->to('/');
        }
        $rules = array(

            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 6 characters

        );
        $messages = [
            'email.required' => 'Please fill email',
            'email.email' => 'The email incorrect',
            'password.required' => 'The password incorrect',
            'password.min' => 'The password is too weak'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->back()->withError($validator);
        }
        $email = $request->input('email');
        $password = $request->input('password');
        // $credentials = [];
        // $credentials['email'] = $request->email;
        // $credentials['password'] = Hash::make($request->password);
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
        	return redirect('your-selection');
        }
        return redirect()->back()->with(['result' => 'Error!']);
        
        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        // 	dd('dasdas');
        //     Session::flash('status', 'Login Success');
        //     return redirect('/');

        // } else {
        //     Session::flash('status', 'Login Failed');
        //     return redirect()->to('/');
        // }
    }

    public function logout() {
        if (Auth::check()) {
            Auth::logout();
            Session::flush();
            return redirect('/');
        }
    }
}

