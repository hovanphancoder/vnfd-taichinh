<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Orders;
use App\Province;
use App\District;
use App\Users;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class CustomerController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    public function index(Request $request) {
        // dd('dasda');
        if($request->type){
            // return redirect()->back()->with(['result' => 'Error! Try again']);
            $customer = Customer::where('customer_type', $request->type)->get();
            // dd($customer->toArray());
            return view('admin/customer/list', [
                'customerlist' => $customer
            ]);
        }
        
        return view('admin/customer/list', [
            'customerlist' => $this->customer->getAdminListCustomer()
        ]);
    }

    public function getListScreenshot() {
//        $customer = new Screenshot();
//        return $customer->getAdminListScreenshot();
    }

    public function getAllCustomer(){
        $listCustomer = Customer::OrderBy('name','desc')->get()->toArray();
        return response()->json([
            'listCustomer' => $listCustomer
        ]);
    }

    public function add() {
		$data['province'] = Province::get();
        $data['district'] = District::get();
        return view('admin/customer/add',$data);
    }

    public function doAdd(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back()->with(['result' => 'Error! Try again.']);
        }
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'district' => 'required',
            'province' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is registed',
            'phone.required' => 'Phone is required',
            'district.required' => 'District is required',
            'province.required' => 'City is required',
        ];

        $item = Customer::where('email',$request->email)->first();
        if($item){
            return redirect()->back()->with(['result' => 'Email registed!']);
        }

        $data['email'] = $request->email;
 
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $data = [];
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/customer';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = "defaultimage.jpg";
        }
        $data['name'] = $request->name;
        
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['company'] = $request->company;
        $data['mst'] = $request->mst;
        $data['city'] = $request->province;
        $data['district'] = $request->district;
        $data['customer_code'] = $request->customer_code;
        $data['customer_type'] = 1;
        $data['app_code'] = $request->app_code;
        $data['app_name_vi'] = $request->app_name_vi;
        $data['app_name_en'] = $request->app_name_en;
        $data['tel'] = $request->tel;
        $data['fax'] = $request->fax;
        $data['contact'] = $request->contact;
        $data['position'] = $request->position;
        $data['notes'] = $request->notes;
        $data['image'] = $image;

        $result = Customer::create($data);
        if(!$result){
            return redirect()->back()->with(['result' => 'Error! Try again.']);
        }
        // Session::flash('status', 'Success.');
        return redirect('admin/customer/view/' . $result->id)->with(['result' => 'Success.']);
    }

    public function quicklyAdd(Request $request){
        if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
        $rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|phone_count',
            'email' => 'required|email',
        ];
        $messages = [
            'name.required' => 'Vui lòng nhập họ tên',
            'name.max' => 'Họ tên quá dài',
            'email.required' => 'Vui lòng nhập địa chỉ Email',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.phone_count' => 'Số điện thoại không đúng',
            'phone.numeric' => 'Vui lòng nhập chính xác số điện thoại',
        ];
        // them validate phone_count
        Validator::extend('phone_count', function($attribute, $value, $parameters) {
            return strlen($value) >= 10 && strlen($value) < 11;
        });
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator->messages());
        }
        $data = [];
        $data['name'] = $request->input('name');
        $data['phone'] = $request->input('phone');
        $data['email'] = $request->input('email');
        $data['message'] = $request->input('message');
        $data['tel'] = $request->input('tel');
        $data['position'] = $request->input('position');
        $data['address'] = $request->input('address');
        $data['city'] = $request->input('province');
        $data['district'] = $request->input('district');
        $data['customer_id'] = $request->input('customer_id');
        $result = Customer::create($data);
        if(!$result){
            Session::flash('result','Error! Please try again.');
            return redirect()->back();
        }
        // Neu co status khac rong thi dang ky thanh cong
        Session::flash('result','Success.');
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
        //  lay danh sach id
        $item = Customer::findOrFail($id);
        if(!$item){
            Session::flash('result','Customer is not exists.');
            return redirect()->back();
        }
        $data['province'] = Province::get();
		$data['district'] = District::get();
		
        return view('admin/customer/view', [
            'viewcustomer' => $this->customer->viewCustomer($id),
            'province' => $data['province'],
            'district' => $data['district']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $cus = Customer::find($id);
        if(!$cus){
            return redirect()->back()->with(['result' => 'Erorr! Customer is not exist.']);
        }
        $name = $request->input('name');
        $position = $request->input('position');
        $comment = $request->input('comment');
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/customer';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('currentfile');
        }
		$cus->name = $request->name;
		$cus->email = $request->email;
		$cus->phone = $request->phone;
        $cus->address = $request->address;
        $cus->company = $request->company;
		$cus->mst = $request->mst;
        $cus->city = $request->province;
		$cus->district = $request->district;
        $cus->customer_code = $request->customer_code;
		$cus->customer_type = 1;
		$cus->app_code = $request->app_code;
		$cus->app_name_vi = $request->app_name_vi;
		$cus->app_name_en = $request->app_name_en;
		$cus->tel = $request->tel;
		$cus->fax = $request->fax;
		$cus->contact = $request->contact;
		$cus->position = $request->position;
		$cus->notes = $request->notes;
		$cus->image = $image;
		$result = $cus->save();
        if(!$result){
            return redirect()->back()->with(['result' => 'Success.']);
        }
        return redirect('admin/customer/view/' . $id)->with(['result' => 'Success.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        // kiem tra id co ton tai trong table
        // if (!in_array($id, $listid)) {
            // return redirect()->back();
        // }
		
		$viewItem = Customer::find($id);
		//kiem tra id product co ton tai trong order
		$check = Orders::where('customer_id',$id)->get();
		
		if(count($check)==0)
			$result = $viewItem->delete(); 
        if (isset($result)) {
            Session::flash('status', 'Success!');
        } else {
            Session::flash('status', 'Failed! This item maybe using');
        }
        // $this->customer->delCustomer($id);
        // Session::flash('status', 'Xóa bài viết thành công');
        return redirect()->back();
    }

	public function import() {

        return view('admin/customer/import');
    }

	public function doImport(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/customer/import");
        }
        $rules = [
            'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
		$get=$request->all();
		if (isset($get["file"]))
		{ 
			  if($request->hasFile('file')){
					$path = $request->file('file')->getRealPath();
					ob_end_clean();
					ob_start();
					 $data = Excel::selectSheetsByIndex(0)->load($path,'UTF-8')->get();

					if(!empty($data) && $data->count()){ 
						foreach ($data as $key => $value) {
							//check email đã tồn tại chưa
							$email = Customer::where('email',$value['email'])->get()->toArray();
							//echo '<pre>';print_r(count($email));exit;
							if(count($email)!=1){
								$insert_data = [
									'customer_id' => $value['id'],
									'app_code' => $value['group'],
									'name' => $value['name'],
									'app_name_en' => $value['apps'],
									'address' => $value['address'],
									'city' => $value['town_city'],
									'tel' => $value['tel'],
									'fax' => $value['fax'],
									'contact' => $value['contact'],
									'phone' => $value['mobile'],
									'email' => $value['email']
								];
								if(!empty($insert_data))
								  {
								   DB::table('customer')->insert($insert_data);
								  }
						   }
						}

					 }
					 //return back()->with('success', 'Excel Data Imported successfully.');
					}
			  }
		else
		  { 
				$type = "error";
				$message = "Invalid File Type. Upload Excel File.";
		  }
		
        Session::flash('status', 'Excel Data Imported successfully!');
        return redirect('admin/customer/import');
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
        $listDistrict = District::where('province_id', $province_id)->get()->toArray();
        if(!$listDistrict){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        return response()->json([
            'result' => 'Thành Công',
            'listDistrict' => $listDistrict
        ]);
    }

    public function export(Request $request){
        ob_end_clean();
        ob_start();
        $customer_type = $request->type;
        $customerList = $this->customer->filter($request->type);
        Excel::create('Customer', function($excel) use ($customerList) {

            $excel->sheet('list', function($sheet) use ($customerList) {

                $sheet->row(1, array(
                     'NO.','CUSTOMER CODE', 'NAME', 'PHONE', 'EMAIL','ADDRESS','DISTRICT','CITY'
                ));
                foreach($customerList as $key => $item){
                    $sheet->row(($key + 2), array(
                        $key + 1,
                        $item->customer_code,
                        $item->name,
                        $item->phone,
                        $item->email,
                        $item->address,
                        $item->district_name,
                        $item->province_name
                    ));
                }

            });

        })->export('xls');
    }

    public function getPhoneNumber(Request $request){
        if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
        $phone = $request->input('phone');
        if(!$phone){
            return response()->json(['result' => 'Error, try again!']);
        }
        $customer = Customer::where('phone',$phone)->first();
        if(!$customer){
            return response()->json(['result' => 'Customer not exist!']);
        }
        $listDistrict = District::where('province_id', $customer->city)->get()->toArray();
        $listCity = Province::OrderBy('name','asc')->get()->toArray();
        if(!$listDistrict){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        return response()->json([
            'customer' => $customer,
            'listDistrict' => $listDistrict,
            'listCity' => $listCity,
            'id_city' => $customer->city,
            'id_district' => $customer->district
        ]);
    }

}
