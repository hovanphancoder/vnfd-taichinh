<?php
namespace App\Http\Controllers;
use App\Banner;
use App\BannerLanguage;
use App\PostLanguage;
use App\Section;
use App\SectionLanguage;
use App\Setting;
use App\Post;
use App\Page;
use App\Video;
use App\Customer;
use App\Partner;
use App\Categorypost;
use App\ProductType;
use App\Menu;
use App\MenuLanguage;
use App\Products;
use App;
use DB;
use Lang;
use Session;
use Illuminate\Support\Facades\Cache;

class HomeController extends AppController {

    public function __construct(Post $post, Banner $banner, Section $section, Page $page, Partner $partner, Video $video, Customer $customer, Categorypost $categorypost, Menu $menu, Setting $setting) {
        parent::__construct();
        $this->banner = $banner;
        $this->section = $section;
        $this->post = $post;
        $this->page = $page;
        $this->partner = $partner;
        $this->video = $video;
        $this->customer = $customer;
        $this->categorypost = $categorypost;
        $this->menu = $menu;
        $this->setting = $setting;
        // Session::flush();

    }
    public function index() {
        // dd(App::getLocale());
        //echo 30*22500;TadebW_hj7365
        // Cache::flush();
    
        $status_page = 1;
        $featureProductCategory = ProductType::where('parent_id', 0)
                    ->where('feature', 1)
                    ->orderby('created_at','desc')
                    ->limit(5)
                    ->get();
       
        $getSectionAbout  = Section::join('section_language','section.id','=','section_language.section_id')    
                    ->where('section.id',18)
                    ->where('section_language.language_id',get_id_locale(Session()->get('locale')))
                    ->first()
                    ->toArray();

        // $getNewProject = Post::join('categorypost', 'post.id_cate','=','categorypost.id')
        //             ->join('post_language','post.id','=','post_language.post_id')
        //             ->where('categorypost.slug','du-an-moi')
        //             ->where('post.post_status', 1)
        //             ->where('post_language.language_id',get_id_locale(Session()->get('locale')))
        //             ->orderby('post.created_at','desc')
        //             ->select('post.title','post_language.*','post.image','post.created_at','post.slug')
        //             ->get();

        // $getNhaDauTu = Post::join('categorypost', 'post.id_cate','=','categorypost.id')
        //             ->join('post_language','post.id','=','post_language.post_id')         
        //             ->where('categorypost.slug','nha-dau-tu')
        //             ->where('post.post_status', 1)
        //             ->where('post_language.language_id',get_id_locale(Session()->get('locale')))
        //             ->orderby('post.created_at','desc')
        //             ->select('post.*','post_language.*','post.image','post.created_at','post.slug')
        //             ->get();

        $getNews =  Post::join('categorypost', 'post.id_cate','=','categorypost.id')
                    ->join('post_language','post.id','=','post_language.post_id')        
                    // ->where('categorypost.slug','tin-tuc')
                    ->where('post.post_status', 1)
                    ->where('post_language.language_id',get_id_locale(Session()->get('locale')))
                    ->orderby('post.created_at','desc')
                    ->select('post_language.title','post.image','post.created_at','post_language.slug')
                    ->limit(3)
                    ->get();
        $getNewProject = $this->post->listPost('du-an-moi', 1, 0, get_id_locale(Session()->get('locale')), $select = ['post_language.title','post.image','post_language.slug','post.created_at','post_language.description'], 10);
        $getNhaDauTu = $this->post->listPost('nha-dau-tu', 1, 0, get_id_locale(Session()->get('locale')), $select = ['post_language.title','post.image','post_language.slug','post.created_at','post_language.description'], 10);
    
        // $getCategory=$this->categorypost->getCategory($slug, get_id_locale(Session()->get('locale')),
        // ['categorypost_language.categorypost_id','categorypost_language.title','categorypost_language.slug','categorypost_language.description']);

        // $arr_idcate = [];
        // $this->treeCategoryPost($getCategory->categorypost_id, $arr_idcate);
        // $getNews = $this->post->listPost('tin-tuc', 1, 0, get_id_locale(Session()->get('locale')), $select = ['post_language.title','post.image','post_language.slug','post.created_at','post_language.description'], 10);

        $metaPage = $this->page->getPageMetaTag();

        return view('pages.home',[
            'bannerslide' => $this->banner->getBannerTop(1)->toArray(),
            'getPage' => $this->page->getPage("/"),
            'getSectionAbout' => $getSectionAbout,
            'getNhaDauTu' => $getNhaDauTu,
            'getNewProject' => $getNewProject,
            'featureProductCategory' => $featureProductCategory,
            'getNews' => $getNews,
            'status_page' => $status_page,
            'trackads' => $this->getTrack(),
            'metaPage' => $metaPage
        ]);
    }
    public function getBanner($id_banner)
    {
        $viewbanner = new Banner();
        return $viewbanner->getBanner($id_banner);
    }
    
    public function getServices()
    {
        $section = new Section();
        return $section->getSectionServices();
    }
    public function getTrack()
    {
        $track = new Setting();
        return $track->getAdvertising();
    }
    
    public function setNewsletter(Request $request){
        
    }
    
    public function getSource(){
//        return view('layouts.banner',[
//            "aa" => "dsadasdsa"
//        ]);
//        return response()->json(['success' => '<p>Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>']);
        return response()->view('layouts.banner',[
            'bannerslide' => $this->banner->getBannerTop(1)
        ])->header('Content-Type', 'text/plain');
    }
}