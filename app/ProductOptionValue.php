<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $table = "product_option_value";
    protected $fillable = ['product_option_id', 'product_id', 'option_id', 'option_value_id', 'sku', 'quantity', 'subtract', 'price', 'price_prefix', 'points', 'points_prefix', 'weight', 'weight_prefix'];

    public function productOption(){
    	return $this->belongsTo('App\ProductOption','product_option_id','id');
    }
	
	
}
