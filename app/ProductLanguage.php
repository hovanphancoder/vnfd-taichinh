<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductLanguage extends Model
{
    //
    protected $table='products_language';
    protected $fillable=['product_id','language_id', 'product_status','name','slug','description','content','specification','combo','product_gif','unit'];
    public $timestamps=false;

    public function getComboProduct($product_id, $combo_id){
    	// echo "<pre>";
    	// print_r($combo_id);
    	// DB::enableQueryLog();
    	$sql = DB::table('products_language');
    	$sql->join('products','products.id','=','products_language.product_id');
		$sql->where('products_language.product_id','!=',$product_id);
		if($combo_id != "" || $combo_id != NULL){
			$sql->whereIn('product_id', $combo_id);
		}
		$sql->where('products_language.language_id',get_id_locale());
        $sql->where('products_language.product_status', 1);
		$sql->select('products_language.*','products.image','products.promotion_price','products.unit_price','products.hot');
    	// dd(DB::getQueryLog());

		return $sql->get();

		
    }
}
