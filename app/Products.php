<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    protected $table = "products";
    protected $fillable = ['name', 'slug', 'id_type', 'id_group', 'id_trademark', 'product_status', 'description', 'content', 'unit_price', 'promotion_price', 'image', 'unit', 'feature', 'neew', 'hot', 'galleries', 'catalogs', 'date_price', 'created_at', 'updated_at'];

    public function product_type(){
    	return $this->belongsTo('App\ProductType','id_type','id', 'name');
    }

    public function product_type_relationships(){
        return $this->hasMany('App\ProductTypeRelationships','product_id','id');
    }

	public function trademark(){
    	return $this->belongsTo('App\Trademark','id_trademark','id');
    }

    public function bill_detail(){
    	return $this->hasMany('App\BillDetail','id_product','id');
    }
    
    public function updateItem($input, $id) {
        return $this->where('id', $id)
                    ->update($input);
    }
	public function language()
	{
		return $this->hasMany('App\ProductLanguage','product_id','id');	    
	}
	public function currentLanguage()
	{
		return $this->hasMany('App\ProductLanguage','product_id','id')->where('language_id',get_id_locale());
	}
	public function getProductFromArrayIdType($array){      
        $data = Products::with('currentLanguage')->whereIn('id_type',$array)->get();          
        
		merge_field($data,'currentLanguage');
		return $data;
    }
    public function getProductRelated($slug, $id_cate){
        return Products::join('type_products_relationships', 'products.id', '=', 'type_products_relationships.product_id')
                    ->select('products.*')
                    ->where('products.slug', '!=', $slug)
                    ->where('type_products_relationships.type_products_id', $id_cate)
                    ->orderByRaw("RAND()")
                    ->groupBy('type_products_relationships.product_id')
                    ->limit(8)
                    ->get();
    }

    public function getProductDetail($slug){
        return Products::join('type_products', 'products.id_type', '=', 'type_products.id')
                    ->join('products_language','products_language.product_id','=','products.id')
                    ->select('products.*', 'type_products.name as namecate', 'type_products.slug as slugcate', 'products_language.specification')
                    ->where('products_language.slug', $slug)
                    ->get();
    }

    public function getProperties($idProduct, $idOption){
        $sql = DB::table("product_option_value")
                ->join('option_value_language', 'option_value_language.option_value_id', '=', 'product_option_value.option_value_id')
                ->join('option', 'option.id','=','option_value_language.option_id')
                ->where('product_option_value.product_id', $idProduct)
                ->where('option.id', $idOption)
                ->where('option_value_language.language_id',get_id_locale())
                ->select('product_option_value.price as price_size','product_option_value.price_prefix','option_value_language.name as mau_sac', 'option_value_language.id as id','option_value_language.language_id')
                ->get();
        return $sql;
                // ->toSql();
                // dd($sql);
    }

    public static function getProductList($id_type = array(), $product_sale = 0, $max = 0, $min = 0, $sort_name = "created_at", $sort_type = "desc"){
        $query = DB::table("products");
        $query->join('products_language','products.id','=','products_language.product_id');
        $query->join('type_products_relationships', 'type_products_relationships.product_id','=','products.id');
        $query->whereIn('type_products_relationships.type_products_id', $id_type);
        $query->where('products_language.language_id', get_id_locale());
        $query->where('products_language.product_status',1);
        if($product_sale > 0){
            $query->where('products.promotion_price','>', 0);
        }
        if($min > 0 && $max > 0 && $max > $min){
            $query->where('products.unit_price','>', $min);
            $query->where('products.unit_price','<', $max);
        }elseif($min == 0 && $max > 0){
            $query->where('products.unit_price','>', $min);
            $query->where('products.unit_price','<', $max);
        }else{
             $query->where('products.unit_price','>=', 0);
        }
        $query->orderby('products.'.$sort_name, $sort_type);
        $query->groupBy('products.name');
        $query->select('products_language.*','products.image','products.promotion_price','products.unit_price','products.hot');
        return $query->paginate(24);
    }

    public function getProductOption($id_cate, $listID){
        $query = DB::table('product_option_value');
        $query->join('products_language','product_option_value.product_id','=','products_language.product_id');
        $query->join('products','product_option_value.product_id','=','products.id');
        $query->whereIn('product_option_value.option_value_id', $listID);
        $query->where('products.id_type', $id_cate);
        $query->where('products_language.language_id', get_id_locale());
        $query->where('products_language.product_status',1);
        $query->orderby('products.created_at','desc');
        $query->select('products_language.*','products.image','products.promotion_price','products.unit_price','products.hot');
        return $query->paginate(24);
    }

    public function getProductHot($array = []){
        // DB::connection()->enableQueryLog();
        $sql = DB::table("products")
                ->join('products_language','products.id','=','products_language.product_id')
                ->where('products_language.language_id', get_id_locale())
                ->where('products.hot',1)
                ->where('products_language.product_status',1)
                ->orderby('created_at', 'desc')
                ->select($array)
                ->limit(5);
                return $sql->get();
            // return $queries = DB::getQueryLog();
    }

    public function search($keyword){
        return DB::table('products')
                    ->where('name', 'like', '%'.$keyword.'%')
                    ->select('id', 'name', 'slug', 'description', 'unit_price', 'promotion_price','image')
                    ->get();
    }
    
    public static function getProduct($id, $data = []){
        return DB::table('products')->whereId($id)->select($data)->first();
    }
}
