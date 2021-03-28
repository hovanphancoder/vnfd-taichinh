<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductTypeRelationships extends Model {

	//
	protected $table = "type_products_relationships";
    protected $fillable = ['product_id', 'type_products_id', 'created_at', 'updated_at'];
	protected $guarded = ['id'];
	public $timestamps = false;

    public function type_products(){
    	return $this->hasMany('App\ProductType','type_products_id','id');
    }

    public function products(){
    	return $this->hasMany('App\Products','product_id','id');
    }

}
