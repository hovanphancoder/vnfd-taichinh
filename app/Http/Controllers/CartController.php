<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Session;
use App\Customer;
use App\Orders;
use App\OrderDetail;
use App\Province;
use App\District;
use App\Cart;
use App\Receiver;
use App\Users;
use App\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends AppController {

    public function __construct(Coupon $coupon, Orders $orders, Receiver $receiver, Customer $customer, District $district, Province $province){
        $this->district = $district;
        $this->province = $province;
        $this->customer = $customer;
        $this->receiver = $receiver;
        $this->orders = $orders;
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if (!Session::has('cart')) {
            return redirect()->to('/');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('pages.giohang',[
            'cart' => Session::get('cart'), 
            'product_cart' => $cart->items, 
            'totalPrice' => $cart->totalPrice, 
            'totalQty' => $cart->totalQty
        ]);
        
    }
	
    public function getCheckout() {
        if (!Session::has('cart')) {
            return redirect()->to('/');
        }
        // dd(Auth::user());
        $province = $this->province->getProvince();
        $hcmcity = $this->district->getDistrict(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $user = array();
        $locate = array();
        if(Auth::check()){
            // dd(Auth::user()->id);
            $user = $this->customer->getCustomer(Auth::user()->customer_id,['*']);
            if(!$user){
                return redirect('/');
            }
            $locate = $this->customer->getCustomerLocate($user->city, $user->district);
        }
        // dd($user);
        // dd($locate);        
        return view('pages.checkout',[
            'province' => $province,
            'hcmcity' => $hcmcity,
            'product_cart' => $cart->items,
            'cart' => $cart,
            'user' => $user,
            'locate' => $locate
        ]);

        
    }

    public function setPayment(Request $request) {
        // dd('dasdsa');
        if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            // return redirect()->back()->with('result', 'Lỗi! Vui lòng thử lại');
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        if (!Session::has('cart')) {
            return redirect('/');
        }
        $cart = Session::get('cart');
        // dd($cart);
        $province = $this->province->getProvince();
        if(!$province){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        // Processing other address
        // dd($request->input('other_address'));
        // if($request->input('name_receiver')){
        //     return '';
        // }
        if(Auth::check()){
            // dd('dasda');            
                $input_order = array();
            if($request->input('other_address') != null){
                $rules = [
                    'name' => 'required|max:255',
                    'email' => 'email|unique:users,email',
                    'phone' => 'required|phone_count|numeric',
                    'address' => 'required|max:255',
                    'province' => 'required',
                    'quan_huyen' => 'required',
                ];
                $messages = [
                    'name.required' => 'Vui lòng nhập họ tên người nhận',
                    'name.max' => 'Họ tên người nhận quá dài',
                    'email.max' => 'Email người nhận quá dài',
                    'email.unique' => 'Email đã được đăng ký',
                    'phone.required' => 'Vui lòng nhập số điện thoại của người nhận',
                    'phone.phone_count' => 'Số điện thoại người nhận không đúng',
                    'phone.numeric' => 'Số điện thoại phải là số',
                    'address.required' => 'Vui lòng nhập địa chỉ người nhận',
                    'address.max' => 'Địa chỉ người nhận quá dài',
                    'province.required' => 'Vui lòng chọn Tỉnh/Thành người nhận',
                    'quan_huyen.required' => 'Vui lòng chọn Quận/Huyện người nhận',
                ];
                //them validate phone_count
                Validator::extend('phone_count', function($attribute, $value, $parameters, $validator) {
                    return strlen($value) >= 10 && strlen($value) < 11;
                });
                

                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json([
                        'result' => $validator->messages(),
                        'name' => $request->input('name'),
                        'phone' => $request->input('phone'),
                        'email' => $request->input('email')?$request->input('email'):'',
                        'address' => $request->input('address'),
                        'message' => $request->input('message'),
                        'province' => $request->input('province'),
                        'quan_huyen' => $request->input('quan_huyen'),
                        'other_address' => $request->input('other_address')
                    ]);
                }
                $data_receiver = array();
                $data_receiver['name'] = $request->input('name');
                // $data_receiver['customer_id'] = Auth::user()->customer_id;
                $data_receiver['phone'] = $request->input('phone');
                $data_receiver['email'] = $request->input('email');
                $data_receiver['address'] = $request->input('address');
                $data_receiver['city'] = $request->input('province');
                $data_receiver['customer_code'] = $request->input('customer_code');
                $data_receiver['district'] = $request->input('quan_huyen');
                $data_receiver['customer_type'] = 2;
                $data_receiver['ward'] = '';
                $data_receiver['active'] = 0;
                $data_receiver['created_at'] = date("Y-m-d H:i:s");
                $data_receiver['updated_at'] = date("Y-m-d H:i:s");
                // $result_receiver = $this->receiver->insert_receiver($data_receiver);
                $result_receiver = Customer::create($data_receiver); 
                // dd($result_receiver);
                if(!$result_receiver){
                    return response()->json([
                        'result' =>'Lỗi! Vui lòng thử lại',
                    ]);
                }
                if($request->input('coupon_id') && $request->input('coupon_code')){
                    $getCoupon = $this->coupon->getCoupon($request->input('coupon_code'));
                    if(!$getCoupon){
                        return response()->json(['result' => 'Mã coupon không tồn tại.']);
                    }
                    $result_coupon = $this->coupon->setCoupon($request->input('coupon_id'));
                    if(!$result_coupon){
                        return response()->json(['result' => 'Lỗi! Đã xảy ra sự cố, vui lòng thử lại.']);
                    }
                }
                $input_order['order_address'] = $result_receiver->id;
            }else{
                // $result_receiver = $this->receiver->current_receiver(Auth::user()->customer_id);
                $input_order['order_address'] = Auth::user()->customer_id;
            }
            // dd($input_order['order_address']);
            $input_order['customer_id'] = Auth::user()->customer_id;
            $input_order['receiver_id'] = $result_receiver->id;
            $input_order['order_number'] = "nt_".($this->orders->countOrder() + 1);
            $input_order['payment_method'] = $request->input('payment_method');
            $input_order['coupon_id'] = $request->input('coupon_id')?$request->input('coupon_id'):0;
            $input_order['discount_percent'] = $request->input('discount')?$request->input('discount'):0;
            $input_order['total_price'] = $cart->totalPrice;
            $input_order['order_address'] = $result_receiver?$result_receiver->id:Auth::user()->customer_id;
            $input_order['status'] = 'Mới';
            $input_order['order_date'] = date("Y-m-d H:i:s");
            $input_order['notes'] = $request->input('message');
            $input_order['created_at'] = date("Y-m-d H:i:s");
            $result_order = Orders::create($input_order);
            if(!$result_order){
                return response()->json([
                    'result' =>'Lỗi! Vui lòng thử lại'
                ]);
            }
            
            
            // $orderDetail = new OrderDetail;
            $orderDetail = array();
            foreach ($cart->items as $key => $value) {
                $orderDetail['order_id'] = $result_order->id;
                $orderDetail['product_id'] = $key;
                $orderDetail['quantity'] = $value['qty'];
                $orderDetail['promotion_price'] = ($value['promotion_price'] / $value['qty']);
                $orderDetail['unit_price'] = ($value['unit_price'] / $value['qty']);
                $orderDetail['created_at'] = date("Y-m-d H:i:s");
                $orderDetail['updated_at'] = date("Y-m-d H:i:s");
                // $orderDetail->save();
                OrderDetail::create($orderDetail);
            }

            if (!$result_order){
                return response()->json([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'message' => $request->input('message'),
                    'address'=> $request->input('address'),
                    'result' => 'Lỗi! Vui lòng thử lại.'
                ]);
            }
            Session::forget('cart');
            return response()->json([
                    'result' => 'Thành công',
                    'order_id' => base64_encode($result_order->order_number.'jteck387')
                ]);
        }
        else{
        // return response()->json(['discount' => $request->input('discount')]);

            // Processing customer addresss
            
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|phone_count',
                'address' => 'required|max:255',
                'province' => 'required',
                'quan_huyen' => 'required',
            ];
            $messages = [
                'name.required' => 'Vui lòng nhập họ tên',
                'name.max' => 'Họ Tên quá dài',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã được đăng ký tài khoản, vui lòng <a href="'.route('f.login').'">Đăng nhập</a>.',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.phone_count' => 'Số điện thoại không đúng',
                'address.required' => 'Vui lòng nhập địa chỉ',
                'address.max' => 'Địa chỉ quá dài',
                'province.required' => 'Vui lòng chọn tỉnh/thành',
                'quan_huyen.required' => 'Vui lòng chọn quận/huyện',
            ];
            // them validate phone_count
            Validator::extend('phone_count', function($attribute, $value, $parameters) {
                return strlen($value) >= 10 && strlen($value) < 11;
            });

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'result' => $validator->messages(),
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'message' => $request->input('message'),
                    'province' => $request->input('province'),
                    'quan_huyen' => $request->input('quan_huyen')
                ]);
            }
            
            $input = array();
            $input_order = array();

            $input["name"] = $request->input('name');
            $input["email"] = $request->input('email');
            $input["phone"] = $request->input('phone');
            $input["customer_code"] = $request->input('customer_code');
            $input["address"] = $request->input('address');
            $input["city"] = $request->input('province');
            $input["district"] = $request->input('quan_huyen');
            $input["customer_id"] = 0;
            $input["comment"] = $request->input('message');
            $input["created_at"] = date("Y-m-d H:i:s");
            $result = Customer::create($input);
            if(!$result){
                return response()->json(['result' => 'Lỗi! Không tạo được khách hàng mới.']);
            }

            if($request->input('coupon_id') && $request->input('coupon_code')){
                $getCoupon = $this->coupon->getCoupon($request->input('coupon_code'));
                if(!$getCoupon){
                    return response()->json(['result' => 'Mã coupon không tồn tại.']);
                }
                $result_coupon = $this->coupon->setCoupon($request->input('coupon_id'));
                if(!$result_coupon){
                    return response()->json(['result' => 'Lỗi! Đã xảy ra sự cố, vui lòng thử lại.']);
                }
            }
            $product_gif = "";
            if($cart->product_gif){
                foreach($cart->product_gif as $item_gif){
                    $product_gif .= $item_gif->product_id.',';
                }
            }
            $product_gif = rtrim($product_gif, ',');
            $input_order['customer_id'] = $result->id;
            $input_order['receiver_id'] = $result->id;
            $input_order['order_number'] = "nt_".($this->orders->countOrder() + 1);
            $input_order['payment_method'] = $request->input('payment_method');
            $input_order['coupon_id'] = $request->input('coupon_id')?$request->input('coupon_id'):0;
            $input_order['product_gif'] = $product_gif;
            $input_order['discount_percent'] = $request->input('discount')?$request->input('discount'):0;
            $input_order['total_price'] = $cart->totalPrice;
            $input_order['status'] = 'Mới';
            $input_order['order_date'] = date("Y-m-d H:i:s");
            $input_order['notes'] = $request->input('message');
            $input_order['created_at'] = date("Y-m-d H:i:s");
            $result_order = Orders::create($input_order);

            
            $orderDetail = array();
            foreach ($cart->items as $key => $value) {
                $orderDetail['order_id'] = $result_order->id;
                $orderDetail['product_id'] = $key;
                $orderDetail['quantity'] = $value['qty'];
                $orderDetail['promotion_price'] = ($value['promotion_price'] / $value['qty']);
                $orderDetail['unit_price'] = ($value['unit_price'] / $value['qty']);
                $orderDetail['created_at'] = date("Y-m-d H:i:s");
                $orderDetail['updated_at'] = date("Y-m-d H:i:s");
                // $orderDetail->save();
                OrderDetail::create($orderDetail);
            }

            if (!$result || !$result_order){
                // return redirect()
                //         ->back()
                //         ->with([
                //             'name', $request->input('name'),
                //             'phone', $request->input('phone'),
                //             'email', $request->input('email'),
                //             'message', $request->input('message'),
                //             'address', $request->input('address'),
                //             'result', 'Lỗi! Vui lòng thử lại.'
                //         ])
                // ;
                return response()->json([
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'message' => $request->input('message'),
                    'address'=> $request->input('address'),
                    'result' => 'Lỗi! Vui lòng thử lại.'
                ]);
            }
            Session::forget('cart');
            return response()->json([
                    'result' => 'Thành công',
                    'order_id' => base64_encode($result_order->order_number.'jteck387')
                ]);
            // return redirect()->route('notify', $result_order->id);
        }
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
    public function orderSuccess() {
        //
        return view('product.notify',[
            
        ]);
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
