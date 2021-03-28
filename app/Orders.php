<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Orders extends Model {

	//
    protected $table = "orders";
    protected $fillable = ['customer_id', 'receiver_id', 'order_number', 'order_address', 'payment_method', 'total_price', 'discount_percent', 'coupon_id', 'product_gif', 'subtotal', 'gtgt', 'order_date', 'status', 'order_type', 'notes', 'delivery_date', 'created_at', 'updated_at'];
    public function bill_detail(){
    	return $this->hasMany('App\OrderDetail','id_bill','id');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function countOrder(){
    	return DB::table("orders")->count();
    }

}
