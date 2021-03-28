<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Products;
use App\ProductLanguage;
use App\ProductType;
use App\ProductAccessories;
use App\ProductOption;
use App\Categorypost;
use App\Page;
use App\Post;
use App\Cart;
use App\Banner;
use App\Unit;
use App\Trademark;
use App\TrademarkLanguage;
use App\CategorypostLanguage;
use App\Section;
use App\OptionValue;
use App\Work;
use App\ProjectType;
use App\ProductOptionValue;
use App;
use Cache;
use Session;

class ProductController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(ProjectType $project_type, Work $work, Post $post, OptionValue $option_value, Section $section, ProductLanguage $products_language, ProductType $producttype, Products $product, Page $page, Banner $banner) {
        parent::__construct();
        $this->product = $product;
        $this->project_type = $project_type;
        $this->work = $work;
        $this->page = $page;
        $this->producttype = $producttype;
        $this->products_language = $products_language;
        $this->section = $section;
        $this->option_value = $option_value;
        $this->banner = $banner;
        $this->post = $post;
		if(is_null(session('locale')))
		{
			if(App::getLocale() == '') $t = 'en';else $t = App::getLocale();
		  session(['locale'=> $t]);
		}
		app()->setLocale(session('locale'));
    }
	public function language($code=''){//print_r($code);exit;
		if(!$code){
			set_flash_message('not found code language');
			return redirect()->route('common.admin.dashboard.error',400);
		}
		$languages = array_values(config('app.locales'));
		if(!in_array($code,$languages)){
			set_flash_message('not found language');
			return redirect()->route('common.admin.dashboard.error',400);
		}
		session()->put('locale',$code);
		
		return redirect($_SERVER['HTTP_REFERER']);
		return redirect()->back();
	}
    public function index(Request $request) {
 
        if ($request->input('sort_by') === 'all' || $request->input('sort_by') === 'title-ascending') {
            $listProduct = Products::with('product_type')->orderBy('name', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'title-descending') {
            $listProduct = Products::with('product_type')->orderBy('name', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'price-ascending') {
            $listProduct = Products::with('product_type')->orderBy('unit_price', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'price-descending') {
            $listProduct = Products::with('product_type')->orderBy('unit_price', 'desc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'created-ascending') {
            $listProduct = Products::with('product_type')->orderBy('created_at', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'created-descending') {
            $listProduct = Products::with('product_type')->orderBy('created_at', 'desc')->get()->toArray();
        } else {
            $listProduct = Products::with('product_type')->orderBy('unit_price', 'desc')->get()->toArray();
        }
//        echo "<pre>";
//        print_r($listProduct);
//        echo "</pre>";
//        exit;

        $category = ProductType::all();

        return view('product.list', [
            'bannerslide' => $this->banner->getBannerTop(1),
            'getPage' => $this->page->getPage("banh-trung-thu-kinh-do"),
            'listProduct' => $listProduct,
            'category' => $category,
            'getmeta' => $this->page->getPageMetaTag()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($cate_slug, $slug) {
        //
        $viewItem = Products::where('slug', $slug)->firstOrFail()->toArray();
        $listCate = ProductType::all();
        $relatedItem = Products::where('slug', '!=', $slug)->take(4)->get()->toArray();
        return view('product.view', [
            'viewItem' => $viewItem,
            'listCate' => $listCate,
            'relatedItem' => $relatedItem
        ]);
    }
	public static function getProductTrade($id) {
		// $lang = 1;
		// if(is_null(session('locale')))
		// {
			// if(App::getLocale() == '') $lang = 1;else $lang = App::getLocale();
		// }
		//$producttrade = Products::join('products_language','products_language.product_id','=','products.id')->select('*','products_language.slug as l_slug','products.unit as p_unit','products.id as pid')->where('products.id_trademark', $id)->where('products_language.language_id', $lang)->orderby('products.id', 'desc')->paginate(16);
		$producttrade = Products::with('currentLanguage')->where('products.id_trademark', $id)->orderby('products.id', 'desc')->paginate(16);
		merge_field($producttrade,'currentLanguage');
		return $producttrade;
	}
	public function showtrademark() {
        $listTrade = Trademark::with('currentLanguage')->get();
		merge_field($listTrade,'currentLanguage');
		// $lang = 1;
		// if(is_null(session('locale')))
		// {
			// if(App::getLocale() == '') $lang = 1;else $lang = App::getLocale();
		// }
		$producttrade = [];
		foreach($listTrade as $key=>$item){
			$producttrade[$key] = Products::with('currentLanguage')->where('products.id_trademark', $item['id'])->orderby('products.id', 'desc')->paginate(16);
			merge_field($producttrade[$key],'currentLanguage'); 
			
		}
        //echo '<pre>';print_r($producttrade[0]);exit;
        return view('product.product-grouped', [
            'listTrade' => $listTrade,
            'producttrade' => $producttrade
        ]);
    }
	public static function productAccessories($id) {
		$t=1;
		if(is_null(session('locale')))
		{
		  if(App::getLocale() == '') $t = 1;
		}else{
		  if(App::getLocale() == 'en') $t = 1;if(App::getLocale() == 'vi') $t = 2;
		}	
		$productAccessories =  ProductAccessories::where('product_id',$id)->where('language_id',$t)->get();
		
		return $productAccessories;
	}
	public static function productAddToQuote($id) {
		$addtoquote =  Products::with('currentLanguage')->where('id_group',$id)->get();
		merge_field($addtoquote,'currentLanguage');
		return $addtoquote;
	}
	public function productdetail($slug) {
        
        $listCate = ProductType::all();
        $viewItem = Products::join('products_language','products_language.product_id','=','products.id')->select('*','products_language.slug as l_slug','products.unit as p_unit','products.id as pid')->where('products_language.slug', $slug)->first();		      
		merge_field($viewItem,'currentLanguage');
		 
        $relatedItem = Products::with('currentLanguage')->where('id_type', $viewItem['id_type'])->take(24)->get();
		merge_field($relatedItem,'currentLanguage');
		 	
        return view('product.view', [
            'viewItem' => $viewItem,
            'listCate ' => $listCate,
            'relatedItem' => $relatedItem
        ]);
    }

    public function listCateOld($id, $slug) {
        $cate = ProductType::find($id);
        if(isset($cate) && $cate->level==5)
        $listCate = ProductType::with('currentLanguage')->where('parent_id', $cate->parent_id)->get();
        else
        $listCate = ProductType::with('currentLanguage')->where('parent_id', $id)->get();
        merge_field($listCate,'currentLanguage');
        return view('product.listcate', [
            'listCate' => $listCate
        ]);
    }

    public function listCate(Request $request, $slug) {
        $bannerslide = Banner::with('currentLanguage')->where('id_cate',1)->get();
        merge_field($bannerslide,'currentLanguage');
        if(!$request->segment(2)){
            // Show danh sach dich vu
            $getCate = Categorypost::join('categorypost_language','categorypost.id','=','categorypost_language.categorypost_id')
                ->where('categorypost.slug','=', $slug)
                ->select('categorypost.title', 'categorypost.slug','categorypost.parent_id','categorypost.image')
                ->first();
            // dd($getCate->toArray());
            if($getCate){
                function treeItem($parent_id = 0, &$submark = []) {
                    $query = App\Categorypost::getListCategoryParent($parent_id);
                    // dd($query);
                    if ($query) {
                        foreach ($query as $count => $catepost) {
                            $submark[] = $catepost->id;
                            treeItem($catepost->id, $submark);
                        }
                    }else{
                        $submark[] = $parent_id;
                    }
                    return $submark;
                }
                $listCatePost = treeItem($getCate['categorypost_id']);
                // dd($listCatePost);
                $listWork = $this->work->getList();
                $listProjectType = $this->project_type->getList();
                // dd($listProjectType);
                $work = "";
                $project = "";
                if($slug != 'tin-tuc' && $slug != 'khuyen-mai'){
                    $work = $request->input('work')?$request->input('work'):'all';
                    $project = $request->input('project')?$request->input('project'):'all';
                }

                
                $listPost = $this->post->getDuAn($listCatePost, $work, $project);
                // dd($listPost->toArray());
                $getBanner = Banner::join('banner_language','banner.id','=','banner_language.id_banner')
                        ->where('banner.id_cate',6)
                        ->where('banner_language.language_id', get_id_locale())
                        ->orderby('banner_language.created_at','desc')
                        ->select('banner_language.title','banner_language.label','banner_language.image','banner_language.link')
                        ->first();
                $industrial_style = $this->section->getSection(3);
                $tropical_style = $this->section->getSection(17);
                $retro_style = $this->section->getSection(25);
                // dd(get_id_locale());
                // dd($industrial_style);
                // merge_field($listPost,'currentLanguage');
                        // dd($listPost->toArray());
                return view('pages.news', [
                    'listPost' => $listPost,
                    'listProjectType' => $listProjectType,
                    'listWork' => $listWork,
                    'industrial_style' => $industrial_style,
                    'tropical_style' => $tropical_style,
                    'retro_style' => $retro_style,
                    // 'getListCatePost' => $getListCatePost,
                    // 'getPage' => $getCate->toArray(),
                    'getPage' => $getCate->toArray(),
                    'banner' => $getBanner,
                    'meta' => $slug
                ]);
            }

            // check product category slug 

            $cateProductSlug = $this->producttype->checkCateSlug($slug);
            // dd($cateProductSlug);
            if($cateProductSlug){
                // if($cateProductSlug->parent_id != 0){
                //     $getID = $this->producttype->getCate($cateProductSlug->id);
                // }else{
                //     $getID = $this->producttype->getMultiCate($cateProductSlug->id);
                // }
                // $listCate = [];
                // dd($getID);
                
                // foreach($getID as $value){
                //     $listCate[] = $value->id.',';
                // }
                function tsreeItem($parent_id = 0, &$submark = []) {
                    $submark[] = $parent_id;
                    $query = App\ProductType::productParentCategory($parent_id);
                    if ($query) {
                        foreach ($query as $count => $catepost) {
                            $submark[] = $catepost->id;
                            tsreeItem($catepost->id, $submark);
                        }
                    }
                    return $submark;
                }
                $listCate = tsreeItem($cateProductSlug->id);
                // dd($listCate);
                if($request->input('sort') === 'price-promotion'){
                    $listProductCate = $this->product->getProductList($listCate, 1, 0, 0, 'products.promotion_price', 'desc');
                }elseif($request->input('sort') === 'price-ascending'){
                    $listProductCate = $this->product->getProductList($listCate, 0, 0, 0, 'products.unit_price', 'asc');
                }elseif($request->input('sort') === 'price-descending'){
                    $listProductCate = $this->product->getProductList($listCate, 0, 0, 0, 'products.unit_price', 'desc');
                }elseif(is_numeric($request->input('max')) && is_numeric($request->input('min'))){
                    $listProductCate = $this->product->getProductList($listCate, 0, $request->input('max'), $request->input('min'), 'products.unit_price', 'desc');
                }elseif($request->input('material')){
                    $material = explode(',',$request->input('material'));
                    // dd($material);
                    $listProductCate = $this->product->getProductOption($listCate, $material);
                }elseif($request->input('color')){
                    $color = explode(',',$request->input('color'));
                    // dd($material);
                    $listProductCate = $this->product->getProductOption($listCate, $color);
                }else{
                    // $listProductCate = Cache::remember('products', 3600, function() use ($listCate){
                        $listProductCate = $this->product->getProductList($listCate, 0);
                        // return Products::getProductList(0);
                    // });
                }
                $firstBanner = $this->banner->getFirstBanner(7, 1, get_id_locale());
                // dd($firstBanner);
                $nextBanner = $this->banner->getNextBanner(7, 0, get_id_locale());
                $listProductHot = $this->product->getProductHot([
                    'products_language.name',
                    'products_language.slug',
                    'products.unit_price',
                    'products.promotion_price',
                    'products.image'
                ]);
                // dd($listProductCate);

                $listColor = $this->option_value->getOption(59);
                $material = $this->option_value->getOption(64);
                // dd($color);
                return view('product.listcate', [
                        'firstBanner' => $firstBanner,
                        'nextBanner' => $nextBanner,
                        'listProductHot' => $listProductHot,
                        'listProductCate' => $listProductCate,
                        'bannerslide' => $bannerslide,
                        'getmeta' => $this->page->getPageMetaTag($slug),
                        'cateProductSlug' => $cateProductSlug,
                        'listColor' => $listColor,
                        'listMaterial' => $material,
                        'slugProduct' => $slug,
                        'nameProductCate' => $cateProductSlug->name,
                        'meta' => 'product_category'
                ]);

            }
			$getProduct = Products::join('products_language','products.id','=','products_language.product_id')
                            ->join('type_products_relationships','products.id','=','type_products_relationships.product_id')
                            ->where('products_language.slug', $slug)
                            ->where('products_language.language_id', get_id_locale())
                            ->select('products_language.product_id', 'type_products_relationships.type_products_id as id_type')->first();
			// dd($getProduct->toArray());
            if(!$getProduct){
                $getpost = Post::join('post_language','post_language.post_id','=','post.id')
                        ->join('categorypost_language','categorypost_language.categorypost_id','=','post.id_cate')
                        ->where('post_language.language_id','=', get_id_locale())
                        ->where('post_language.slug', '=', $slug)
                        ->select('post_language.*','post_language.slug as l_slug','post.id as pid', 'post.id_cate as id_cate', 'post.galleries as galleries', 'post.galleries_thumb as galleries_thumb','categorypost_language.title as title_cate','categorypost_language.slug as slug_cate','post.image')
                        ->first();
                if(!$getpost){
                    return abort(404);
                }
                $getcate = CategorypostLanguage::where('categorypost_id', $getpost['id_cate'])
                    ->select('id','title','slug')
                    ->get();
                $getpostrelated = Post::join('post_language','post.id','=','post_language.post_id')
                        ->join('categorypost_language','post.id_cate','=','categorypost_language.categorypost_id')
                        ->where('post.id_cate','=',$getpost['id_cate'])
                        ->where('post_language.post_id','!=', $getpost['pid'])
                        ->where('post_language.language_id', get_id_locale())
                        ->orderby('post_language.created_at', 'desc')
                        ->select('post.id_cate as id_cate','post_language.title as title','post_language.created_at as created_at','categorypost_language.slug as cateslug','post.image as image','post_language.slug as slug','post_language.language_id as language_id')
                        ->distinct('post_language.post_id as id')
                        ->limit(4)
                        ->get()->toArray();
                return view('pages.servicedetail', [
                    'bannerslide' => $this->banner->getBannerTop(1),
                    'getpost' => $getpost,
                    'getpopup' => $this->banner->getBanner(3),
                    'getpostrelated' => $getpostrelated,
                    'cate_title' => $getcate[0]['title'],
                    'meta' => 'news_detail'
                ]);

            }
            //$product = Products::where('slug','=',$slug)->select('id', 'id_type')->first();
			
            //dd($product->toArray());

            /*if(!$product){
                return redirect()->to('/');
            }*/
			// echo $getProduct->id;
            // dd($getProduct->toArray());
             $viewProduct = Products::join('products_language','products_language.product_id','=','products.id')
                            ->with('product_type_relationships')
                            ->where('products_language.product_id', $getProduct['product_id'])
							->where('products_language.product_status', 1)
                            ->where('products_language.language_id','=',get_id_locale())
							->select(
                                'products_language.language_id',
                                'products_language.content',
                                'products_language.combo',
                                'products_language.product_gif',
                                'products.id',
                                'products.slug',
                                'products.description',
                                'products.galleries as galleries',
                                'products.promotion_price as promotion_price',
                                'products.unit_price as unit_price',
                                'products.sku as sku',
                                'products.name',
								'products.image as image'
                            )
							 ->first();
			if(!$viewProduct){
				return abort('404');
			}
            $sizeProduct = ProductOptionValue::where('product_id','=',$viewProduct['main_product_id'])->select('price','price_prefix')->get()->toArray();
            // dd($sizeProduct);
            // $array_combo = $viewProduct[(get_id_locale() - 1)]['combo'];
            $array_combo = explode(",",$viewProduct['combo']);
            // dd($array_combo);
			 /*$productDetail = Products::join('type_products', 'products.id_type', '=', 'type_products.id')
                                 ->join('products_language','products_language.product_id','=','products.id')
                                 ->select('products.*', 'type_products.name as namecate', 'type_products.slug as slugcate', 'products_language.specification')
                                 ->where('products.slug', $checkSlug[0])
                                 ->firstOrFail()
                                 ->toArray();*/

            $product_options = ProductOption::getProductOptions($getProduct->id);
            $productRelated = $this->product->getProductRelated($slug, $getProduct->id_type);
            $comboProduct = $this->products_language->getComboProduct($viewProduct['id'],$array_combo);
            // dd($comboProduct);
            $getMauKieng = $this->product->getProperties($getProduct->id, 5);
            $getMauKhung = $this->product->getProperties($getProduct['product_id'], 59);
            $getSize = $this->product->getProperties($getProduct['product_id'], 60);
            $policySale = $this->section->viewSection(19);
            // dd($policySale);
            // merge_field($getMauKhung,'currentLanguage');
            // dd($getSize);
            // print_r($getMauKhung);
            // dd($productRelated);
            return view('product.view',[
                'bannerslide' => $bannerslide,
                'getmeta' => $this->page->getPageMetaTag(),
                'productDetail' => $viewProduct,
                'productRelated' => $productRelated,
                'productOption' => $product_options,
                'getSize' => $getSize,
                'getMauKieng' => $getMauKieng,
                'getMauKhung' => $getMauKhung,
                'policySale' => $policySale,
                'sizeProduct' => $sizeProduct,
                'comboProduct' => $comboProduct,
                'meta' => 'product_view'
            ]);

            /// xu ly tiep phan san pham chi tiet


            // dd($request->segment(1));
        }


        exit;
        $checkSlug = explode('.',$slug);
        $slugProduct = end($checkSlug);
        
        $categoryPost = Categorypost::where('slug_vn','=',$slugProduct)
                        ->select('title_vn', 'slug_vn')
                        ->first()
                        ->toArray()
                        ;

        if($categoryPost){
            // dd($categoryPost);
            $listPost = Post::join('categorypost','categorypost.id','=','post.id_cate')
                        ->select('post.*','categorypost.slug_vn as cateslug','categorypost.title_vn as catetitle')
                        ->where('categorypost.slug_vn', $slug)
                        ->get();
            return view('pages.news', [
                'listPost' => $listPost,
                'getPage' => $categoryPost
            ]);
        }
        dd($slugProduct);
        
        // echo $slugProduct;
        // echo "<pre>";
        // print_r($checkSlug);
        //     exit;

        // show Product Detail
        if($slugProduct == 'html'){
            $product = Products::where('slug',$checkSlug[0])->select('id', 'id_type')->firstOrFail()->toArray();
            // $viewProduct = Products::join('products_language','products_language.product_id','=','products.id')->where('products.id',$id)->select('*','products.id as main_product_id')->firstOrFail()->toArray();
            // $productDetail = Products::join('type_products', 'products.id_type', '=', 'type_products.id')
            //                     ->join('products_language','products_language.product_id','=','products.id')
            //                     ->select('products.*', 'type_products.name as namecate', 'type_products.slug as slugcate', 'products_language.specification')
            //                     ->where('products.slug', $checkSlug[0])
            //                     ->firstOrFail()
            //                     ->toArray();
            $productDetail = $this->product->getProductDetail($checkSlug[0]);
            $product_options = ProductOption::getProductOptions($product['id']);
            $productRelated = $this->product->getProductRelated($slug, $product['id_type']);

            $getMauKieng = $this->product->getProperties($product['id'], 5);
            $getMauKhung = $this->product->getProperties($product['id'], 59);
            // dd($getMauKieng);

            return view('product.view',[
                'bannerslide' => $bannerslide,
                'getmeta' => $this->page->getPageMetaTag(),
                'productDetail' => $productDetail->toArray(),
                'productRelated' => $productRelated,
                'productOption' => $product_options,
                'getMauKieng' => $getMauKieng,
                'getMauKhung' => $getMauKhung
            ]);
        }


        // echo "<pre>";
        // print_r($slugProduct);
        // dd($slugProduct);
        // exit;
        // if($slugProduct){
        //     echo "dasda";
        // }
		// $cate = ProductType::find($id);
        $cate = ProductType::where('slug', $slugProduct)
                    ->select('id', 'parent_id')
                    ->first();
        // echo "<pre>";
        // print_r($cate[0]);
        // exit;
        // dd($cate);
        // if(!$cate){
        //     return abort(404);
        // }


		if($cate['parent_id'] <= 0 ){
            $listCate = ProductType::where('parent_id', $cate['id'])
                        ->select('id')
                        ->implode('id','-')
                        ->get()
                        ->toArray()
                        ;
        }else{
            $listCate = ProductType::where('id', $cate['id'])
                        ->select('id')
                        ->implode('id','-')
                        ->get()
                        ->toArray()
                        ;
        }

        $id_cates = [];
        foreach($listCate as $value){
            $id_cates[] = $value['id'].',';
        }
        // print_r($id_cates);
        // exit;

        if($request->input('f')){
            $filter_price = $request->input('f');
            switch ($filter_price) {
                case 'duoi-1-trieu':
                // dd($id_cates);
                    $listProductCate = Products::whereIn('id_type', $id_cates)
                            ->where('unit_price', '<', 1000000)
                            ->get()
                            ->toArray();
                            // dd($listProductCate);
                    break;
                case 'tu-1-trieu-5-trieu':
                    $listProductCate = Products::whereIn('id_type', $id_cates)
                            ->where('unit_price', '>=', 1000000)
                            ->where('unit_price', '<', 5000000)
                            ->get()
                            ->toArray();
                    break;
                case 'tren-5-trieu':
                    $listProductCate = Products::whereIn('id_type', $id_cates)
                            ->where('unit_price', '>', 5000000)
                            ->get()
                            ->toArray();
                    break;
                default:
                    $listProductCate = Products::whereIn('id_type', $id_cates)
                        ->orWhere('unit_price', '<', 1000000)
                        ->get()
                        ->toArray();
                    break;
            }
        }else{
            $listProductCate = Products::whereIn('id_type', $id_cates)
                        ->orWhere('unit_price', '<', 1000000)
                        ->get()
                        ->toArray();
        }
        // dd($listProductCate);
        
        // $listProductCate = Products::whereIn('id_type', $id_cates)
        //                     ->Where('unit_price', '<', 1000000)
        //                     ->get()
        //                     ->toArray();
        // $listProductCate = Products::whereIn('id_type', $id_cates)
        //                     ->get()
        //                     ->toArray();
        // $aa = array_values($listCate);
        // echo "<pre>";
        // print_r($listCate);
        
		return view('product.listcate', [
            'listProductCate' => $listProductCate,
            'bannerslide' => $bannerslide,
            'getmeta' => $this->page->getPageMetaTag(),
            'slugProduct' => $slugProduct
        ]);
        
	}
	public static function getlistCate($id) {
		$listCate = ProductType::with('currentLanguage')->where('parent_id', $id)->get();
		merge_field($listCate,'currentLanguage');
		return $listCate;
	}
	public static function getlistProductGroup($id) {
		$listpro = Products::with('currentLanguage')->where('id_group', $id)->get();
		merge_field($listpro,'currentLanguage');
		return $listpro;
	}
    public function showCate(Request $request, $slug) {
//        exit();
        $categoryProduct = ProductType::where('slug', $slug)->firstOrFail()->toArray();
//        echo "<pre>";
//        print_r($categoryProduct);
//        echo "</pre>";
//        exit;
        $listCate = ProductType::all();
        if ($request->input('sort_by') === 'all' || $request->input('sort_by') === 'title-ascending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('name', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'title-descending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('name', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'price-ascending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('unit_price', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'price-descending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('unit_price', 'desc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'created-ascending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('created_at', 'asc')->get()->toArray();
        } elseif ($request->input('sort_by') === 'created-descending') {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('created_at', 'desc')->get()->toArray();
        } else {
            $listProduct = Products::where('id_type', $categoryProduct['id'])->orderBy('created_at', 'desc')->get()->toArray();
        }

        return view('product.listcategory', [
            'listProduct' => $listProduct,
            'categoryProduct' => $categoryProduct,
            'listCate' => $listCate
        ]);
    }

    public function filterPrice(Request $request){
        if(!$request->isMethod('post') || !$request->isMethod("POST")){
            return redirect()->to('/');
        }
        if(is_numeric($request->input('price_min'))){
            $min = $request->input('price_min');
        }else{
            $min = 500000;
        }
        if(is_numeric($request->input('price_max'))){
            $max = $request->input('price_max');
        }else{
            $max = 2000000;
        }
        // dd($request->input('price_min').$request->input('price_max'));
        return redirect()->to($request->input('cateslug').'?min='.$min.'&max='.$max);
    }

    public function addToCart(Request $req, $id) {
        $product = Products::find($id);
        $products_language = ProductLanguage::where('product_id', $id)->where('language_id', get_id_locale())->first();
        if(!$product){
            return response()->json(['fail' => '<p>Sản phẩm không tồn tại!</p>']);
        }
        $oldCart = Session('cart') ? Session::get('cart') : null;
		//$oldCart = session()->get('cart'); 
		$oldCart = Session::get('cart'); 
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $cart->addProductGif($id);
        $req->session()->put('cart', $cart);
		$req->session()->save();
//		dd(Session('cart'));
		Session::flash('success','Thêm vào giỏ hàng thành công! ');
		Session::flash('notify_cart',1);
        return response()->json([
            'fail' => '<p>Lỗi! Vui lòng thử lại</p>',
            'result' => $cart->items,
            'cart' => $cart,
            'session_cart' => Session('cart')
        ]);
        return redirect()->back();
		 
    }
	public function addToCartDetail(Request $request, $id) {
		$data = $request->all();
        $request['id'] = $id;
        $product = Products::find($request['id']);//echo '<pre>';print_r($product);exit;
        //$oldCart = Session('cart') ? Session::get('cart') : null;
		$oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
		$product['price'] = $data['final_price'];
		$product['quantity'] = $data['quantity'];
        $cart->adddetail($product, $request['id']);
        //$request->session()->put('cart', $cart);
        session()->put('cart', $cart);
        return redirect()->back();
    }
    public function getDelItemCart($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();
    }
    
    public function updateItemCart($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateCart($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->back();
    }
    public function updateCartItem(Request $request) {
        $data = $request->all();
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        if (count($cart->items) > 0) {
            $cart->items[$data['id']]['quantity'] = $data['quantity'];
            $cart->items[$data['id']]['qty'] = $data['quantity'];
            $cart->items[$data['id']]['item']['quantity'] = $data['quantity'];
            $cart->items[$data['id']]['price'] = $cart->items[$data['id']]['item']['price'] * $data['quantity'];
            $total = 0;
            foreach($cart->items as $item){
                $total += $item['item']['price'] * $item['item']['quantity'];
            }			$cart->totalPrice = $total;
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        $unit = Unit::all()->toArray();
        return $cart->totalPrice;
    }
    public static function getUnit($unit_id) {
		$unit = Unit::where('id','=',$unit_id)->first()->toArray();
		//echo '<pre>';foreach($product_option_value as $i){print_r($i['name']);}exit;
		return $unit;
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

    public function search(Request $request){
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back();
        }
        if(!$request->input('keyword')){
            return redirect()->back();
        }
        $keyword = str_replace(' ', '+', $request->input('keyword'));
        // echo $keyword;
        // exit;
        // $request->input('keyword');
        return redirect('san-pham/tim-kiem/'.$keyword);
    }

    public function searchKeyword(Request $request){
        $keyword = str_replace('+', ' ', urldecode($request->segment(3)));
        // echo urldecode($keyword);
        //exit;
        if(!$keyword){
            return redirect()->route('home');
        }
        $result = $this->product->search($keyword);
        //$slugProduct = [];
		//dd($slugProduct);
        // dd($result);
        return view('product.search',[
            'result' => $result,
            'keyword' => $keyword,
            'slugProduct' => ''
        ]);
    }

}
