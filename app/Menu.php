<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model {

    protected $table = 'menu'; 
    protected $primaryKey = 'id';
    protected $fillable = ['title','id_catemenu','parent_id','orderby','link','created_at','updated_at'];
    //

    public function language()
    {
        return $this->hasMany('App\MenuLanguage','menu_id','id');       
    }

    public function getListCate($id_catemenu) {
        return DB::table('menu')
                        ->join('categorymenu', 'menu.id_catemenu', '=', 'categorymenu.id')
                     //   ->join('menu_language','menu.id','=','menu_language.language_id')
                        ->where('menu.id_catemenu', $id_catemenu)
                        ->select('menu.*', 'categorymenu.title_vn as category_vn', 'categorymenu.title_en as category_en')
                        ->orderby('orderby','asc')
                        ->get();
    }

    public static function getParentMenu($id_catemenu, $language, $parent_id = 0,$select = []){
     
                    $query=DB::table('menu');
                        // ->join('categorymenu','categorymenu.id','=','menu.id_catemenu')
                    $query->where('menu.parent_id', $parent_id);
                    $query->where('menu.id_catemenu', $id_catemenu);
                    if($language > 0){
                        $query->join('menu_language','menu.id','=','menu_language.menu_id');
                        $query->where('menu_language.language_id',$language);
                    }
                    $query->orderBy('orderby', 'asc');
                    $query->select($select);
                   
            return  $query->get();     
    }
    public static function getParentMenuAdmin($id_catemenu, $parent_id = 0){
        return DB::table('menu')
                        ->join('categorymenu','categorymenu.id','=','menu.id_catemenu')
                        ->where('menu.parent_id', $parent_id)
                        ->where('menu.id_catemenu', $id_catemenu)
                        ->orderBy('orderby', 'asc')
                        ->select('menu.*', 'categorymenu.title_vn as catename')
                        ->get();
                      
    }
	public static function checkHasChild($id){
		$q = DB::table('menu')
                        ->join('categorymenu','categorymenu.id','=','menu.id_catemenu')
                        ->where('menu.parent_id', $id)
                        ->first();
		if($q) return 'yes';
		else return 'no';
	}

    public function getCateMenu($id) {
        return DB::table('categorymenu')
                        ->where('id', $id)
                        ->first();
    }

    public function getCate() {
        return DB::table('categorymenu')
                        ->get();
    }

    public function getOneCate($id) {
        return DB::table('categorymenu')
                        ->where('id', $id)
                        ->first();
    }

    public function getMenu($id) {
        return DB::table('menu')
                ->join('menu_language','menu_language.menu_id','=','menu.id')
                ->where('menu_language.menu_id', $id)
                ->select('menu_language.menu_id as id', 'menu_language.title as title', 'menu_language.link as link')
                ->get();
    }

    public function updateLinhVuc($id, $title, $link, $id_catemenu, $parent_id) {
        // DB::enableQueryLog();
        return DB::table('menu')
                        ->where('id', $id)
                        ->update([
                            'title_vn' => $title,
                            'link_vn' => $link,
                            'id_catemenu' => $id_catemenu,
                            'parent_id' => $parent_id
                        ]);
                        // dd(DB::getQueryLog());
                        // exit;
    }
    public function setMenuLinhVuc($title, $link, $id_catemenu, $parent_id) {
        return DB::table('menu')
                        ->insertGetId([
                            'title' => $title,
                            'id_catemenu' => $id_catemenu,
                            'link' => $link,
                            'parent_id' => $parent_id
        ]);
    }

    public function doDelLinhVuc($id) {
        DB::table('menu')
                ->where('id', $id)
                ->delete();
    }
	
	public function delCateMenu($id) {
        DB::table('categorymenu')
                ->where('id', $id)
                ->delete();
    }

}