<?php
namespace App\Http\Controllers;
use App;
use App\Banner;
use App\Post;
use App\PostLanguage;
use App\Page;
use App\Section;
use App\Gallery;
use App\Customer;
use App\Video;
use App\Quotation;
use App\Posttag;
use App\CategoryQuotation;
 use App\CategorypostLanguage;
use App\Categorypost;
use App\Products;
use App\ProductType;
use App\ProductTypeRelationships;
use Session;
use App\Member;
use App\Partner;
use App\Menu;
use DB;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
class PageController extends AppController {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Posttag $posttag, Page $page, Post $post, Banner $banner, Section $section, Gallery $gallery, Customer $customer, Video $video, Menu $menu, Categorypost $categorypost, Partner $partner) {
    //   CategorypostLanguage $categorypostlanguage,
        parent::__construct();
        $this->banner = $banner;
        $this->post = $post;
        $this->page = $page;
        $this->section = $section;
        $this->gallery = $gallery;
        $this->customer = $customer;
        $this->video = $video;
        $this->menu = $menu;
        $this->categorypost = $categorypost;
        // $this->categorypostlanguage = $categorypostlanguage;
        $this->posttag = $posttag;
        $this->partner = $partner;
    }
    public function index($slug, Request $request) {
        // echo get_id_locale();
        // $slug = $request->segment(1);
        // if($slug){
        //     $listPost = $this->post->listOneCatePost($slug, 10)->toArray();
        //     return view('pages.blog',[
        //         'bannerslide' => $this->banner->getBannerTop(1)->toArray(),
        //         'getMenuTop' => $this->menu->getListCate(1)->toArray(),
        //         'getMainMenu' => $this->menu->getListCate(3)->toArray(),
        //         'getQuickLink' => $this->menu->getListCate(2)->toArray(),
        //         'getMenuBTG' => $this->menu->getListCate(4)->toArray(),
        //         'getCategory' => $this->categorypost->getCategory($slug),
        //         'listPost' => $listPost,
        //     ]);
        // }else{
        //     return redirect()->route('home');
        // }
        // return redirect()->route('home');
        // dd($slug);
        switch ($slug) {
            case 'gioi-thieu':
            case 'about':
                $status_page = 2;
                //   $queries = DB::getQueryLog();
                 $cataPost=Categorypost::join('categorypost_language','categorypost.id','=','categorypost_language.categorypost_id')
                 ->where('categorypost_language.language_id',get_id_locale(Session()->get('locale')))
                 ->where('categorypost_language.slug','=',$slug)
                 ->select('categorypost_language.title','categorypost_language.description')
                 ->first();
                // dd($cataPost->toSql());
               // print_r($queries);s
                
                $select = [
                    'post_language.title',
                    'post_language.slug',
                    'post_language.description',
                    'post.created_at',
                    'post.image'
                ];
                return view("pages.about", [
                   'categoryPost'=>$cataPost,
                    'getFeatureService' => $this->post->listPost($slug, 1, 0, get_id_locale(Session()->get('locale')), $select, 0),
                    'status_page' => $status_page,
                    'getPage' => $this->page->getPage($slug),
                    'metaPage' => $this->page->getPageMetaTag($slug)
                ]);
            break;
            case 'tin-tuc':
            case 'news':
                $status_page = 2;
                $getCategory=$this->categorypost->getCategory($slug, get_id_locale(Session()->get('locale')),
                ['categorypost_language.categorypost_id','categorypost_language.title','categorypost_language.slug','categorypost_language.description']);
               
                $arr_idcate = [];
                $this->treeCategoryPost($getCategory->categorypost_id, $arr_idcate);
    
                 $select = [
                    'post_language.title',
                    'post_language.slug',
                    'post_language.description',
                    'post.created_at',
                    'post.image'
                ];
               $listPost = $this->post->listPostMultiCategory($arr_idcate, $post_status = 1, $feature = 0, get_id_locale(Session()->get('locale')), $select, 0);
         

                return view("pages.news", [
                    'categoryPost'=>$getCategory,
                    'getFeatureService' => $listPost,
                    'status_page' => $status_page,
                    'getPage' => $this->page->getPage($slug),
                    'metaPage' => $this->page->getPageMetaTag($slug)
                ]);
            break;
            case 'lanh-dao-tap-doan':
            case 'director-of-the-group':
                $status_page=2;
                $select = [
                    'post_language.title',
                    'post_language.slug',
                    // 'post_language.id',
                    'post_language.description',
                    'post.created_at',
                    'post.image'
                ];
                $listPost= $this->post->listPost($slug, 1, 0, get_id_locale(Session()->get('locale')), $select,3);
                return view("pages.lanhdaotapdoan", [
                     'listPost' => $listPost,
                     'status_page' => $status_page,
                     'getPage' => $this->page->getPage($slug),
                     'metaPage' => $this->page->getPageMetaTag($slug)
                 ]);
            break;

            case 'ban-tong-giam-doc':
            case 'board-of-general-directors':
                    $status_page=2;
                    $select = [
                        'post_language.title',
                        'post_language.slug',
                        'post_language.description',
                        'post.created_at',
                        'post.image'
                    ];
                    if(get_id_locale(Session()->get('locale'))==1){
                        $slug='lanh-dao-tap-doan';
                    }
                    else{
                        $slug='director-of-the-group';
                    };
                    $listPost= $this->post->listPost($slug, 1, 0, get_id_locale(Session()->get('locale')), $select, 5);
                    return view("pages.banlanhdao", [
                         'listPost' => $listPost,
                         'status_page' => $status_page,
                         'getPage' => $this->page->getPage($slug),
                         'metaPage' => $this->page->getPageMetaTag($slug)
                     ]);
            break;

            case 'du-an-moi':
            case 'new-project':
                $status_page = 2;
                //   $queries = DB::getQueryLog();
                 $cataPost=Categorypost::join('categorypost_language','categorypost.id','=','categorypost_language.categorypost_id')
                 ->where('categorypost_language.language_id',get_id_locale(Session()->get('locale')))
                 ->where('categorypost_language.slug','=',$slug)
                 ->select('categorypost_language.title','categorypost_language.description')
                 ->first();
                // dd($cataPost->toSql());
               // print_r($queries);
                
                $select = [
                    'post_language.title',
                    'post_language.slug',
                    'post_language.description',
                    'post.created_at',
                    'post.image'
                ];
                return view("pages.about", [
                   'categoryPost'=>$cataPost,
                    'getFeatureService' => $this->post->listPost($slug, 1, 0, get_id_locale(Session()->get('locale')), $select, 0),
                    'status_page' => $status_page,
                    'getPage' => $this->page->getPage($slug),
                    'metaPage' => $this->page->getPageMetaTag($slug)
                ]);
            break;
            case 'lien-he':
            case 'contact':
                $status_page = 2;
                return view("pages.contact", [
                    'status_page' => $status_page,
                    'getPage' => $this->page->getPage($slug),
                    'metaPage' => $this->page->getPageMetaTag($slug)
                ]);
            break;
            // case 'thong-bao':
            //     $status_page = 2;
            //     return view("pages.notify", [
            //         'status_page' => $status_page,
            //         'getPage' => $this->page->getPage($slug),
            //         'metaPage' => $this->page->getPageMetaTag($slug)
            //     ]);
            // break;
            // case 'blog':
            //     $status_page = 2;
            //     $listPost = Post::join('categorypost','post.id_cate','=','categorypost.id')->where('categorypost.slug', $slug)->where('post.post_status',1)->orderby('post.created_at','desc')->select('post.title','post.slug','post.image','post.description')->get();
            //     // dd($listPost->toArray());
            //     return view("pages.news", [
            //         'status_page' => $status_page,
            //         'listPost' => $listPost,
            //         'getPage' => $this->page->getPage($slug),
            //         'metaPage' => $this->page->getPageMetaTag($slug),
            //     ]);
            // break;
            // case 'sitemap.xml':
            //     $posts = $this->post->sitemap();
            //     $pages = $this->page->sitemap();
            //     $listTag = Posttag::orderBy('created_at')
            //         ->select('id', 'name', 'slug', 'created_at','updated_at')
            //         ->get()
            //         ->toArray();
            //     return response()->view('vendor.sitemap', compact('posts', 'pages', 'listTag'))->header('Content-Type', 'text/xml');
            // break;
            default :
// lay danh sach bai viet thuoc category
            $currentCategory = $this->categorypost->getCategory($slug, get_id_locale(Session()->get('locale')), ['categorypost.title','categorypost.description','categorypost.slug']);
    
            if($currentCategory){
                // $status_page = 4;
                $listPost = $this->post->listPost($currentCategory->slug, $post_status = 1, $feature = 0, get_id_locale(Session()->get('locale')), ['post_language.title','post.image','post_language.slug','post_language.description','post_language.created_at'], 0);

                return view("pages.catepost",[
                    'categoryPost'=>$currentCategory,
                    'getFeatureService' =>$listPost,
                    // 'status_page' => $status_page,
                    'getPage' => $this->page->getPage($slug),
                    'metaPage' => $this->page->getPageMetaTag($slug)
                ]);
            }
                       
            


// chi tiet bai viet

                $getPost=Post::join('post_language','post.id','=','post_language.post_id')
                            ->join('categorypost','categorypost.id','=','post.id_cate')
                            ->join('categorypost_language','categorypost_language.categorypost_id','=','categorypost.id')
                            ->where('post_language.language_id',get_id_locale(Session()->get('locale')))
                            ->where('categorypost_language.language_id',get_id_locale(Session()->get('locale')))
                            ->where('post_language.slug','=',$slug)
                            ->where('post.post_status',1)
                            ->select('post_language.title','post_language.content','post_language.slug','categorypost_language.title as titlecate','categorypost_language.slug as slugcate')
                            ->first();
            
            
                if($getPost){
                    $relatedPost = [];
                    if($getPost->cate_slug){
                        $relatedPost = Post::join('categorypost','post.id_cate','=','categorypost.id')
                        ->where('post.slug', '!=', $slug)
                        ->where('categorypost.slug',$getPost->cate_slug)
                        ->where('post.post_status',1)
                        ->select('post.title','post.slug','post.image','post.description','post.created_at', 'categorypost.title as cate_title')
                        ->inRandomOrder()->get();
                    }
                    $status_page = 5;
                         $select = [
                        'post_language.title',
                        'post_language.slug',
                        // 'post_language.description',
                        'post.created_at',
                        'post.image'
                    ];
                    $getCate=Post::join('categorypost','categorypost.id','=','post.id_cate')
                    ->join('categorypost_language','categorypost_language.categorypost_id','=','categorypost.id')
                    ->where('categorypost_language.language_id',get_id_locale(Session()->get('locale')))
                    // ->where('categorypost_language.slug','=',slug)
                    ->select('categorypost_language.title')
                    ->get();
                    // $getCate->toSql();
                    // ->toArray();
                    // dd($getCate->toSql());
                    $catepost_slug=$getPost->slugcate;
                    return view("pages.detail",[
                        'status_page' => $status_page,
                        'post' => $getPost,
                        //  'cate'=>$getCate,
                        'getAboutArticle' => $this->post->listPost($catepost_slug, 1, 0, get_id_locale(Session()->get('locale')), $select, 0),
                        'relatedPost' => $relatedPost,
                         'metaPage' => $getPost
                    ]);
                }
                
                // dd($slug);
               
             
                
                
                // dd($getProduct);
                // return view('pages.blog',[
                //     'bannerslide' => $this->banner->getBannerTop(1)->toArray(),
                //     'getCategory' => $this->categorypost->getCategory($slug),
                //     'listPost' => $listPost,
                //     'status_page' => $status_page
                // ]);
                $status_page = 10;
                return view('errors.404');
                
            break;
        }
    }

    public function language($code = ''){
        if(!$code){
            session()->flash('not found code language');
            return redirect()->abort('404');
        }
        $languages = array_values(config('app.locales'));
        if(!in_array($code,$languages)){
            session()->flash('not found language');
            return redirect()->abort('404');
        }
        //dd($code);
        session()->put('locale',$code);
        App::setLocale('vi');
        // return redirect($_SERVER['HTTP_REFERER']);
        // dd(session()->get('locales'));
        //dd(App::getLocale());
        return redirect()->to('/');
    }

    public function treeCategory($parent_id = 0, &$submark = []) {
        $submark[] = $parent_id;
        $query = ProductType::productParentCategory($parent_id);
        // dd($query->toArray());
        if ($query) {
            foreach ($query as $count => $catepost) {
                $submark[] = $catepost->id;
                $this->treeCategory($catepost->id, $submark);
            }
        }
        return $submark;
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function detail($cate_slug, $post_slug) {
        // dd($post);
        if (!$this->post->getPost($cate_slug, $post_slug)) {
            return abort(404);
        }
        $post = $this->post->getPost($cate_slug, $post_slug);
       // echo $post->count_views;exit;
        $key = 'myblog' . $post->id;
        // dd($post);
        $arr = explode(',', $post->id_tag);
        $listTag = Posttag::whereIn('id', $arr)
                    ->orderBy('created_at')
                    ->select('id', 'name', 'slug')
                    ->get()
                    ->toArray();
        if (!Session::has($key)) {
            $count_views = $post->count_views + 1;
            $this->post->setView($post->id, $count_views);
            Session::put($key, 1);
        }

        return view('pages.' . Route::currentRouteName(), [
            'bannerslide' => $this->banner->getBannerTop(1)->toArray(),
            'getCategory' => $this->categorypost->getCategory($cate_slug),
            'cateSlug' => $cate_slug,
            'post' => $post,
            'status_page' => 4,
            'listTag' => $listTag,
            'status_page' => 4,
            // 'bannerslide' => $this->banner->getBannerTop(1),
            // 'sectiondoctor' => $this->section->getOneSection(19),
            // 'getpost' => $post,
            // 'getmeta' => $this->post->getPostMetaTag($slug),
            // 'getpopup' => $this->banner->getBanner(3),
            'getpostrelated' => $this->post->getPostRelated($cate_slug, $post_slug, 3)->toArray(),
            // 'banner' => $this->banner->getBanner(2),
            // 'cate_title' => $post->catetitle_vn
        ]);
    }
    public function tag($tag_slug){
        $getTag = $this->posttag->singleTag($tag_slug,[
            'slug',
            'name',
            'id',
            'description',
            'image'
        ]);
        $listPost = $this->post->getPostTag($getTag->id,[
            'id',
            'title_vn',
            'slug_vn',
            'image',
            'cateslug'
        ]);
        // dd($listPost);
        // exit;
        return view('pages.tag',[
            'getCategory' => '',
            'status_page' => 5,
            'bannerslide' => $this->banner->getBannerTop(1)->toArray(),
            'listPost' => $listPost,
            'getTag' => $getTag,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function loadMore(Request $request, $cateslug) {
//        echo $cateslug;exit;
        //
        $id_cateparent = $this->post->getCategory($cateslug);
//        echo "<pre>";
//        print_r($id_cateparent);
//        echo "</pre>";
//        exit;
        if ($cateslug == "dich-vu") {
            $number = 8;
        } else {
            $number = 6;
        }
        $listItem = $this->post->getPostCate($id_cateparent->id, 3, $number);
        if ($request->ajax()) {
            return response()->json(view('layouts.loadmore', ['listItem' => $listItem, 'cateslug' => $cateslug])->render());
        }
        return view('layouts.loadmore', [
            'listItem' => $this->post->getPostCate($id_cateparent->id, 3, $number),
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function login() {

        //
        if (Auth::check()) {
            // The user is logged in...
            return redirect()->route('account');
        }
        return view('pages.login');
    }

    public function account() {

        //
        if(!Auth::check()){
            return redirect()->to('dang-nhap');
        }
        // print_r(Session::all());
        // echo Session::get('status');
        // exit;
        // if(Session::get('user_status') == 1){
        //     return redirect()->to('/');
        // }
        // dd(Auth::user());
        $user = $this->customer->getCustomer(Auth::user()->customer_id,['*']);
        $province = $this->province->getProvince();

        $listDistrict = $this->district->getDistrict($user->city);
        
        // dd($user);
        // dd($hcmcity);
        return view('pages.account',[
            'province' => $province,
            'listDistrict' => $listDistrict,
            'getmeta' => $this->page->getPageMetaTag(),
            'user' => $user
        ]);
    }

    public function notify(Request $request, $order_id){
        // echo count(base64_decode($order_id));
        // dd('a');
        $str = substr(base64_decode($order_id), 0, -8);
        // $str = ends_with(base64_decode($order_id), 'jteck387');
        // dd($str);

        if(!$str){
            return redirect()->to('/');
        }
        $result = Orders::where('order_number', $str)->select('*')->first();
        if(!$result){
            return abort('404');
        }
        $orderDetail = OrderDetail::where('order_id',$result->id)->get();
        $customer = Customer::where('id',$result['customer_id'])->first()->toArray();
        if(!$customer){
            return redirect()->to('/');
        }
        // dd($result);
        return view('product.notify',[
            'order' => $result,
            'customer' => $customer,
            'orderDetail' => $orderDetail
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}