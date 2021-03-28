<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductType extends Model
{
    protected $table = "type_products";
    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'image', 'status', 'feature', 'level', 'created_at', 'updated_at'];

    public function product(){
    	return $this->hasMany('App\Products','id_type','id');
    }
	public function language()
	{
		return $this->hasMany('App\TypeProductsLanguage','id_type','id');	    
	}
	public function currentLanguage()
	{
		return $this->hasMany('App\TypeProductsLanguage','id_type','id')->where('language_id',get_id_locale());    
	}
	public function getCategoryProductFromID($id){
		$data=$this->where('id',$id)->get();
		return $data;
	}
	public static function getLevelFromCateID($id){
		if($id==0){ 
            $level = 1;
            return $level;
        }
		$data=ProductType::select('level')->where('id',$id)->first();
		$level = $data->level + 1;
		return $level;
	}
	public function category_tree($id,$title,&$results){
        
        $data = ProductType::where('parent_id',$id)->where('level','<',4)->get();
            
        if($data){
            foreach($data as $item){ 
                if(!$title){
                    $title_sub=$item->name;
                }
                else{
                    $title_sub=$title.' -> '.$item->name;
                }
                
                  $results[]=[
                        'id'=>$item->id,
                        'name'=>$item->name,
                        'parent_id'=>$item->parent_id,
                        'level'=>$item->level,
                        'nametree'=>$title_sub,
                        'description'=>$item->description,
                        'created_at'=>$item->created_at,
                        'updated_at'=>$item->updated_at,
                        ];
                 $this->category_tree($item->id,$title_sub,$results);
            } 
        }
		
    }
	public static function getarray_idtype_product($id,&$results){      
        $data = ProductType::where('parent_id',$id)->get();          
        if($data){
            foreach($data as $item){
                  $results[]= $item->id;
				  $th = new ProductType();
                 $th->getarray_idtype_product($item->id,$results);
            } 
        }	
    }
	public static function productParentCategory($parent_id = 0) {
        return DB::table('type_products')->where('parent_id',$parent_id)->get();
    }
    public static function getParent($parent_id = 0) {
        return DB::table('type_products')->where('parent_id',$parent_id)->get();
    }
	public static function getListCategoryParent($parent_id = 0) {
        return DB::table('type_products')->where('parent_id',$parent_id)->orderby('created_at','desc')->get();
    }

    public static function getMenuCate($parent_id = 0) {
        return DB::table('type_products')->where('parent_id', $parent_id)->get();
    }

    public static function getSidebarMenu($id) {
        return DB::table('type_products')->where('id', $id)->get();
    }

    public function getMultiCate($parent_id){
        // DB::setFetchMode(\PDO::FETCH_ASSOC);
        return DB::table('type_products')
                ->where('parent_id','=',$parent_id)
                ->select('id')
                ->get();
    }
    public static function getCate($id){
        // DB::setFetchMode(\PDO::FETCH_ASSOC);
        return DB::table('type_products')
                ->where('id','=',$id)
                ->select('id', 'name')
                ->first();
    }

    public function productList($id_type){
        $query = DB::table('products');
        $query->join('products_language','products_language.product_id','=','products.id');
        $query->join('type_products','type_products.id','=','products.id_type');
        $query->where('products_language.language_id','=',get_id_locale());
        if($id_type != 0){
            $query->where('products.id_type',$id_type);
        }
        $query->select('type_products.name as catename','products_language.*','products.id as main_product_id','products_language.combo','products.unit_price','products.promotion_price','products.image');
        return $query->get();
    }

    public static function checkCateSlug($cateslug){
        return DB::table('type_products')
                ->where('slug','=',$cateslug)
                ->select('id', 'name', 'parent_id', 'slug','level', 'description', 'image')
                ->first();
    }

    public function catseListID($cateslug){
        return DB::table('type_products as a1')
                    ->join('type_products as a2', 'a1.parent_id', '=', 'a2.id')
                    ->where('a1.slug','=',$cateslug)
                    ->where('a2.parent_id', '!=', 0)
                    ->select('a2.id')
                    ->get();
    }
}
