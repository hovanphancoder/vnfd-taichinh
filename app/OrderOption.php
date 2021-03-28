<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model {

	//
    protected $table = "order_option";
    protected $fillable = ['order_id', 'order_product_id', 'product_option_id', 'product_option_value_id', 'name', 'value', 'type', 'created_at', 'updated_at'];
    public function productoption(){
    	return $this->belongsTo('App\ProductOption','product_option_id','id');
    }
    public function productoptionvalue(){
    	return $this->belongsTo('App\ProductOptionValue','product_option_value_id','id');
    }
    public function orders(){
    	return $this->belongsTo('App\Orders','order_id','id');
    }
    
//    public function customer(){
//        return $this->belongsTo('App\Orders','id_bill','id');
//    }

}
