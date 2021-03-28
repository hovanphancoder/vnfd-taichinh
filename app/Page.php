<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model {

    //
    protected $table = 'page';
	protected $fillable=['title','description','slug','content','image','seotitle','seokeyword','seodescription','created_at','updated_at'];
	
    public function adminListPage() {
        return DB::table("page")->select('*')->orderBy('id', 'desc')->paginate(10);
    }

    public function adminViewPage($id) {
        return DB::table("page")->whereId($id)->first();
    }

    public function getListId() {
        return DB::table('page')->pluck('id');
    }

    public function getplucklugVN() {
        return DB::table('page')->pluck('slug');
    }

    public function countPage() {
        return DB::table('page')->count();
    }

    public function addPage($title, $slug, $description, $content, $image, $seotitle, $seokeyword, $seodescription, $created_at) {
        $lastId = DB::table('page')->orderBy('id', 'desc')->first();
        return DB::table('page')->insertGetId([
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image,
                    'seotitle' => $seotitle,
                    'seokeyword' => $seokeyword,
                    'seodescription' => $seodescription,
                    'created_at' => $created_at
        ]);
    }

    public function delPage($id) {
        return DB::table('page')->where('id', $id)->delete();
    }

    public function updatePage($id, $lang, $title, $slug, $description, $content, $image, $seotitle, $seokeyword, $seodescription, $updated_at) {
            return DB::table('page')
                            ->where('id', $id)
                            ->update([
                                'title' => $title,
                                'slug' => $slug,
                                'description' => $description,
                                'content' => $content,
                                'image' => $image,
                                'seotitle' => $seotitle,
                                'seokeyword' => $seokeyword,
                                'seodescription' => $seodescription,
                                'updated_at' => $updated_at
            ]);
    }

    public function getId($slug) {
        return DB::table('page')->select('id')->where('slug', $slug)->first();
    }

    public function checkSlug($slug) {
        return DB::table('page')->where('slug', $slug)->first();
    }

    public function getPage($slug) {
        return DB::table("page")
                ->join("page_language","page_language.page_id","=","page.id")
                ->where('page_language.slug', $slug)
                ->where('page_language.language_id',get_id_locale(Session()->get('locale')))
                ->first();
    }

    public function getPost($slug) {
        return DB::table("post")->where('slug', $slug)->first();
    }

    public function getCate($slug) {
        return DB::table('post')->select('id_cate')->where('slug', $slug)->first();
    }

    public function getPostRelated($post_slug, $id_cate, $limit) {
        return DB::table("post")
                        ->where('slug', '!=', $post_slug)
                        ->where('id_cate', $id_cate)
                        ->limit($limit)
                        ->get();
    }

    public function updateSlugPage($id, $slug) {
        return DB::table('page')->where('id', $id)->update([
                    'slug' => $slug
        ]);
    }

    public function getSlug($id) {
        return DB::table('page')->where('id', $id)->select('slug')->first();
    }

    public function sitemap() {
        return DB::table("page")
                        ->select('page.*')
                        ->orderby('created_at', 'ASC')
                        ->get();
    }
    
    public function getPageMetaTag($slug = "/"){
        return DB::table("page")
          ->join("page_language","page_language.page_id","=","page.id")
                ->where('page_language.slug', $slug)
                ->where('page_language.language_id',get_id_locale(Session()->get('locale')))
                
                        ->first();
    }
    
    public function getPostMetaTag($slug){
        return DB::table("post")
                        ->where('slug', $slug)
                        ->first();
    }

}