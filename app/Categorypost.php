<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categorypost extends Model {

    //


    protected $table = 'categorypost';
	protected $fillable=['title','description','slug','parent_id','image','created_at','updated_at'];
	public function post(){
    	return $this->hasMany('App\Post','id_cate','id');
    }
    public function currentLanguage()
    {
        return $this->hasMany('App\CategorypostLanguage','categorypost_id','id')->where('language_id',get_id_locale());
    }
	public function categorypost_tree($id,$title,&$results){
        
        $data = Categorypost::where('parent_id',$id)->get();
        if($data){
            foreach($data as $item){ 
                if(!$title){
                    $title_sub=$item->title;
                }
                else{
                    $title_sub=$title.' -> '.$item->title;
                }
                
                  $results[]=[
                        'id'=>$item->id,
                        'title'=>$item->title,
                        'parent_id'=>$item->parent_id,
                        'nametree'=>$title_sub,
                        'description'=>$item->description,
                        'created_at'=>$item->created_at,
                        'updated_at'=>$item->updated_at,
                        ];
                 $this->categorypost_tree($item->id,$title_sub,$results);
            }
        }
    }
//
//    public function parent()
//    {
//        return $this->belongsTo('App\Categorypost', 'parent_id');
//    }
//
//    public function children() {
//        return $this->hasMany('App\Categorypost', 'parent_id');
//    }
//
//    public function getParentsAttribute() {
//        $parents = collect([]);
//        $parent = $this->parent;
//        while (!is_null($parent)) {
//            $parents->push($parent);
//            $parent = $parent->parent;
//        }
//        return $parents;
//    }

    public function getCategory($slug, $language, $select = []){
        $query = DB::table('categorypost');
        if($language > 0){
            $query->join('categorypost_language','categorypost_language.categorypost_id','=','categorypost.id');
            $query->where('categorypost_language.language_id', $language);
            $query->where('categorypost_language.slug', $slug);
        }else{
            $query->where('categorypost.slug', $slug);
        }
        $query->select($select);
        return $query->first();
        
    }

    public static function getListCategoryParent($parent_id = 0) {
        return DB::table('categorypost')->where('parent_id',$parent_id)->get();
    }
    // public function getCategory($slug,$select=[]){
    //     return Categorypost::where('slug',$slug)->where('parent_id',0)->select($select)->first();
    // }
    public static function getListCategoryParent_FE($id) {
        return DB::table('categorypost as a')
        ->join('categorypost as b', 'a.id','=','b.parent_id')
        ->where('a.id', $id)
        ->select('b.*')
        ->get();
    }
    
    public function getListIdCategory() {
        return DB::table('categorypost')->pluck('id')->all();
    }
	
}