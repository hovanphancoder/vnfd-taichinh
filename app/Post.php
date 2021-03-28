<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model {

    //
    protected $table = 'post';
	protected $fillable=['track_id', 'title','description','slug','content','post_status','id_cate','id_work','id_project_type', 'feature', 'setting' ,'image','galleries','galleries_thumb','seotitle','seokeyword','seodescription','created_at','updated_at'];
  
	public function language()
	{
		return $this->hasMany('App\PostLanguage','post_id','id');	    
	}
	public function currentLanguage()
	{
		return $this->hasMany('App\PostLanguage','post_id','id')->where('language_id',get_id_locale());    
	}
	public function post_cate(){
    	return $this->belongsTo('App\Categorypost','id_cate','id');
    }
    /**
     * Define guarded columns
     *
     * @var array
     */
    protected $guarded = array('id');
    
    protected $casts = [
        'gallery' => 'array',
    ];
  
    //
    public function getCateSwap($id_swap) {
        return DB::table("post")->where('id_cate', $id_swap)->get();
    }

    public function getListProcess($id_process) {
        return DB::table("post")->where('id_cate', $id_process)->get();
    }

    public function getpluckpecial($id_special) {
        return DB::table("post")->where('id_cate', $id_special)->get();
    }

    public function adminListPost($id_cate = 0) {
        if($id_cate == 0){
            return DB::table("post")
                            ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                            ->select('post.*', 'categorypost.title as namecate', 'categorypost.slug as cateslug')
                            ->orderby('created_at', 'asc')
                            ->paginate(10);
        }else{
            return DB::table("post")
                            ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                            ->select('post.*', 'categorypost.title as namecate', 'categorypost.slug as cateslug')
                            ->whereIn('post.id_cate',$id_cate)
                            ->orderby('created_at', 'asc')
                            ->paginate(10);
        }
    }
    
    // get list post in sub category and pagination
    public function listCatePost($cate_slug, $paginate) {
        return DB::table('post')
                        ->join('categorypost as c1', 'post.id_cate', '=', 'c1.id')
                        ->join('categorypost as c2','c2.id','=','c1.parent_id')
                        ->where('c2.slug', $cate_slug)
                        ->select('post.*')
                        ->orderby('created_at', 'desc')
                        ->paginate($paginate);
    }
    
    public function listPostCustom($cate_slug, $paginate) {
        return DB::table('post')
                        ->join('categorypost as c1', 'post.id_cate', '=', 'c1.id')
                        ->join('categorypost as c2','c2.id','=','c1.parent_id')
                        ->where('c2.slug', $cate_slug)
                        ->select('post.title', 'post.slug', 'post.image')
                        ->where('post.feature',1)
                        ->orderby('post.created_at', 'desc')
                        ->paginate($paginate);
    }
    
    // get list post in category and pagination
    public function listOneCatePost($cate_slug, $paginate) {
        return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', $cate_slug)
                        ->select('post.*')
                        ->orderby('post.created_at', 'desc')
//                        ->paginate($paginate);
                ->limit($paginate)
        ->get();
    }

    public function adminListCatePost($id_cate) {
        return DB::table("post")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->select('post.*', 'categorypost.title as namecate')
                        ->where('post.id_cate', $id_cate)
                        ->orderby('post.created_at', 'desc')
                        ->paginate(10);
    }

    public function getPostCate($cateslug) {
        return DB::table("post")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->select('post.title', 'post.slug', 'post.image', 'categorypost.slug as cateslug')
                        ->where('categorypost.slug', $cateslug)
                        ->orderby('post.created_at', 'desc')
                        ->get();
    }

    public function adminEditPost($id) {
//        return DB::table("post")->where("id",$id)->update([
//            'title' => $title
//        ]);
    }

    public function adminViewPost($id) {
        return DB::table("post")->whereId($id)->first();
    }

    public static function getCurrentCate($id) {
        return DB::table("post")
                        ->select('id_cate')
                        ->whereId($id)
                        ->first();
    }

    public function getListCate() {
        // lay danh sach catepost, ngoai tru cate delete
        return DB::table("categorypost")->get();
    }

    public function getListId() {
        return DB::table('post')->pluck('id');
    }

    public function getplucklugVN() {
        return DB::table('post')->pluck('slug');
    }

    public function getplucklugEN() {
        return DB::table('post')->pluck('slug');
    }

    public function updatePost($id, $lang, $title, $slug, $description, $content, $image, $galleries, $category, $collection, $feature, $order, $seotitle, $seokeyword, $seodescription, $checkSlug, $updated_at) {
        if ($lang == "vn") {
            return DB::table('post')
                            ->where('id', $id)
                            ->update([
                                'title' => $title,
                                'slug' => $slug,
                                'description' => $description,
                                'content' => $content,
                                'image' => $image,
                                'galleries' => $galleries,
                                'id_cate' => $category,
                                'id_collection' => $collection,
                                'feature' => $feature,
                                'orderby' => $order,
                                'seotitle' => $seotitle,
                                'seokeyword' => $seokeyword,
                                'seodescription' => $seodescription,
                                'updated_at' => $updated_at
            ]);
        } else {
            return DB::table('post')
                            ->where('id', $id)
                            ->update([
                                'title_en' => $title,
                                'slug_en' => $slug,
                                'description_en' => $description,
                                'content_en' => $content,
                                'image' => $image,
                                'id_cate' => $category,
                                'id_collection' => $collection,
                                'feature' => $feature,
                                'updated_at' => $updated_at
            ]);
        }
    }

    public function countPost() {
        return DB::table('post')->count();
    }

    public function addPost($title, $slug, $description, $content, $image, $category, $collection, $feature, $order, $seotitle, $seokeyword, $seodescription, $created_at) {
        return DB::table('post')->insertGetId([
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image,
                    'id_cate' => $category,
                    'id_collection' => 0,
                    'feature' => $feature,
                    'orderby' => $order,
                    'seotitle' => $seotitle,
                    'seokeyword' => $seokeyword,
                    'seodescription' => $seodescription,
                    'created_at' => $created_at
        ]);
    }

    public function delPost($id) {
        return DB::table('post')->where('id', $id)->delete();
    }

    public function delCatePost($id) {
        return DB::table('categorypost')->where('id', $id)->delete();
    }
    
    //get list id and check id is empty
    public function getListCateSearch($id){
        $query = DB::table('categorypost as c1')
                ->join('categorypost as c2', 'c1.parent_id','=','c2.id')
                // ->select('c1.*')
                ->where('c1.parent_id', $id)
                ->pluck('c1.id');
        (empty($query))?$query[0] = $id:$query;
        return $query;
    }

    public function searchPost($keyword, $id_cate) {
      $query = DB::table('post');
      $query->join('categorypost', 'post.id_cate', '=', 'categorypost.id');
      $query->select('post.*', 'categorypost.title as namecate');
      $query->where('post.title', 'like', '%' . $keyword . '%');
      if($id_cate[0] != 0){
        $query->whereIn('post.id_cate', $id_cate);
      }
      $query->orderby('created_at', 'desc');
      return $query->paginate(10);
        // chua co phan trang cho search
    }

    /* public function searchPost($lang, $id_cate, $keyword) {
      //        exit('dsadas');
      if ($lang == "en") {
      if (empty($id_cate)) {
      return DB::table('post')
      ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      ->select('post.*', 'categorypost.title_en as namecate_en', 'categorypost.title_en as namecate_en')
      ->where('post.title_en', 'like', '%' . $keyword . '%')
      ->orderby('created_at', 'desc')
      ->paginate(15);
      } else {
      if ($id_cate != 0) {
      return DB::table('post')
      ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      //                                ->where('post.title_en', 'like', '%' . $keyword . '%')
      ->where('categorypost.parent_id', $id_cate)
      //                            ->where('categorypost.id', 'post.id_cate')
      ->select('post.*', 'categorypost.title_en as namecate_en', 'categorypost.title_en as namecate_en')
      ->orderby('created_at', 'desc')
      //                            ->toSql();
      ->paginate(15);
      //                    exit;
      } else {
      return DB::table('post')
      ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      //                                ->where('post.title_en', 'like', '%' . $keyword . '%')
      ->where('categorypost.parent_id', $id_cate)
      //                            ->where('categorypost.id', 'post.id_cate')
      ->select('post.*', 'categorypost.title_en as namecate_en', 'categorypost.title_en as namecate_en')
      ->orderby('created_at', 'desc')
      //                            ->toSql();
      ->paginate(15);
      }
      }
      } else {
      if (empty($id_cate)) {
      return DB::table('post')
      ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      ->select('post.*', 'categorypost.title as namecate', 'categorypost.title as namecate')
      ->where('post.title', 'like', '%' . $keyword . '%')
      ->orderby('created_at', 'desc')
      ->paginate(15);
      } else {
      return DB::table('post')
      ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      ->select('post.*', 'categorypost.title as namecate', 'categorypost.title as namecate')
      ->where('post.title', 'like', '%' . $keyword . '%')
      ->where('post.id_cate', $id_cate)
      ->orderby('created_at', 'desc')
      ->paginate(15);
      }
      }
      //        if ($lang == "en") {
      //            return DB::table('post')
      //                            ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      //                            ->select('post.*', 'categorypost.title_en as namecate_en', 'categorypost.title_en as namecate_en')
      //                            ->where('post.id_cate', $id_cate)
      //                            ->where('post.title_en', 'like', '%' . $keyword . '%')
      //                            ->orderby('id', 'desc')
      //                            ->paginate(15);
      //        } else {
      //            return DB::table('post')
      //                            ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
      //                            ->select('post.*', 'categorypost.title as namecate', 'categorypost.title as namecate')
      //                            ->where('post.id_cate', $id_cate)
      //                            ->where('post.title', 'like', '%' . $keyword . '%')
      //                            ->orderby('id', 'desc')
      //                            ->paginate(15);
      //        }
      } */

    public function getListCategoryParent($parent_id) {
        return DB::table('categorypost')
                        ->where('parent_id', $parent_id)
                        ->orderBy('title', 'DESC')
                        ->get();
    }

    public function getListCategoryChild($parent_id) {
        return DB::table('categorypost')
                        ->where('parent_id', $parent_id)
                        ->orderBy('title', 'DESC')
                        ->get();
    }

    public function getpluckubCategory($parent_id = 0) {
        return DB::table('categorypost')
                        ->where('parent_id', $parent_id)
                        ->get();
    }

    public function viewCategoryPost($id) {
        return DB::table('categorypost')->whereId($id)->first();
    }

    public function getListIdCategory() {
        return DB::table('categorypost')->pluck('id');
    }

    public function editCategoryPost($id, $lang, $title, $slug, $description, $parent_id, $image, $updated_at) {
        if ($lang == "en") {
            return DB::table('categorypost')
                            ->where('id', $id)
                            ->update([
                                'title' => $title,
                                'slug' => $slug,
                                'description' => $description,
                                'parent_id' => $parent_id,
                                'image' => $image,
                                'updated_at' => $updated_at
            ]);
        } else {
            return DB::table('categorypost')
                            ->where('id', $id)
                            ->update([
                                'title' => $title,
                                'slug' => $slug,
                                'description' => $description,
                                'parent_id' => $parent_id,
                                'image' => $image,
                                'updated_at' => $updated_at
            ]);
        }
    }

    public function addCatePost($title, $slug, $description, $parent_id, $image, $created_at) {
      return DB::table('categorypost')->insertGetId([
                  'title' => $title,
                  'slug' => $slug,
                  'description' => $description,
                  'parent_id' => $parent_id,
                  'image' => $image,
                  'created_at' => $created_at
      ]);
    }

    public function listItem($limit) {
        return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
//                        ->where('categorypost.id', 7)
                        ->where('categorypost.slug', 'san-pham')
                        ->select('post.*')
                        ->limit($limit)
                        ->orderBy('post.created_at', 'desc')
                        ->get();
    }

    public function postFirst($category) {
            
        return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', $category)
                        ->where('feature', 1)
                        ->select('post.*')
                        ->orderby('orderby', 'asc')
                        ->first();
                    
    }
    
    public function postFeature($category, $limit) {
         DB::enableQueryLog();
       return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->join('post_language','post.id','=','post_language.post_id')
                        ->where('categorypost.slug', $category)
                        ->where('feature', 0)
                         ->where('post_language.language_id',get_id_locale(Session()->get('locale')))
                        ->select('post.*','categorypost.slug as cateSlug')
                        // ->orderby('orderby', 'asc')
                        ->limit($limit)
                        ->get();
                $queries = DB::getQueryLog();
             //  dd($queries);
               

    }

    public function getPost($slug) {
        return DB::table("post")->where('slug', $slug)->first();
    }

    public function listProject() {
        return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', 'du-an')
                        ->select('post.*')
                        ->orderBy('post.created_at', 'desc')
                        ->limit(8)
                        ->get();
    }

    public function getProjectCate($id) {
        return DB::table('categorypost')->where('parent_id', $id)->orderBy('orderby', 'asc')->get();
    }

    public function listPost($cate_slug, $post_status = 1, $feature = 0, $language, $select = [], $limit=0) {
        $category = $this->getCategoryPost($cate_slug, $language, ['categorypost.id']);
            if(!$category){
                return false;
            }
        $query = DB::table('post');
                        $query->join('categorypost', 'post.id_cate', '=', 'categorypost.id');
                        
                        if($language > 0){
                            $query->join('post_language','post.id','=','post_language.post_id');
                            $query->join('categorypost_language', 'categorypost_language.categorypost_id','=','categorypost.id');
                            $query->where('post_language.language_id', $language);
                            $query->where('categorypost_language.language_id', $language);
                            $query->where('categorypost_language.categorypost_id', $category->id);
                        }else{
                            $query->where('categorypost.id', $category->id);
                        }
                        $query->where('post.post_status', $post_status);
                        $query->where('post.feature', $feature);
                        // $query->where('post.id_cate','categorypost.parent_id');
                        
                        if($limit > 0){
                            $query->limit($limit);
                        }
                        // if($offset>0 && $limit>0){
                        //     $query->offset($offset);
                        //     $query->limit($limit);
                        // }
                        $query->select($select);
                        $query->orderby('post.orderby','asc');
                //  dd($query->toSql());
                        return $query->get();
//                        ->paginate($limit);
    }

    public function listPostMultiCategory($multi_id = [], $post_status = 1, $feature = 0, $language, $select = [], $limit){
        $query = DB::table('post');
        if($language > 0){
            $query->join('post_language','post.id','=','post_language.post_id');
            $query->where('post_language.language_id', $language);
        }
        $query->whereIn('post.id_cate', $multi_id);
        $query->where('post.post_status', $post_status);
        $query->where('post.feature', $feature);
        if($limit > 0){
            $query->limit($limit);
        }
        $query->select($select);
        $query->orderby('post_language.created_at', 'desc');
      //  dd($query->toSql());
        return $query->get();
    }

    public function getCategoryPost($slug, $language_id = 0, $select = []) {
        $query = DB::table('categorypost');
        if($language_id > 0){
            $query->join('categorypost_language','categorypost_language.categorypost_id','=','categorypost.id');
                $query->where('categorypost_language.slug', $slug);
        }else{
            $query->where('categorypost.slug', $slug);
        }
        $query->select($select);
        // dd( $query->toSql());

        return $query->first();
    }
    

    public function listPostProjectCate($slug, $limit) {
//        echo $slug;exit;
        return DB::table('post')
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', $slug)
                        ->select('post.*')
                        ->orderby('post.created_at', 'desc')
                        ->paginate($limit);
    }

    public function getPostSlug($slug) {

        $postData = DB::table('post')
                ->where('slug_' . trans('home.lang'), $slug)
                ->first();
        return $postData;
    }

    public function getListProduct($slug) {
        return DB::table("post")
                        ->select("post.*", "categorypost.slug as cateslug")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', $slug)
                        ->get();
    }

    public function getPostProjectCollection($id) {
        return DB::table('post')
                        ->where('id', $id)
                        ->first();
    }
    
    public function getPostFeature($slug) {
        return DB::table("post")
                        ->select("post.*")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->orderby('created_at', 'desc')
                        ->where('categorypost.slug',$slug)
                        ->first();
    }

    public function listPost01($id_cate, $limit) {
        return DB::table("post")
                        ->where('id_cate', $id_cate)
                        ->orderby('created_at', 'desc')
                        ->paginate($limit);
//                ->get();
    }
    
    public function listCategoryPost($slug) {
        return DB::table("post")
                        ->select("post.*")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('categorypost.slug', $slug)
                        ->orderby('created_at', 'desc')
                        ->limit(4)
                ->get();
    }

    public function listPost02($id_cate, $slug, $limit) {
        return DB::table("post")
                        ->where('id_cate', $id_cate)
                        ->orderby('created_at', 'desc')
                        ->having('slug', '<>', $slug)
                        ->limit($limit)
                        ->get();
    }

    public function relatedProduct($slug1, $slug2, $limit) {
        return DB::table("post")
                        ->select("post.*", "categorypost.slug as cateslug")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->where('post.slug', '<>', $slug2)
                        ->where('categorypost.slug', $slug1)
                        ->limit($limit)
                        ->get();
    }

    public function listPostNewsFeature() {
        return DB::table("post")
                        ->where('id_cate', 3)
                        ->where('feature', 1)
                        ->orderby('created_at', 'desc')
                        ->paginate(5);
    }

    // Show menu con project
    public function listCateProject() {
        return DB::table("categorypost")
                        ->where('parent_id', 7)
                        ->orderby('orderby', 'desc')
                        ->get();
    }

    public function getCollection($slug) {
        return DB::table("post")
                        ->select('id_collection')
                        ->where('slug', '=', $slug)
                        ->first();
    }

    public function listCollectionProject($slug, $id_collection) {
        return DB::table("post")
                        ->where('slug', '!=', $slug)
                        ->where('id_collection', $id_collection)
                        ->where('id_collection', '>', 1)
                        ->get();
    }

    public function updateSlugPost($id, $slug) {
      return DB::table('post')->where('id', $id)->update([
                  'slug' => $slug
      ]);
    }

    public function getSlug($id, $lang) {
            return DB::table('post')->where('id', $id)->select('slug')->first();
    }


    
    public function getCate($slug) {
        return DB::table('post')
                ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                ->select('post.id_cate', 'categorypost.title as catetitle')
                ->where('post.slug', $slug)
                ->first();
    }
    
    public function getPostRelated($post_slug, $id_cate, $limit) {
        return DB::table("post")
                        ->where('slug', '!=', $post_slug)
                        ->where('id_cate', $id_cate)
                        ->limit($limit)
                        ->get();
    }
    
    public function getPostMetaTag($slug){
        return DB::table("post")
                        ->where('slug', $slug)
                        ->first();
    }
    
    public function sitemap(){
        return DB::table("post")
                        ->join('categorypost', 'post.id_cate', '=', 'categorypost.id')
                        ->select('post.*', 'categorypost.title as namecate', 'categorypost.slug as cateslug')
                        ->orderby('created_at', 'desc')
                        ->get();
    }
    
    public function setView($id, $count_views){
        return DB::table('post')
                ->where('id', $id)
                            ->update([
                                'count_views' => $count_views
            ]);
    }

    public function getDuAn($cate_id, $work = '', $project = ''){
      // print_r($listIDCate);
      // echo ($work.' '.$project);
      // echo "<pre>";
      // print_r($cate_id);
      if(($work == 'all' && $project == 'all') || ($work == '' && $project == '')){
        $query = DB::table('post');
        $query->join('post_language','post.id','=','post_language.post_id');
        $query->join('categorypost_language','categorypost_language.categorypost_id','=','post.id_cate');
        $query->whereIn('post.id_cate', $cate_id);
        $query->where('post_language.language_id',get_id_locale());
        $query->where('categorypost_language.language_id',get_id_locale());
        $query->orderby('post_language.created_at','desc');
        $query->select('post_language.*', 'categorypost_language.slug as cateslug', 'post.image as image','post.id_cate');
        return $query->paginate(16);
      }
      elseif($work != '' && $project != ''){
      // DB::connection()->enableQueryLog();
        // echo $cate_id;exit;
        $query = DB::table('post');
        $query->join('post_language','post.id','=','post_language.post_id');
        $query->join('categorypost_language','categorypost_language.categorypost_id','=','post.id_cate');
        if($work != 'all'){
          $query->join('work', 'work.id_work', '=', 'post.id_work');
          $query->where('work.slug', $work);
          $query->where('work.language_id',get_id_locale());
        }
        if($project != 'all'){
          $query->join('project_type', 'project_type.id_project_type', '=', 'post.id_project_type');
          $query->where('project_type.slug', $project);
          $query->where('project_type.language_id',get_id_locale());
        }
        $query->whereIn('post.id_cate', $cate_id);
        $query->where('post_language.language_id',get_id_locale());
        $query->where('categorypost_language.language_id',get_id_locale());
        $query->orderby('post_language.created_at','desc');
        $query->select('post_language.*', 'categorypost_language.slug as cateslug', 'post.image as image','post.id_cate');
        // else{
        //   $query->where('work.slug', '=', $work);
        //   $query->where('work.language_id', '=', get_id_locale());
        // }
        // $query->paginate(16);
        // $queries = DB::getQueryLog();
        // dd(end($queries));
        return $query->paginate(16);
      }else{
        $query = DB::table('post');
        $query->join('post_language','post.id','=','post_language.post_id');
        $query->join('categorypost_language','categorypost_language.categorypost_id','=','post.id_cate');
        $query->whereIn('post.id_cate',$cate_id);
        $query->where('post_language.language_id',get_id_locale());
        $query->where('categorypost_language.language_id',get_id_locale());
        $query->orderby('post_language.created_at','desc');
        $query->select('post_language.*', 'categorypost_language.slug as cateslug', 'post.image as image');
        return $query->paginate(16);
        
      }
      $query = DB::table('post');
      $query->join('post_language','post.id','=','post_language.post_id');
      $query->join('categorypost_language','categorypost_language.categorypost_id','=','post.id_cate');
      $query->where('post.id_cate',$cate_id);
      $query->where('categorypost_language.language_id', get_id_locale());
      $query->where('post_language.language_id', get_id_locale());
      if($cate_id == 38){
        $query->orderby('post.feature','desc');

      }else{
        $query->orderby('post_language.created_at','desc');

      }
      
      $query->select('post_language.*','categorypost_language.slug as cateslug','categorypost_language.title as catetitle','post.image');
      // $query->paginate(18);
      // $queries = DB::getQueryLog();
      // dd(end($queries));
      return $query->paginate(18);
    }

}