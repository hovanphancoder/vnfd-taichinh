<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Coupon;
use App\Products;
use App\ProductType;
use App\Cart;
use Session;

use Illuminate\Http\Request;

class CouponController extends Controller {


	public function __construct(Coupon $coupon, Products $products, ProductType $product_type){
		$this->coupon = $coupon;
		$this->products = $products;
		$this->product_type = $product_type;
	}

	public function index()
	{
		//
		
	}

	public function show(Request $request){
		if (!Session::has('cart')) {
            return redirect()->to('/');
        }
		if(!$request->isMethod('post') || !$request->isMethod('POST')){
			return response()->json(['result' => 'Lỗi, vui lòng thử lại!']);
		}
		if(!$request->coupon){
			return response()->json(['result' => 'Vui lòng nhập mã giảm giá']);
		}
		$result = $this->coupon->getCoupon($request->coupon);
		if(!$result){
			return response()->json(['result' => 'Mã giảm giá không tồn tại!']);
		}
		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);
		if($result->type_discount != 'null'){
			$type_discount = explode('_', $result->type_discount);
			// ma giam gia cho san pham
			if($type_discount[0] == 'p'){
				// $item = Products::find(is_numeric($type_discount[1]));
				$product = $this->products->getProduct($type_discount[1], ['id']);
				$item = $result;
				foreach($cart->items as $product){
					if($product['item']['id'] == $type_discount[1]){
						if(count($cart->items) > 0){
				        	$cart->addCoupon($result);
				        }
				        Session::put('cart', $cart);
						return response()->json([
							'result' => 'Thành công',
							'coupon' => $result,
							'product' => $item,
							'cart' => $cart
						]);
					}
				}
				return response()->json(['result' => 'Mã giảm giá không tồn tại!']);
				// ma giam gia cho loai san pham

			}elseif($type_discount[0] == 'c'){
				$category = ProductType::find($type_discount[1]);
				if(!$category){
					return response()->json(['result' => 'Mã giảm giá không tồn tại!']);
				}
				$item = $result;
				foreach($cart->items as $product){
					if($product['item']['id_type'] == $type_discount[1]){
						if(count($cart->items) > 0){
				        	$cart->addCoupon($result);
				        }
				        Session::put('cart', $cart);
						return response()->json([
							'result' => 'Thành công',
							'coupon' => $result,
							'product' => $item,
							'cart' => $cart
						]);
					}
				}
				return response()->json(['result' => 'Mã giảm giá không tồn tại!']);
				
			}else{
				$item = 11111;
			}
		}else{
			$type_discount = 'null';
			$item = $result;
			if(count($cart->items) > 0){
	        	$cart->addCoupon($result);
	        }
		}
        Session::put('cart', $cart);
		return response()->json([
			'result' => 'Thành công',
			'coupon' => $result,
			'value_coupon' => $request->coupon,
			'type_discount' => $type_discount,
			'type_discount_0' => $type_discount[0],
			'type_discount_1' => $type_discount[1],
			'type_discount_old' => $result->type_discount,
			'product' => $item,
			'cart' => $cart,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function create()
	{
		//
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	}

}
