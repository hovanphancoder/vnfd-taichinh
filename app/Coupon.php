<?php namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {

	//
	protected $table = "coupon";
    protected $fillable = ['id','code','value','quantity','type_unit', 'type_discount', 'status'];
    public $timestamps = true;

    public function getCoupon($code){
    	return DB::table('coupon')->where('code', $code)->first();
    }

    public function setCoupon($id){
    	return DB::table('coupon')->whereId($id)->decrement('quantity',1);
    }

    public static function getList(){
        return DB::table('coupon')->select('id','code', 'value')->get();
    }

}
