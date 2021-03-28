<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

	//
    protected $table = "order_detail";
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price', 'promotion_price', 'created_at', 'updated_at'];
    public function product(){
    	return $this->belongsTo('App\Products','product_id','id');
    }
    
    public function orders(){
    	return $this->belongsTo('App\Orders','id_bill','id');
    }
    
//    public function customer(){
//        return $this->belongsTo('App\Orders','id_bill','id');
//    }

}
