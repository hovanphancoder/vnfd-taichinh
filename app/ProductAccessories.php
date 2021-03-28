<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAccessories extends Model
{
    //
    protected $table='product_accessories';
    protected $fillable=['product_id','language_id','description','pn','created_at','updated_at'];
    public $timestamps=false;
	public function product(){
    	return $this->belongsTo('App\products','product_id','id');
    }
}
