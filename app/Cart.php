<?php

namespace App;
use App;use Session;
class Cart {

    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public $coupon = null;
    public $product_gif = null;

    public function __construct($oldCart) {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            $this->coupon = $oldCart->coupon;
            $this->product_gif = $oldCart->product_gif;
        }
    }

    public function add($item, $id) {
		$price = '';
		if($item->promotion_price == '' || $item->promotion_price == 0){
            $price = $item->unit_price;
        }elseif($item->promotion_price > 100 && $item->promotion_price < $item->unit_price){
            $price =  $item->promotion_price;
        }elseif($item->promotion_price < 100 && $item->promotion_price > 0){
            $price = $item->unit_price - (($item->unit_price * $item->promotion_price)/100);
        }else{
            $price = 0;
        }
		
		$item->price = $price;
		$item->quantity = 1;
        $giohang = ['qty' => 0, 'quantity' => 1, 'price' => $price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $giohang = $this->items[$id];
            }
        }

        $giohang['qty'] ++;
        $giohang['promotion_price'] = $item->promotion_price * $giohang['qty'];
        $giohang['unit_price'] = $item->unit_price * $giohang['qty'];
        
        $this->items[$id] = $giohang;
        $this->totalQty++;
        if($item->promotion_price > 0 && $item->promotion_price < $item->unit_price){
            $this->totalPrice += $item->promotion_price;
        }else{
            $this->totalPrice += $item->unit_price;
        }
    }
	// public function add($item, $id) {
        // $giohang = ['qty' => 0, 'price' => $item->unit_price, 'item' => $item];
        // if ($this->items) {
            // if (array_key_exists($id, $this->items)) {
                // $giohang = $this->items[$id];
            // }
        // }
        // $giohang['qty'] ++;
        // $giohang['price'] = $item->unit_price * $giohang['qty'];
        // $this->items[$id] = $giohang;
        // $this->totalQty++;
        // $this->totalPrice += $item->unit_price;
    // }
	public function adddetail($item, $id) { 
		
        $giohang = ['qty' => 0, 'quantity' => $item->quantity, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $giohang = $this->items[$id];
            }
        }
        $giohang['qty'] ++;
        $giohang['price'] = $item->price * $giohang['quantity'];
        if(isset($item->option))
            $giohang['option'] = $item->option;
        else
            $giohang['option'] = '';
        $this->items[$id] = $giohang;
        $this->totalQty++;
        $this->totalPrice += $giohang['price'];
    }

    public function updateCart($id, $qty) {
        // echo $this->totalQty;
        // exit;
        if (Session::has('shoppingCart')) {
            $shopCart = Session::get('shoppingCart');
            $shopCart[$id]['quantity'] = $qty;
            $shopCart[$id]['totalPrice'] = $qty * $shopCart[$id]['price'];
            Session::put('shoppingCart', $shopCart);
            Session::save();
        }
    }

    //xóa 1
    public function reduceByOne($id) {
        $this->items[$id]['qty'] --;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    //xóa nhiều
    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

    public function addCoupon($coupon){
        $data = ['id' => $coupon->id, 'code' => $coupon->code, 'value' => $coupon->value, 'type_unit' => $coupon->type_unit, 'type_discount' => $coupon->type_discount];
        return $this->coupon = $data;
    }

    public function addProductGif($product_id){
        $product = ProductLanguage::where('product_id', $product_id)->first();
        $product_list = explode(',', $product->product_gif);
        $data = ProductLanguage::join('products', 'products_language.product_id','=','products.id')
                        ->whereIn('products_language.product_id', $product_list)
                        ->where('products_language.language_id', get_id_locale())
                        ->where('products_language.product_status', 1)
                        ->select('products_language.product_id','products_language.name', 'products_language.slug', 'products.image')
                        ->get();
        if(!$data){
            return $this->product_gif = null;
        }
        return $this->product_gif = $data;
    }

}
