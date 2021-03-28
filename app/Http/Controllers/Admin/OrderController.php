<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\OrderDetail;
use App\Orders;
use App\OrderOption;
use App\Products;
use App\Customer;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Option;
use App\OptionValue;
use App\ProductOption;
use App\ProductOptionValue;
use App\Unit;
use Illuminate\Support\Facades\Auth;
use App\Traits\LocateTrait;
use App\District;
use PDF;
use Excel;

class OrderController extends Controller {
    use LocateTrait;
//    public function __construct(Orders $orders, Customer $customer) {
//        $this->orders = $orders;
//        $this->customer = $customer;
//    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        //
        $orders = Orders::with('customer')
                    ->where('order_type','invoices')
                    ->orderBy('created_at', 'desc')
                    ->get()->toArray();
		$d = Orders::join('customer','customer.id','=','orders.customer_id')
                ->select('*','orders.id as order_id','customer.id as cus_id')
                ->where('order_type','invoices');
		$get = $request->all();
		$data['payment_method'] = '';
		$data['price'] = '';
		if(isset($get['keyword']) && $get['keyword'] != ''){
           $d = $d->where('customer.name','like','%'.$get['keyword'].'%');
		   $data['keyword'] = $get['keyword'];		   
        }
		if(isset($get['payment_method']) && $get['payment_method'] != ''){
           $d = $d->where('payment_method',$get['payment_method']);
		   $data['payment_method'] = $get['payment_method'];		   
        }
		if(isset($get['price']) && $get['price'] != ''){
           $d = $d->orderBy('total_price',$get['price']);
		   $data['price'] = $get['price'];		   
        }
		$data['orders'] = $d->orderBy('orders.created_at', 'desc')->paginate(25);
		//echo '<pre>';print_r($data['orders']);exit;
        return view('admin.order.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function orderDetail(Request $request, $id) {
        //
        // echo $request->input('client_id');exit;
        if(!$request->has('client_id')){
            Session::flash('status','Customer not exist!');
            return redirect()->back();
        }
        $goCity = $this->goCity();
        
        // dd($goDistrict);
		$products = Products::get();
		$product1 = Products::get();
        $orderDetail = OrderDetail::with('product')->where('order_id', $id)->get()->toArray();
        // dd($orderDetail);
        $customer = Customer::find($request->input('client_id'));
        if(!$customer){
        	Session::flash('status','Customer not exist!');
        	return redirect()->back();
        }
        $goDistrict = $this->goDistrict($customer['city']);
        $orders = Orders::find($id);
        if(!$orders){
        	Session::flash('status','Order not exist!');
        	return redirect()->to('admin/order/list');
        }
        // dd($orders['receiver_id']);
        $receiver = Customer::find($orders['receiver_id']);
        // dd($receiver);
        $goDistrictReceive = $this->goDistrict($receiver['city']);
		if(isset($orders)) $orders = $orders->toArray();
		else return redirect('admin/order/list');
		
		$customers = Customer::get();
        return view('admin.order.view',[
            'orderDetail' => $orderDetail,
            'customer' => $customer,
            'receiver' => $receiver,
            'customers' => $customers,
            'products' => $products,
            'product1' => $product1,
            'countpro' => count($orderDetail),
            'orders' => $orders,
            'goCity' => $goCity,
            'goDistrict' => $goDistrict,
            'goDistrictReceive' => $goDistrictReceive
        ]);
    }
    
    public function orderUpdate(Request $request, $id) {
    	// dd('dasda');
    	if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try again!');
            return redirect()->back();
        }
        $order = Orders::find($id);
        // dd($order->toArray());
        if(!$order){
        	Session::flash('status', 'Order not exist!');
            return redirect()->back();
        }
        // dd($order->toArray());
		$data = $request->all();
		$input["product"] = $request->input('product');
		$data_customer_receive = Customer::find($order->receiver_id);;
		$data_customer = Customer::find($order->customer_id);
		// dd($data_customer);
		$data_customer->phone = $request->input('phone');
        $data_customer->name = $request->input("name");
        $data_customer->email = $request->input("email");
        $data_customer->address = $request->input("address");
        $data_customer->city = $request->input("province");
        $data_customer->district = $request->input("district");
        $data_customer->customer_code = $request->input("customer_code");
        $data_customer->customer_type = 1;
        $result_customer = $data_customer->save();
        if(!$result_customer){
            Session::flash('status', 'Not create customer!');
            return redirect()->back();
        }
        // dd($data_customer_receive->toArray());
        if($request->receive_group == 1 && $request->input('phone_receive')){
        	// dd($data_customer_receive->toArray());
            $data_customer_receive->phone = $request->input('phone_receive');
            $data_customer_receive->name = $request->input("name_receive");
            $data_customer_receive->email = $request->input("email_receive");
            $data_customer_receive->address = $request->input("address_receive");
            $data_customer_receive->city = $request->input("province_receive");
            $data_customer_receive->district = $request->input("district_receive");
            $data_customer_receive->customer_code = $request->input("customer_receive_code");
            $data_customer_receive->customer_type = 2;
            $result_customer_receive = $data_customer_receive->save();
            if(!$result_customer_receive){
                Session::flash('status', 'Not create receive customer!');
                return redirect()->back();
            }
        }
		// echo '<pre>';
		
		// print_r($data);
        // echo "</pre>";
        // exit;
        $order->status = $request->input('status');
        $order->customer_id = $order->customer_id;
        $order->payment_method = $request->input('payment_method');
        $order->total_price = $request->input('total');
        $order->gtgt = $request->input('gtgt')?$request->input('gtgt'):0;
        $order->discount_percent = $request->input('discount');
        $order->subtotal = $request->input('subtotal');
        $order->order_date = $request->input('order_date');
        $order->notes = $request->input('notes');
		
        $order->save();
		
		if ($order) {
			//update order detail
			if(isset($input['product'])){
				OrderDetail::where('order_id',$id)->delete();
				OrderOption::where('order_id',$id)->delete();
				foreach ($input['product'] as $product) {
					if(isset($product['product_id'])){
						
						//xoá, tạo mới
						
						$input["order_id"] = $order['id'];
						$input["product_id"] = $product['product_id'];
						$input["unit_price"] = $product['dg'];
						$input["quantity"] = $product['sl'];
						$order_detail = OrderDetail::create($input);
						
					}
					
					//update order option
					if(isset($product['option'])){
						foreach ($product['option'] as $option) {
							//xoá, tạo mới
							$in["order_id"] = $order['id'];
							$in["order_product_id"] = $product['product_id'];
							$in["product_option_id"] = $option['product_option_id'];
							$in["product_option_value_id"] = $option['product_option_value_id'];
							$in["name"] = $option['name'];
							$in["value"] = $option['value'];
							$in["type"] = $option['type'];
							$order_option = OrderOption::create($in);
						}
					}

				}

			}
			Session::flash('status', 'Success!');
			return redirect('admin/order/view/' . $order['id'].'?client_id='.$request->input('client_id'));

		}
		Session::flash('status', 'Failed!');
        return redirect()->back();
      
    }
	public function addOrder() {
		// Get trait city
		$goCity = $this->goCity();
		$products = Products::get();
		$product1 = Products::get();
        $customer = Customer::OrderBy('name','asc')->get();
        return view('admin.order.add',[
            'customers' => $customer,
            'products' => $products,
            'product1' => $product1,
            'goCity' => $goCity
        ]);
    }
	
	public function doAddOrder(Request $request) {
		if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try again!');
            return redirect()->back();
        }
        $order_count = Orders::count() + 1;
		$data = $request->all();
        $data_customer_receive = [];
		$data_customer = [];
        $data_customer["phone"] = $request->input('phone');
        $data_customer["name"] = $request->input("name");
        $data_customer["email"] = $request->input("email");
        $data_customer["address"] = $request->input("address");
        $data_customer["city"] = $request->input("province");
        $data_customer["ward"] = 0;
        $data_customer["district"] = $request->input("district");
        $data_customer["customer_code"] = $request->input("customer_code");
        $data_customer["customer_type"] = 1;
        $data_customer["image"] = "defaultimage.jpg";
        $result_customer = Customer::create($data_customer);
        if(!$result_customer){
            Session::flash('status', 'Not create customer!');
            return redirect()->back();
        }
        if($request->receive_group == 1 && $request->phone_receive){
            $data_customer_receive["phone"] = $request->input('phone_receive');
            $data_customer_receive["name"] = $request->input("name_receive");
            $data_customer_receive["email"] = $request->input("email_receive");
            $data_customer_receive["address"] = $request->input("address_receive");
            $data_customer_receive["city"] = $request->input("province_receive");
            $data_customer_receive["ward"] = 0;
            $data_customer_receive["district"] = $request->input("district_receive");
            $data_customer_receive["customer_code"] = $request->input("customer_receive_code");
            $data_customer_receive["image"] = "defaultimage.jpg";
            $data_customer_receive["customer_type"] = 2;
            $result_customer_receive = Customer::create($data_customer_receive);
            if(!$result_customer_receive){
                Session::flash('status', 'Not create receive customer!');
                return redirect()->back();
            }
        }


        // dd($result_customer_receive['id']);

		$input["product"] = $request->input('product');
//        dd($input["product"]);

		$input["customer_id"] = $result_customer['id'];
		$input["receiver_id"] = isset($result_customer_receive)?$result_customer_receive['id']:$result_customer['id'];
		$input["order_number"] = "nt_".$order_count;
		$input["payment_method"] = $request->input('payment_method');
		$input["total_price"] = $request->input('total')?(float)$request->input('total'):0;
		$input["gtgt"] = $request->input('gtgt')?$request->input('gtgt'):0;
        $input["order_address"] = $request->input('phone_receive')?1:0;
		$input["discount_percent"] = $request->input('discount');
		$input["subtotal"] = $request->input('subtotal')?(float)$request->input('subtotal'):0;
        $input["delivery_date"] = date("Y-m-d h:i:s");
        $input["created_at"] = date("Y-m-d h:i:s");
		$input["updated_at"] = date("Y-m-d h:i:s");
		$input["status"] = $request->input('status');
		$input["notes"] = $request->input('notes')?$request->input('notes'):"";
		$order = Orders::create($input);
		
		if ($order) {
			//order detail
			if(isset($input['product'])){
				foreach ($input['product'] as $product) {
					if(isset($product['product_id'])){
						$input["order_id"] = $order['id'];
						$input["product_id"] = $product['product_id'];
                        $input["unit_price"] = $product['dg'];
						$input["promotion_price"] = 0;
						$input["quantity"] = $product['sl'];
						$order_detail = OrderDetail::create($input);
						if(!$order_detail){
                            Session::flash('status', 'Not create order detail!');
						    return redirect()->back();
                        }
					}

					//order option
                    // dd($product['option']);
					if(isset($product['option'])){
						foreach ($product['option'] as $option) {
							$in["order_id"] = $order['id'];
							$in["order_product_id"] = $product['product_id'];
							$in["product_option_id"] = $option['product_option_id'];
							$in["product_option_value_id"] = $option['product_option_value_id'];
							$in["name"] = $option['name'];
							$in["value"] = $option['value'];
							$in["type"] = $option['type'];
							$order_option = OrderOption::create($in);
							if(!$order_option){
                                Session::flash('status', 'Not create order!');
                                return redirect()->back();
                            }
						}
					}
				}
			}
		}
        return redirect('admin/order/view/' . $order['id'].'?client_id='.$result_customer['id']);
//        return redirect()->back();
		
    }
	
	public function orderPrintPDF(Request $request,$id) {
        //
        if(!$request->has('client_id')){
            return redirect()->back();
        }
		$data['order_num'] = $id;
		$data['user'] = Auth::user()->toArray();
		$data['products'] = Products::get();
        $data['orderDetail'] = OrderDetail::with('product')->where('order_id', $id)->get()->toArray();
        
        $data['customer'] = Customer::find($request->input('client_id'))->toArray();
        $orders = Orders::find($id);
		if(isset($orders)) $data['orders'] = $orders->toArray();
		else return redirect('admin/order/list');
		
		$data['customers'] = Customer::get();
		if($request->has('lg') && $request->input('lg') == 'VI')
			$pdf = PDF::loadView('admin.order.pdfvi', $data);
		else
			$pdf = PDF::loadView('admin.order.pdfen', $data);  
        return $pdf->stream('order.pdf');
       
    }
	public function orderPrintExcel(Request $request,$id) {
        //
        if(!$request->has('client_id')){
            return redirect()->back();
        }
		$data['order_num'] = $id;
		$data['user'] = Auth::user()->toArray();
		$data['products'] = Products::get();
        $data['orderDetail'] = OrderDetail::with('product')->where('order_id', $id)->get()->toArray();
        
        $data['customer'] = Customer::find($request->input('client_id'))->toArray();
        $orders = Orders::find($id);
		if(isset($orders)) $data['orders'] = $orders->toArray();
		else return redirect('admin/order/list');
		
		$data['customers'] = Customer::get();
		if($request->has('lg') && $request->input('lg') == 'VI')
			$pdf = PDF::loadView('admin.order.pdfvi', $data);
		else
			$pdf = PDF::loadView('admin.order.pdfen', $data);  
        return $pdf->stream('order.pdf');
       
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
        $order = Orders::find($id);
        if(!$order){
            Session::flash('status','Error! Order not exist!');
            return redirect()->back();
        }
        // $order->delete();
        // echo $order['id'];
        // echo "<pre>";
        // print_r($order->toArray());
        $order->delete();
        $order_option = OrderOption::where('order_id',$order->id)->get();
        // dd($order_option->toArray());
        if(!$order_option){
            Session::flash('status','Error! Order not exist!');
            return redirect()->back();
        }
        foreach($order_option as $option){
            $option->delete();
        }
        $order_detail = OrderDetail::where('order_id',$order->id)->get();
        if(!$order_detail){
            Session::flash('status','Error! Order not exist!');
            return redirect()->back();
        }
        foreach($order_detail as $detail){
            $detail->delete();
        }
        Session::flash('status','Success! Order deteled');
        return redirect()->back();
    }
	public static function getUnit($unit_id) {
		$unit = Unit::where('id','=',$unit_id)->first()->toArray();
		//echo '<pre>';foreach($product_option_value as $i){print_r($i['name']);}exit;
		return $unit;
	}
	public static function getProductOptionValue($product_option_id) {
		$product_option_value = ProductOptionValue::join('option_value','option_value.id','=','product_option_value.option_value_id')->select('*','product_option_value.id as product_option_value_id')->where('product_option_value.product_option_id','=',$product_option_id)->get()->toArray();
		//echo '<pre>';foreach($product_option_value as $i){print_r($i['name']);}exit;
		return $product_option_value;
	}
	public function getProductOptions($product_id){
		$product_option_data = array();
		
		$product_option_query = ProductOption::select('*','product_option.id as product_option_id')->join('option','option.id','=','product_option.option_id')->where('product_id',$product_id)->get();
		
		foreach ($product_option_query as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value_query =ProductOptionValue::join('option_value','option_value.id','=','product_option_value.option_value_id')->select('*','product_option_value.id as product_option_value_id')->where('product_option_value.product_option_id','=',$product_option['product_option_id'])->get();
		
			foreach ($product_option_value_query as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'sku'                => $product_option_value['sku'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}
			
		return $product_option_data;
	}
	public function getOptionValues($option_id) {
		$option_value_data = array();
		$option_value_query = OptionValue::where('option_id',$option_id)->get();		

		foreach ($option_value_query as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}
			
		return $option_value_data;
	}
	public function getOptionValue($option_value_id) {
		
		//$option_value_query = OptionValue::join('option_value_language','option_value.id','=','option_value_language.option_value_id')->where('option_value.id',$option_value_id)->where('option_value_language.language_id',1)->get();
		$option_value_query = OptionValue::where('option_value.id',$option_value_id)->first();
		return $option_value_query;
	}
	public function getOption($option_id) {
		//$option_query = Option::join('option_language','option.id','=','option_language.option_id')->where('option.id',$option_id)->where('option_language.language_id',1)->first();
		$option_query = Option::where('option.id',$option_id)->first();
		return $option_query;
	}
	public static function getOrderOption($productid,$orderid) {
		$order_option = OrderOption::where('order_id',$orderid)->where('order_product_id',$productid)->get()->toArray();
		return $order_option;
	}
	public static function getOptionProduct($id,$orderid) {
		$optionproduct = ProductOption::where('product_id',$id)->get();			
			if(isset($optionproduct) && count($optionproduct)>0){
				foreach($optionproduct as $result){
					$option_data = array();
					$static = new OrderController;
					$product_options = $static->getProductOptions($result['product_id']);
					  foreach ($product_options as $product_option) {
						$option_info = $static->getOption($product_option['option_id']);
						$order_option = OrderOption::where('order_id',$orderid)->get()->toArray();
						//print_r($order_option);exit;
						if (isset($option_info)) {
							$product_option_value_data = array();

							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $static->getOptionValue($product_option_value['option_value_id']);
								$option_value_info1 = OptionValue::find($product_option_value['option_value_id']);
								if ($option_value_info) {
									$product_option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'price'         => $product_option_value['price'],
										'option_value_name'                    => $option_value_info1['name'],
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}

//echo '<pre>';print_r($product_option_value_data);exit;
							$option_data[] = array(
								'product_option_id'    => $product_option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $product_option['option_id'],
								'name'                 => $order_option[0]['name'],
								'type'                 => $order_option[0]['type'],
								'value'                => $order_option[0]['value'],
								'required'             => $product_option['required']
							);
						}
					}
				}
				
			}
		return $option_data[0];
	}
	public function ajaxgetoptionproduct($id) {
		
		$json = array();
		if(isset($id)){
			$optionproduct = ProductOption::where('product_id',$id)->get()->toArray();
			
			if(isset($optionproduct) && count($optionproduct)>0){
				foreach($optionproduct as $result){
					$option_data = array();
					$product_options = $this->getProductOptions($result['product_id']);
					
					  foreach ($product_options as $product_option) {
						$option_info = $this->getOption($product_option['option_id']);
						if (isset($option_info)) {
							$product_option_value_data = array();

							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = $this->getOptionValue($product_option_value['option_value_id']);
								$option_value_info1 = OptionValue::find($product_option_value['option_value_id'])->toArray();
								
								if ($option_value_info1) {
									$product_option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'price'         => $product_option_value['price'],
										'option_value_name'                    => $option_value_info1['name'],
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}


							$option_data[] = array(
								'product_option_id'    => $product_option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $product_option['option_id'],
								'name'                 => $option_info['name'],
								'type'                 => $option_info['type'],
								'value'                => $product_option['value'],
								'required'             => $product_option['required']
							);
						}
					}
				}
				$json[] = array(
					'option'     => $option_data
				);
			}
		}//echo '<pre>';print_r($json);exit('jhbjhb');
		return $json;
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
		$listDistrict = District::where('province_id', $province_id)->get();
		if(!$listDistrict){
			return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
		}
		return response()->json([
            'result' => 'Thành Công',
            'listDistrict' => $listDistrict,
            'province_id' => $province_id
        ]);
	}

}
