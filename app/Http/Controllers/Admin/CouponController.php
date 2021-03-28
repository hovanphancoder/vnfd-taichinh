<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Coupon;
use App\Products;
use App\ProductType;
use Session;
use Validator;

use Illuminate\Http\Request;

class CouponController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$list = Coupon::orderby('created_at','desc')->get();
		return view('admin.coupon.list',[
			'list' => $list,
		]);
	}

	public function add(Request $request){
		// dd($request->all());
		$item = $request->all()?$request->all():'';
		$categoryProduct = ProductType::orderby('name','asc')->get();
		return view('admin.coupon.add',[
			'item' => $item,
			'categoryProduct' => $categoryProduct
		]);
	}

	public function getProductCategory(Request $request){
		// if($request->isMethod('post') || $request->isMethod('POST')){
		// 	return response()->json([
		// 		'result' => 'Error! Try agains'
		// 	]);
		// }
		if($request->type_discount === 'c_'){
			$result = ProductType::orderby('name','asc')->get();
		}elseif($request->type_discount === 'p_'){
			$result = Products::orderby('name','asc')->get();
		}else{
			$result = ProductType::orderby('name','asc')->get();
		}
		// $categoryProduct = ProductType::orderby('name','desc')->get();
		if(!$result){
			return response()->json([
				'result' => 'Error! Try again.'
			]);
		}
		return response()->json([
			'result' => 'Success!',
			'result_type_discount' => $result,
			'type_discount' => $request->type_discount
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		if(!$request->isMethod('post') || !$request->isMethod('Post')){
			return redirect()->back()->with('status', 'Try again!');
		}
		$rules = [
            'code' => 'required|max:100',
            'value' => 'required|numeric',
            'quantity' => 'required|numeric|max:255',
            'type_unit' => 'required',
            'type_discount' => 'required'
        ];
        $messages = [
            'code.required' => 'Please fill code',
            'code.max' => 'Code is too long',
            'value.required' => 'Please fill value',
            'value.numeric' => 'Please fill numeric',
            'type_unit.required' => 'Please chosen fill unit',
            'type_discount.required' => 'Please chosen type discount',
            
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator->messages());
        }
        if($request->type_discount == 'none'){
        	$type_discount = "none";
        }else{
			$type_discount = $request->type_discount . $request->select_type_discount;
        }
		$data = [];
		$data['code'] = $request->code;
		$data['value'] = $request->value;
		$data['quantity'] = $request->quantity;
		$data['type_unit'] = $request->type_unit;
		$data['type_discount'] = $type_discount;
		$query = Coupon::create($data);
		if(!$query){
			return redirect()->back()->with('status', 'Try again!');
		}
		return redirect('admin/voucher/list')->with('status', 'Success!');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		// echo $id;
		$item = Coupon::findOrFail($id);
		// $result = json_decode($item['type_discount']);
		// dd($item->toArray());
		$type_coupon = ProductType::orderby('name','asc')->get();
		if(!$item){
			return redirect()->back()->with('status','Error! Try again.');
		}
		return view('admin.coupon.view',[
			'item' => $item,
			'type_coupon' => $type_coupon
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, $id)
	{
		//
		// dd($request->value);
		
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
			return redirect()->back()->with('status','Error! Try again.');
		}
		$request->value = $request->value?str_replace(',','',$request->value):0;
		$rules = [
            'code' => 'required|max:100',
            // 'value' => 'required|numeric',
            'quantity' => 'required|numeric|max:255',
            'type_unit' => 'required',
            'type_discount' => 'required'
        ];
        $messages = [
            'code.required' => 'Please fill code',
            'code.unique' => 'The code must is unique',
            'code.max' => 'Code is too long',
            'value.required' => 'Please fill value is require',
            'value.numeric' => 'The value must is numeric',
            'type_unit.required' => 'Please chosen fill unit',
            'type_discount.required' => 'Please chosen type discount',
            
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator->messages());
        }
		$item = Coupon::findOrFail($id);
		if(!$item){
			return redirect()->back()->with('status','Error! Coupon not exist.');
		}
		$result_type_discount = "";
		// dd($result_type_discount);
		if($request->type_discount == 'null'){
        	$result_type_discount = "null";
        	// dd($result_type_discount);
        }else{
        	$array_discount = array();
        	$type_discount = substr($request->type_discount, 0, -1);
        	if($request->select_type_discount != 'null'){
        		foreach($request->select_type_discount as $item_select_type_discount){
	        		$select_type_discount[] = (int)$item_select_type_discount;
	        	}
        	}
        	// dd($select_type_discount);
			$array_discount[$type_discount] = $select_type_discount;
			// dd($array_discount);
			$result_type_discount = json_encode($array_discount);
        }
			// dd($result_type_discount);
        	// dd($request->select_type_discount);
        if($request->type_unit == 'percent' && $request->value > 100){
        	return redirect()->back()->with('status', 'Error! Fixed type unit must be less than 100%.');
        }
        if($request->type_unit == 'fixed' && $request->value < 50000){
        	return redirect()->back()->with('status', 'Error! Percent type unit must be more than 50,000 VND.');
        }
        // dd($type_discount);
		$item->code = $request->code;
		$item->value = $request->value;
		$item->type_unit = $request->type_unit;
		$item->type_discount = $result_type_discount;
		$item->quantity = $request->quantity;
		// dd($item->toArray());
		$result = $item->save();
		if(!$result){
			return redirect()->back()->with('status','Error! Try again.');
		}
		return redirect()->back()->with('status','Success.');

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$item = Coupon::find($id);
		
	}

}
