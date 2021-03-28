<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model {

    //
    protected $table = 'banner';
    protected $fillable = ['title', 'label', 'description', 'id_cate', 'link', 'feature', 'image', 'created_at', 'updated_at'];
	public function language()
	{
		return $this->hasMany('App\BannerLanguage','id_banner','id');	    
	}
	public function currentLanguage()
	{
		return $this->hasMany('App\BannerLanguage','id_banner','id')->where('language_id',get_id_locale());    
	}
    public function getListBanner($id_banner) {
        $banners = DB::table('banner')->whereId($id_banner)->first();
        return $banners;
    }

    public function getListScreenshot($id_screenshot) {
        $listscreen = DB::table('banner')->where('id_cate', $id_screenshot)->get();
        return $listscreen;
    }

    public function getAdminListBanner() {
        return DB::table('banner')->orderby('created_at', 'desc')->get();
    }

    public function delBanner($id) {
        return DB::table('banner')->where('id', $id)->delete();
    }

    public function getViewSlide($id) {
//        return DB::table('banner')->where('id', $id)->get();
        return DB::table("banner")->whereId($id)->first();
    }

    public function getListId() {
        return DB::table('banner')->pluck('id');
    }

    public function getBannerTop($id) {
        return DB::table('banner')
                    ->join('banner_language','banner.id','=','banner_language.id_banner')
                    ->where('banner_language.language_id',get_id_locale(Session()->get('locale')))
                    ->where('banner.id_cate', $id)
                 //   ->orderby('created_at', 'desc')
                    ->get();
    }
    
    public function getBanner($id_cate) {
        return DB::table('banner')->where('id_cate', $id_cate)->orderby('created_at', 'desc')->first();
    }

    public function updateBanner($lang, $id, $title, $label, $id_cate, $link, $image, $updated_at) {
        if ($lang == "en") {
            return DB::table('banner')
                            ->where('id', $id)
                            ->update([
                                'name' => '',
                                'title_en' => $title,
                                'label_en' => $label,
                                'id_cate' => $id_cate,
                                'link_en' => $link,
                                'image' => $image,
                                'updated_at' => $updated_at
            ]);
        } else {
            return DB::table('banner')
                            ->where('id', $id)
                            ->update([
                                'name' => '',
                                'title_vn' => $title,
                                'label_vn' => $label,
                                'id_cate' => $id_cate,
                                'link_vn' => $link,
                                'image' => $image,
                                'updated_at' => $updated_at
            ]);
        }
    }

    public function insertBannerSlide($lang, $title, $label, $id_cate, $link, $image, $created_at) {
        if ($lang == "en") {
            return DB::table('banner')
                            ->insertGetId([
                                'title_en' => $title,
                                'label_en' => $label,
                                'id_cate' => $id_cate,
                                'link_en' => $link,
                                'image' => $image,
                                'created_at' => $created_at
            ]);
        }else{
            return DB::table('banner')
                            ->insertGetId([
                                'title_vn' => $title,
                                'label_vn' => $label,
                                'id_cate' => $id_cate,
                                'link_vn' => $link,
                                'image' => $image,
                                'created_at' => $created_at
            ]);
        }
    }

    public function getFirstBanner($id_cate, $feature = 0, $language_id){
// DB::connection()->enableQueryLog();
        $query = DB::table('banner_language')
                    ->join('banner','banner_language.id_banner','=','banner.id')
                    ->where('banner.id_cate', '=', $id_cate)
                    ->where('banner_language.language_id', '=', $language_id)
                    ->where('banner.feature', '=', $feature)
                    ->orderby('banner_language.created_at','desc')
                    ->select('banner_language.title','banner_language.label','banner_language.description','banner_language.link','banner_language.created_at','banner_language.image')
                    ->first();
        // $queries = DB::getQueryLog();
        return $query;
    }

    public function getNextBanner($id_cate, $feature = 0, $language_id){
// DB::connection()->enableQueryLog();
        $query = DB::table('banner_language')
                    ->join('banner','banner_language.id_banner','=','banner.id')
                    ->where('banner.id_cate', '=', $id_cate)
                    ->where('banner_language.language_id', '=', $language_id)
                    ->where('banner.feature', '=', $feature)
                    ->orderby('banner_language.created_at','desc')
                    ->select('banner_language.title','banner_language.label','banner_language.description','banner_language.link','banner_language.created_at','banner_language.image')
                    ->limit(2)
                    ->get();
        // $queries = DB::getQueryLog();
        return $query;
    }
    

}