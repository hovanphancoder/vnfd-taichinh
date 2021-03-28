<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Products;
use App\ProductType;
use App\Trademark;
use App\OrderDetail;
use App\Option;
use App\OptionValue;
use App\ProductOption;
use App\ProductOptionValue;
use App\TypeProductsLanguage;
use App\ProductLanguage;
use App\ProductAccessories;
use App\OptionLanguage;
use App\OptionValueLanguage;
use App\TrademarkLanguage;
use App\Unit;
use App\ProductTypeRelationships;
use Session;
use DB;
use File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProductController extends Controller {

	protected $model;
    public function __construct(ProductType $producttype) {
        $this->model = new ProductType();
		$this->producttype = $producttype;
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        //
		$data['listProductType'] = ProductType::all();
		$categories = [];
		$producttype = new ProductType();
        $producttype->category_tree(0,'',$categories);
		$data['categories'] = $categories;
		$data['listTrademark'] = Trademark::all();
		$data['id_type'] = '';
		$data['price'] = '';
		$data['id_trademark'] = '';
		// $d = ProductTypeRelationships::join('products','products.id','=','type_products_relationships.product_id');
  //       $d = $d->join('type_products', 'type_products.id', '=', 'type_products_relationships.type_products_id');
        $d = Products::with('product_type_relationships');
		$get = $request->all();
		if(isset($get['keyword']) && $get['keyword'] != ''){
           $d = $d->where('products.name','like','%'.$get['keyword'].'%');
		   $data['keyword'] = $get['keyword'];		   
        }
		if(isset($get['id_type']) && $get['id_type'] != '' && $get['id_type'] > 0){
            $cate_ids = $this->treeItem($get['id_type']);
            $d = $d->join('type_products_relationships','products.id','=','type_products_relationships.product_id');
            $d = $d->whereIn('type_products_relationships.type_products_id',$cate_ids);
		    $data['id_type'] = $get['id_type'];
        }
		// if(isset($get['id_trademark']) && $get['id_trademark'] != ''){
            // $d = $d->with('trademark');
  //          $d = $d->where('id_trademark',$get['id_trademark']);
		//    $data['id_trademark'] = $get['id_trademark'];		   
  //       }
		if(isset($get['price']) && $get['price'] != ''){
           $d = $d->orderBy('products.unit_price',$get['price']);
		   $data['price'] = $get['price'];
        }
		
       $d->orderBy('products.created_at','desc');
       $d->select('products.*');
       // $d->groupBy('products.name');
       $data['listProduct'] =  $d->paginate(25);
       // $last_query = end($d);
       // dd($d->toSql());
		$this->model = new ProductType();
        return view('admin.product.list', $data);
    }

    function treeItem($parent_id = 0, &$submark = []) {
        $query = ProductType::getParent($parent_id);
        if ($query) {
            foreach ($query as $count => $catepost) {
                $submark[] = $catepost->id;
                self::treeItem($catepost->id, $submark);
            }
        }else{
            $submark[] = $parent_id;
        }
        return $submark;
    }
	
	public function search(Request $request) {
        //
		if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
        if(!$request->has('keyword')){
			return redirect()->route('listproduct');
		}
		#echo $request->input('keyword');exit;
		$listProductType = ProductType::all();
		$listProduct = Products::with('product_type')->with('trademark')->where('name', 'LIKE', '%'.$request->input('keyword').'%')->get()->toArray();
		return view('admin.product.list',[
			'listProduct' => $listProduct,
			'listProductType' => $listProductType,
			'keyword' => $request->input('keyword')
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
        $listProductType = ProductType::all();
        $listTrademark = Trademark::all();
        $unit = Unit::all();
		$categories=[];
		$producttype = new ProductType();
        $producttype->category_tree(0,'',$categories);
        $listProduct = ProductLanguage::orderby('name','desc')->select('id','name','language_id','product_id')->get();
        return view('admin.product.add', [
            'categories' => $categories,
            'unit' => $unit,
            'listProduct' => $listProduct,
            'listProductType' => $listProductType,
            'listTrademark' => $listTrademark
        ]);
    }

    public function doAdd(Request $request) {
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		// foreach(config('app.locales') as $key=>$code){
  //           $rules['language-'.$key.'-name']= 'required';
  //       }
        /*$rules['language-2-name']= 'required';
		$this->validate($request,$rules);*/
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        $arr_id_type = $request->input('id_type');
        // dd($relation->toArray());
        

        $input = array();

        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = "defaultimage.jpg";
        }
		
            $newGalleries = !empty($request->input('new_galleries')) ? json_decode($request->input('new_galleries')) : [];


            if ($request->hasFile('galleries')) {
                $total = count($request->file('galleries'));
                if ($total > 0) {
                    for ($i = 0; $i < $total; $i++) {
                        $file = $request->file('galleries')[$i];
                        $galleryImage = time() . "-" . $i . '-' . $file->getClientOriginalName();
                        $file->move(public_path('images/upload/product/'), $galleryImage);
                        $newGalleries[] = $galleryImage;
                    }
                }
            }
        $newGalleries = count($newGalleries) === 0 ? null : json_encode($newGalleries);
		
		$newcatalogs = !empty($request->input('new_catalogs')) ? json_decode($request->input('new_catalogs')) : [];

            if ($request->hasFile('catalogs')) {
                $total = count($request->file('catalogs'));
                if ($total > 0) {
                    for ($i = 0; $i < $total; $i++) {
                        $file = $request->file('catalogs')[$i];
                        $galleryfile = time() . "-" . $i . '-' . $file->getClientOriginalName();
                        $file->move(public_path('images/upload/product/files/'), $galleryfile);
                        $newcatalogs[] = $galleryfile;
                    }
                }
            }
        $newcatalogs = count($newcatalogs) === 0 ? null : json_encode($newcatalogs);
		
        $input["name"] = $request->input('language-1-name');
        $input["slug"] = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-name'));
        $input["description"] = $request->input('language-1-description');
        $input["content"] = $request->input('language-1-content');
        $input["unit_price"] = $request->input('unit_price');
        $input["promotion_price"] = $request->input('promotion_price');
        $input["unit"] = $request->input('unit');
        $input["sku"] = $request->input('sku');
        $input["galleries"] = $newGalleries;
        $input["catalogs"] = $newcatalogs;
        $input["feature"] = ($request->input('feature') == "on") ? 1 : 0;
        $input["neew"] = ($request->input('neew') == "on") ? 1 : 0;
        $input['hot'] = ($request->input('hot') == "on") ? 1 : 0;
        $input["id_type"] = 0;
        $input["id_group"] = $request->input('id_group');
        $input["id_trademark"] = $request->input('id_trademark');
        $input["date_price"] = $request->input('date_price');
        $input["created_at"] = date("Y-m-d H:i:s");
        $input["updated_at"] = date("Y-m-d H:i:s");
        $input["image"] = $image;
        $result = Products::create($input);

        if($arr_id_type){
            foreach($arr_id_type as $id_type){
                $data_cate_id['product_id'] =  $result['id'];
                $data_cate_id['type_products_id'] = $id_type;
                $data_cate_id['updated_at'] = date("Y-m-d H:i:s");
                $data_cate_id['created_at'] = date("Y-m-d H:i:s");
                $result_multi_cate = ProductTypeRelationships::create($data_cate_id);
                if(!$result_multi_cate){
                    return redirect()->back()->with(['status' => 'Error!']);
                }
            }
        }else{
            $data_cate_id['product_id'] = $result['id'];
            $data_cate_id['type_products_id'] = 0;
            $data_cate_id['updated_at'] = date("Y-m-d H:i:s");
            $data_cate_id['created_at'] = date("Y-m-d H:i:s");
            $result_multi_cate = ProductTypeRelationships::create($data_cate_id);
        }
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
//        exit;
        if ($result) { 
            Session::flash('status', 'Success!');
			//save table: category language, by newbie ana
			if($language){
				foreach($language as $lang_id=>$item){
                    $combo = "";
                    $product_gif = "";
                    if($request->input('language-'.$lang_id.'-combo')){
                        $combo = $request->input('language-'.$lang_id.'-combo');
                        $combo = json_encode($combo);
                        $combo = ltrim($combo,'[');
                        $combo = rtrim($combo,']');
                        $combo = str_replace('"', '', $combo);
                    }
                    if($request->input('language-'.$lang_id.'-product-gif')){
                        $product_gif = $request->input('language-'.$lang_id.'-product-gif');
                        $product_gif = json_encode($product_gif);
                        $product_gif = ltrim($product_gif,'[');
                        $product_gif = rtrim($product_gif,']');
                        $product_gif = str_replace('"', '', $product_gif);
                    }
					$item['language_id'] = $lang_id;
					$item['product_id'] = $result['id'];
					$item['slug'] = !empty($item['slug'])?str_slug($item['slug']):str_slug($item['name']);
                    $item['combo'] = $combo;
                    $item['product_gif'] = $product_gif;
					ProductLanguage::create($item);
				}
		   }
			//add product option , by newbie ana
			$input["product_option"] = $request->input('product_option');
			if(isset($input['product_option'])){
			foreach ($input['product_option'] as $product_option) {
				
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						//product_option
						$po['product_id'] = $result['id'];// id product vua tao 
						$po['option_id'] = $product_option['option_id'];
						$po['required'] = $product_option['required'];
						$addproduct_option = ProductOption::create($po);
						
						
						foreach ($product_option['product_option_value'] as $product_option_value) {
							
							//product_option_value
							$pov['product_option_id'] = $addproduct_option['id'];//id product_option vua tao 
							$pov['product_id'] = $result['id'];
							$pov['option_id'] = $product_option['option_id'];
							$pov['option_value_id'] = $product_option_value['option_value_id'];
							$pov['sku'] = $product_option_value['sku'];
							$pov['quantity'] = $product_option_value['quantity'];
							$pov['subtract'] = $product_option_value['subtract'];
							$pov['price'] = $product_option_value['price'];
							$pov['price_prefix'] = $product_option_value['price_prefix'];
							$pov['points'] = $product_option_value['points'];
							$pov['points_prefix'] = $product_option_value['points_prefix'];
							$pov['weight'] = $product_option_value['weight'];
							$pov['weight_prefix'] = $product_option_value['weight_prefix'];
							$addproduct_option_value = ProductOptionValue::create($pov);
						}
					}
				} else {
					
					//product_option type=file
					$po['product_id'] = $result['id'];// id product vua tao 
					$po['option_id'] = $product_option['option_id'];
					$po['value'] = $product_option['value'];
					$po['required'] = $product_option['required'];
					$addproduct_option = ProductOption::create($po);
				}
			}
			}
            return redirect('admin/product/view/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
        $viewItem = Products::with('product_type_relationships')->find($id);
        $accessories = ProductAccessories::where('product_id',$id)->where('language_id',1)->orderBy('id','desc')->get();
        $listProductType = ProductType::all();
        $listTrademark = Trademark::all();
		$unit = Unit::all();
		$product_options = ProductOption::getProductOptions($id);
		$option_values = array();

		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($option_values[$product_option['option_id']])) {
					$option_values[$product_option['option_id']] = $this->getOptionValues($product_option['option_id']);
				}
			}
		}
		$viewProduct = Products::join('products_language','products_language.product_id','=','products.id')->where('products.id',$id)->select('*','products.id as main_product_id','products_language.combo')->get();
        // dd($viewProduct->toArray());
		$categories=[];
		$producttype = new ProductType();
        $producttype->category_tree(0,'',$categories);
        $listProduct = ProductLanguage::orderby('name','desc')->where('product_id','!=',$viewProduct[0]['product_id'])->where('product_status', 1)->select('id','name','language_id','product_id','combo')->get();
        // dd($listProduct->toArray());
        return view('admin.product.view', [
            'id' => $id,
            'unit' => $unit,
            'viewItem' => $viewItem,
            'accessories' => $accessories,
            'viewProduct' => $viewProduct,
            'listTrademark' => $listTrademark,
            'listProductType' => $listProductType,
            'product_options' => $product_options,
            'categories' => $categories,
            'listProduct' => $listProduct,
            'option_values' => $option_values
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
        $viewItem = Products::find($id);
        if (!$viewItem) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		/*foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);*/
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        
        // add multi product category 
        $arr_id_type = $request->input('id_type');
        $relation = ProductTypeRelationships::where('product_id',$id)->delete();
        if(!$relation){
            redirect()->back()->with(['status', 'Error! Try again.']);
        }
        // dd($relation->toArray());
        if($arr_id_type){
            foreach($arr_id_type as $id_type){
                $data_cate_id['product_id'] = $id;
                $data_cate_id['type_products_id'] = $id_type;
                $data_cate_id['updated_at'] = date("Y-m-d H:i:s");
                $data_cate_id['created_at'] = date("Y-m-d H:i:s");
                $result_multi_cate = ProductTypeRelationships::create($data_cate_id);
                if(!$result_multi_cate){
                    return redirect()->back()->with(['status' => 'Error!']);
                }
            }
        }else{
            $data_cate_id['product_id'] = $id;
            $data_cate_id['type_products_id'] = 0;
            $data_cate_id['updated_at'] = date("Y-m-d H:i:s");
            $data_cate_id['created_at'] = date("Y-m-d H:i:s");
            $result_multi_cate = ProductTypeRelationships::create($data_cate_id);
        }
        
        // $rules = [
        //     'name_vn' => 'required|max:255',
        //     'description_vn' => 'required',
        //     'unit_price' => 'required'
        // ];
        // $message = [
        //     'name_vn.required' => 'Không được để trống',
        //     'name_vn.max' => 'Tên sản phẩm quá dài',
        //     'description_vn.max' => 'Không được để trống',
        //     'unit_price.required' => 'Không được để trống'
        // ];

       
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('old_image');
        }
		
		$currentGallery = [];
            if (!empty($viewItem->galleries)) {
                $currentGallery = json_decode($viewItem->galleries);
            }

            $newGalleries = !empty($request->input('new_galleries')) ? json_decode($request->input('new_galleries')) : [];

            $removedGalleries = array_diff($currentGallery, $newGalleries);


            // IF SOME IMAGES IN GALLERY ARE REMOVED
            if (count($removedGalleries) > 0) {
                foreach ($removedGalleries as $key => $value) {
                    File::delete(public_path('images/upload/product/' . $value));
                }
            }

            if ($request->hasFile('galleries')) {
                $total = count($request->file('galleries'));
                if ($total > 0) {
                    for ($i = 0; $i < $total; $i++) {
                        $file = $request->file('galleries')[$i];
                        $galleryImage = time() . "-" . $i . '-' . $file->getClientOriginalName();
                        $file->move(public_path('images/upload/product/'), $galleryImage);
                        $newGalleries[] = $galleryImage;
                    }
                }
            }
        $newGalleries = count($newGalleries) === 0 ? null : json_encode($newGalleries);
		
		$currentCatalogs = [];
            if (!empty($viewItem->catalogs)) {
                $currentCatalogs = json_decode($viewItem->catalogs);
            }

            $newCatalogs = !empty($request->input('new_catalogs')) ? json_decode($request->input('new_catalogs')) : [];

            $removedCatalogs = array_diff($currentCatalogs, $newCatalogs);


            // IF SOME IMAGES IN GALLERY ARE REMOVED
            if (count($removedCatalogs) > 0) {
                foreach ($removedCatalogs as $key => $value) {
                    File::delete(public_path('images/upload/product/' . $value));
                }
            }

            if ($request->hasFile('catalogs')) {
                $total = count($request->file('catalogs'));
                if ($total > 0) {
                    for ($i = 0; $i < $total; $i++) {
                        $file = $request->file('catalogs')[$i];
                        $galleryImage = time() . "-" . $i . '-' . $file->getClientOriginalName();
                        $file->move(public_path('images/upload/product/'), $galleryImage);
                        $newCatalogs[] = $galleryImage;
                    }
                }
            }
        $newCatalogs = count($newCatalogs) === 0 ? null : json_encode($newCatalogs);
			
        $viewItem->name = $request->input('language-1-name');
        $viewItem->slug = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-name'));//.'-'.$id;
        $viewItem->description = $request->input('language-1-description');
        $viewItem->content = $request->input('language-1-content');
        $viewItem->unit_price = $request->input('unit_price');
        $viewItem->product_status = $request->input('product_status');
        $viewItem->promotion_price = $request->input('promotion_price');
        $viewItem->unit = $request->input('unit');
        $viewItem->sku = $request->input('sku');
        $viewItem->galleries = $newGalleries;
        $viewItem->catalogs = $newCatalogs;
        $viewItem->feature = ($request->input('feature') == "on") ? 1 : 0;
        $viewItem->hot = ($request->input('hot') == "on") ? 1 : 0;
        $viewItem->neew = ($request->input('neew') == "on") ? 1 : 0;
        $viewItem->id_type = 0;
        $viewItem->id_group = $request->input('id_group');
        $viewItem->id_trademark = $request->input('id_trademark');
        $viewItem->date_price = $request->input('date_price');
        $viewItem->updated_at = date("Y-m-d H:i:s");
        $viewItem->image = $image;
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
			//update product option, by newbie ana
			$data = $request->all();
			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";exit;
			$this->editProductOption($id, $data);
			//save table: product language, xoá ghi lại 
			ProductLanguage::where('product_id',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
                    $combo = "";
                    $product_gif = "";
                    if($request->input('language-'.$lang_id.'-combo')){
                        $combo = $request->input('language-'.$lang_id.'-combo');
                        $combo = json_encode($combo);
                        $combo = ltrim($combo,'[');
                        $combo = rtrim($combo,']');
                        $combo = str_replace('"', '', $combo);
                    }
                    if($request->input('language-'.$lang_id.'-product-gif')){
                        $product_gif = $request->input('language-'.$lang_id.'-product-gif');
                        $product_gif = json_encode($product_gif);
                        $product_gif = ltrim($product_gif,'[');
                        $product_gif = rtrim($product_gif,']');
                        $product_gif = str_replace('"', '', $product_gif);
                    }
					$item['language_id'] = $lang_id;
					$item['product_id'] = $id;
                    $item['combo'] = $combo;
                    $item['product_gif'] = $product_gif;
                    $item['product_status'] = $request->input('product_status');
					//get slug, check id
					// $mang = explode('-', $item['slug']);
					// $ptend = array_pop($mang);
					// $mangmoi = explode($ptend, $item['slug']);
					// $item['slug'] = $mangmoi[0].$id;
					ProductLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function category() {
        //
        $listCategory = ProductType::orderBy('created_at', 'desc')->paginate(25);
		foreach($listCategory as $key=>$list){
			$findparent = ProductType::find($list['parent_id']);	
			$listCategory[$key]['parent_name'] = '';
			if($findparent)$listCategory[$key]['parent_name'] = $findparent->name;
		}

		return view('admin.product.listcategory')->with('listCategory',$listCategory);
    }

    public function viewCategory($id) {
        $viewCategory1 = ProductType::find($id);
        $viewCategory = ProductType::join('type_products_language','type_products_language.id_type','=','type_products.id')->where('type_products.id',$id)->select('*','type_products.id as type_products_id')->get();
		$listCategory = ProductType::orderBy('created_at', 'desc')->get()->toArray();
       
		$categories=[];
		$producttype = new ProductType();
        $producttype->category_tree(0,'',$categories);

		return view('admin.product.viewcategory', [
            'id' => $id,
            'viewCategory1' => $viewCategory1,
            'categories' => $categories,
            'listCategory' => $listCategory,
            'viewCategory' => $viewCategory
        ]);
    }

    public function editCategory(Request $request, $id) {
        $viewItem = ProductType::find($id);
        // echo $request->input('feature');
        // dd($viewItem->toArray());
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		/*foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);*/
		$language=[];
        // dd($request->all());
        foreach($request->all() as $k => $v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                // dd($str);
                $language[$str[1]][$str[2]]= $v;
            }
        }
        // dd($language);
        if ($request->hasFile('image')) { 
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('old_image');
        }
		$viewItem->level = ProductType::getLevelFromCateID($request->input('parent_id'));
        $viewItem->name = $request->input('language-1-name');
        $viewItem->parent_id = $request->input('parent_id');
        $viewItem->slug = empty($request->input('language-1-slug'))?str_slug($request->input('language-1-name')):str_slug($request->input('language-1-slug'));
        $viewItem->description = $request->input('language-1-description');
        $viewItem->feature = is_numeric($request->input('feature'));
        $viewItem->updated_at = date("Y-m-d H:i:s");
        $viewItem->image = $image;
        // dd($viewItem->toArray());
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
			//save table: category language, xoá ghi lại 
			TypeProductsLanguage::where('id_type',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
                    $item['id_type'] = $id;
					$item['slug'] = !empty($item['slug'])?str_slug($item['slug']):str_slug($item['name']);
					//get slug, check id
					// $mang = explode('-', $item['slug']);
					// $ptend = array_pop($mang);
					// $mangmoi = explode($ptend, $item['slug']);
					// $item['slug'] = $mangmoi[0].$id;
					TypeProductsLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect()->back();
    }

    public function addCategory() {
		$listCategory = ProductType::orderBy('created_at', 'desc')->get()->toArray();
        $categories=[];
		$producttype = new ProductType();
        $producttype->category_tree(0,'',$categories);
        return view('admin.product.addcategory',[
            'aa' => 'a',
			'listCategory' => $listCategory,
			'categories' => $categories
        ]);
    }
    public function doAddCategory(Request $request){
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		/*foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);*/
		$language=[];
        // dd($request->all());
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
		
        $input = array();
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = "defaultimage.jpg";
        }
		$input["level"] = ProductType::getLevelFromCateID($request->input('parent_id'));
        $input["name"] = $request->input('language-1-name');
        $input["slug"] = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-name'));
		$input["description"] = $request->input('language-1-description');
        $input["feature"] = ($request->input('feature') == 'on')?1:0;
        $input["parent_id"] = $request->input('parent_id');        
        $input["created_at"] = date("Y-m-d H:i:s");
        $input["image"] = $image;
        $result = ProductType::create($input);
        // dd($language);
        if ($result) {
            Session::flash('status', 'Success!');
			// $pt = ProductType::find($result['id']);
			// $pt['slug'] = $pt['slug'].'-'.$result['id'];
			// $pt->save();
			//save table: category language
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['id_type'] = $result['id'];
					$item['slug'] = !empty($item['slug'])?str_slug($item['slug']):str_slug($item['name']);
					TypeProductsLanguage::create($item);
				}
		   }
		   
            return redirect('admin/product/category/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
    }

	public function group() {
        //
        $listCategory = ProductType::where('level',5)->orderBy('created_at', 'desc')->paginate(25);
		foreach($listCategory as $key=>$list){
			$findparent = ProductType::find($list['parent_id']);	
			$listCategory[$key]['parent_name'] = '';
			if($findparent)$listCategory[$key]['parent_name'] = $findparent->name;
		}

		return view('admin.product.listgroup')->with('listCategory',$listCategory);
    }
	public function viewGroup($id) {
        $viewCategory1 = ProductType::find($id);
        $viewCategory = ProductType::join('type_products_language','type_products_language.id_type','=','type_products.id')->where('type_products.id',$id)->select('*','type_products.id as type_products_id')->get();
		$listCategory = ProductType::orderBy('created_at', 'desc')->get()->toArray();
       
		$groups = ProductType::where('level',4)->get()->toArray();

		return view('admin.product.viewgroup', [
            'id' => $id,
            'viewCategory1' => $viewCategory1,
            'groups' => $groups,
            'listCategory' => $listCategory,
            'viewCategory' => $viewCategory
        ]);
    }
	public function editGroup(Request $request, $id) {
        $viewItem = ProductType::find($id);
        
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        if ($request->hasFile('image')) { 
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('old_image');
        }
		$viewItem->level = ProductType::getLevelFromCateID($request->input('parent_id'));
        $viewItem->name = $request->input('language-1-name');
        $viewItem->parent_id = $request->input('parent_id');
        $viewItem->slug = str_slug($request->input('language-1-name')).'-'.$id;
        $viewItem->description = $request->input('language-1-description');
        $viewItem->updated_at = date("Y-m-d H:i:s");
        $viewItem->image = $image;
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
			//save table: category language, xoá ghi lại 
			TypeProductsLanguage::where('id_type',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['id_type'] = $id;
					TypeProductsLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect()->back();
    }

    public function addGroup() {
		$listCategory = ProductType::orderBy('created_at', 'desc')->get()->toArray();
        
		$groups = ProductType::where('level',4)->get()->toArray(); 
        return view('admin.product.addgroup',[
            'aa' => 'a',
			'listCategory' => $listCategory,
			'groups' => $groups
        ]);
    }
    public function doAddGroup(Request $request){
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
		
		
        $input = array();
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = "defaultimage.jpg";
        }
		$input["level"] = ProductType::getLevelFromCateID($request->input('parent_id'));
        $input["name"] = $request->input('language-1-name');
        $input["slug"] = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-name'));
		$input["description"] = $request->input('language-1-description');
		
        $input["parent_id"] = $request->input('parent_id');        
        $input["created_at"] = date("Y-m-d H:i:s");
        $input["image"] = $image;
        $result = ProductType::create($input);

        if ($result) {
            Session::flash('status', 'Success!');
			$pt = ProductType::find($result['id']);
			$pt['slug'] = $pt['slug'].'-'.$result['id'];
			$pt->save();
			//save table: category language
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['id_type'] = $result['id'];
					//$item['slug'] = !empty($item['slug'])?$item['slug']:str_slug($item['name']).'-'.$result['id'];
					TypeProductsLanguage::create($item);
				}
		   }
		   
            return redirect('admin/product/group/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        $viewItem = Products::find($id);
		//kiem tra id product co ton tai trong order
		$check = OrderDetail::where('product_id',$id)->get();
		
		if(count($check)==0){
			$result = $viewItem->delete();
            ProductTypeRelationships::where('product_id',$id)->delete();
        }
        if (isset($result)) {
            Session::flash('status', 'Success!');
			ProductLanguage::where('product_id',$id)->delete();//del product language
        } else {
            Session::flash('status', 'Failed! This item maybe using');
        }
        
        return redirect()->back();
    }
    public function destroyProductAll(Request $request){
        // no process empty listid
        foreach($request->listid as $productID){
            $resultProduct = Products::whereId($productID)->delete();
            ProductLanguage::where('product_id',$productID)->delete();
            if(!$resultProduct){
                return response()->json(['result', 'Error! Try again.']);
            }
        }
        Session::flash('status', 'Success!');
        return response()->json(['result' => 'Success.']);
    }
    
    public function destroyCategory($id) {
        //
        $viewItem = ProductType::find($id);
		$check = Products::where('id_type',$id)->get();
		
		if(count($check)==0)
			$result = $viewItem->delete();
        if (isset($result)) {
            Session::flash('status', 'Success!');
			TypeProductsLanguage::where('id_type',$id)->delete();
        } else {
            Session::flash('status', 'Failed! This item maybe using!');
        }
        return redirect()->back();
    }
    public function destroyProductCategoryAll(Request $request){
        // no process empty listid
        foreach($request->listid as $cateID){
            $resultProduct = ProductType::whereId($cateID)->delete();
            TypeProductsLanguage::where('id_type', $cateID)->delete();
            if(!$resultProduct){
                return response()->json(['result', 'Error! Try again.']);
            }
        }
        Session::flash('status', 'Success!');
        return response()->json(['result' => 'Success.']);
    }
	public function destroyGroup($id) {
        //
        $viewItem = ProductType::find($id);
		$check = Products::where('id_type',$id)->get();
		
		if(count($check)==0)
			$result = $viewItem->delete();
        if (isset($result)) {
            Session::flash('status', 'Success!');
			TypeProductsLanguage::where('id_type',$id)->delete();
        } else {
            Session::flash('status', 'Failed! This item maybe using!');
        }
        return redirect()->back();
    }
	public function trademark() {
        //
        $listTrademark = Trademark::orderBy('created_at', 'desc')->get()->toArray();


		return view('admin.product.listtrademark')->with('listTrademark',$listTrademark);
    }
	public function addTrademark() {
		
        return view('admin.product.addtrademark',[
            'aa' => 'a'
        ]);
    }
    public function doAddTrademark(Request $request){
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        $input = array();
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = "defaultimage.jpg";
        }
        $input["name"] = $request->input('language-1-name');
        $input["description"] = $request->input('language-1-description');
        $input["created_at"] = date("Y-m-d H:i:s");
        $input["image"] = $image;
        $result = Trademark::create($input);
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
//        exit;
        if ($result) {
            Session::flash('status', 'Success!');
			//save table: trademark language
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['trademark_id'] = $result['id'];
					TrademarkLanguage::create($item);
				}
		   }
            return redirect('admin/product/trademark/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
    }
	public function viewTrademark($id) {
        $viewTrademark = Trademark::find($id);
		$listTrademark = Trademark::orderBy('created_at', 'desc')->get()->toArray();
		$viewTrademarkLanguage = Trademark::join('trademark_language','trademark_language.trademark_id','=','trademark.id')->where('trademark.id',$id)->select('*','trademark.id as main_trademark_id')->get();
        return view('admin.product.viewtrademark', [
            'id' => $id,
            'listTrademark' => $listTrademark,
            'viewTrademarkLanguage' => $viewTrademarkLanguage,
            'viewTrademark' => $viewTrademark
        ]);
    }

    public function editTrademark(Request $request, $id) {
        $viewItem = Trademark::find($id);
        
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
		
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/product';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('old_image');
        }
        $viewItem->name = $request->input('name');
        $viewItem->description = $request->input('description');
        $viewItem->updated_at = date("Y-m-d H:i:s");
        $viewItem->image = $image;
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
			//save table: trademark language, xoá item cũ ghi lại
			TrademarkLanguage::where('trademark_id',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['trademark_id'] = $id;
					TrademarkLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect()->back();
    }
	public function destroyTrademark($id) {
        
        $viewItem = Trademark::find($id);
		$check = Products::where('id_trademark',$id)->get();
		
		if(count($check)==0)
			$result = $viewItem->delete(); 
        if (isset($result)) {
            Session::flash('status', 'Success!');
			TrademarkLanguage::where('trademark_id',$id)->delete();
        } else {
            Session::flash('status', 'Failed! This item maybe using');
        }
        return redirect()->back();
    }
	public function getaccessories(Request $request) {
		$json = array();
		$get=$request->all();
		if(isset($get['id_accessories'])){
			$json = ProductAccessories::where('id',$get['id_accessories'])->orwhere('id',$get['id_accessories']+1)->get()->toArray();
			
		}
		return $json;
	}
	public function getgroup(Request $request) {
		$json = array();
		$get=$request->all();
		if(isset($get['id'])){
			$json = ProductType::where('parent_id',$get['id'])->get()->toArray();		
		}
		return $json;
	}
	public function addaccessories(Request $request) {
		$json = array();
		$get=$request->all();
		if(isset($get['id'])){
			//bo sung language
			// foreach(config('app.locales') as $key=>$code){
				// $rules['language-'.$key.'-description']= 'required';
			// }
			$rules['language-1-description']= 'required';
			$this->validate($request,$rules);
			$language=[];
			foreach($request->all() as $k=>$v){
				if(strpos($k,'language')!==false){
					$str=explode('-', $k);
					$language[$str[1]][$str[2]]=$v;
				}
			}
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['product_id'] = $get['id'];
					ProductAccessories::create($item);
				}
		   }
		   $json = ProductAccessories::where('product_id',$get['id'])->where('language_id',1)->orderBy('id','desc')->get()->toArray();
		}
		return $json;
	}
	public function editaccessories(Request $request) {
		$json = array();
		$get=$request->all();
		if(isset($get['id'])){
		   $view1 = ProductAccessories::find($get['id']);
		   $view1->description = $get['des1'];
		   $view1->pn = $get['pn1'];
		   $view1->save();
		   $view2 = ProductAccessories::find($get['id']+1);
		   $view2->description = $get['des2'];
		   $view2->pn = $get['pn2'];
		   $view2->save();
		   $json = ProductAccessories::where('product_id',$get['idproduct'])->where('language_id',1)->orderBy('id','desc')->get()->toArray();
		}
		return $json;
	}
	public function deleteaccessories(Request $request) {
		$json = array();
		$get=$request->all();
		if(isset($get['id'])){
		   $view1 = ProductAccessories::find($get['id']);
		   $view1->delete();
		   $view2 = ProductAccessories::find($get['id']+1);
		   $view2->delete();
		   $json = ProductAccessories::where('product_id',$get['idproduct'])->where('language_id',1)->orderBy('id','desc')->get()->toArray();
		}
		return $json;
	}
	public function optionautocomplete(Request $request) {
		$json = array();
		$get=$request->all();
		if (isset($get['filter_name'])) {


			$options = Option::all();
			if (!empty($get['filter_name'])) {
				$options = Option::where('name',$get['filter_name'])->get();
			}

			foreach ($options as $option) {
				$option_value_data = array();
				
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_values = OptionValue::where('option_id',$option['id'])->get();
					$destinationPath = public_path() . '/images/upload/product/';
					foreach ($option_values as $option_value) {
						if (is_file($destinationPath . $option_value['image'])) {
							$image = $option_value['image'];
						} else {
							$image = "default.png";
						}

						$option_value_data[] = array(
							'option_value_id' => $option_value['id'],
							'name'            => strip_tags(html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8')),
							'image'           => $image
						);
					}
					
					$sort_order = array();

					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $option_value_data);
				}

				$type = '';

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
					$type = 'Choose';
				}

				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = 'Input';
				}

				if ($option['type'] == 'file') {
					$type = 'File';
				}

				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = 'Date';
				}

				$json[] = array(
					'id'    => $option['id'],
					'name'         => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		//return json_encode($json);
		return $json;
	}
	
	// public function getProductOptions_du($product_id){
		// $product_option_data = array();
		
		// $product_option_query = ProductOption::select('*','product_option.id as product_option_id')->join('option','option.id','=','product_option.option_id')->where('product_id',$product_id)->get();
		
		// foreach ($product_option_query as $product_option) {
			// $product_option_value_data = array();
			
			// $product_option_value_query =ProductOptionValue::join('option_value','option_value.id','=','product_option_value.option_value_id')->where('product_option_value.product_option_id','=',$product_option['product_option_id'])->get();
		
			// foreach ($product_option_value_query as $product_option_value) {
				// $product_option_value_data[] = array(
					// 'product_option_value_id' => $product_option_value['product_option_value_id'],
					// 'option_value_id'         => $product_option_value['option_value_id'],
					// 'sku'                => $product_option_value['sku'],
					// 'quantity'                => $product_option_value['quantity'],
					// 'subtract'                => $product_option_value['subtract'],
					// 'price'                   => $product_option_value['price'],
					// 'price_prefix'            => $product_option_value['price_prefix'],
					// 'points'                  => $product_option_value['points'],
					// 'points_prefix'           => $product_option_value['points_prefix'],
					// 'weight'                  => $product_option_value['weight'],
					// 'weight_prefix'           => $product_option_value['weight_prefix']
				// );
			// }

			// $product_option_data[] = array(
				// 'product_option_id'    => $product_option['product_option_id'],
				// 'product_option_value' => $product_option_value_data,
				// 'option_id'            => $product_option['option_id'],
				// 'name'                 => $product_option['name'],
				// 'type'                 => $product_option['type'],
				// 'value'                => $product_option['value'],
				// 'required'             => $product_option['required']
			// );
		// }
			// // echo "<pre>";
			// // print_r($product_option_data);
			// // echo "</pre>";exit;
		// return $product_option_data;
	// }
	public function getOptionValues($option_id) {
		$option_value_data = array();
		$option_value_query = OptionValue::where('option_id',$option_id)->get();		

		foreach ($option_value_query as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}
			// echo "<pre>";
			// print_r($option_value_data);
			// echo "</pre>";exit;
		return $option_value_data;
	}
	public function editProductOption($product_id, $data) {
		
		$viewItem = ProductOption::where('product_id',$product_id)->delete();
		
		$viewItem = ProductOptionValue::where('product_id',$product_id)->delete();	 
			
		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						
						$po['product_id'] = $product_id; 
						$po['option_id'] = $product_option['option_id'];
						$po['required'] = $product_option['required'];
						$addproduct_option = ProductOption::create($po);
						

						foreach ($product_option['product_option_value'] as $product_option_value) {
							
							//product_option_value
							$pov['product_option_id'] = $addproduct_option['id'];//id product_option vua tao 
							$pov['product_id'] = $product_id;
							$pov['option_id'] = $product_option['option_id'];
							$pov['option_value_id'] = $product_option_value['option_value_id'];
							$pov['sku'] = $product_option_value['sku'];
							$pov['quantity'] = $product_option_value['quantity'];
							$pov['subtract'] = $product_option_value['subtract'];
							$pov['price'] = $product_option_value['price'];
							$pov['price_prefix'] = $product_option_value['price_prefix'];
							$pov['points'] = $product_option_value['points'];
							$pov['points_prefix'] = $product_option_value['points_prefix'];
							$pov['weight'] = $product_option_value['weight'];
							$pov['weight_prefix'] = $product_option_value['weight_prefix'];
							$addproduct_option_value = ProductOptionValue::create($pov);
						}
					}
				} else {
					
					//product_option type=file
					$po['product_id'] = $product_id;// id product_option vua tao 
					$po['option_id'] = $product_option['option_id'];
					$po['value'] = $product_option['value'];
					$po['required'] = $product_option['required'];
					$addproduct_option = ProductOption::create($po);
				}
			}
		}		

	}

    public function export(){
        ob_end_clean();
        ob_start();
		$productList = Products::join('products_language','products_language.product_id','=','products.id')
		->where('products_language.language_id','=',get_id_locale())
		->select('products_language.*','products.id as main_product_id','products_language.combo','products.unit_price','products.promotion_price','products.image')
		->get()
		->toArray();
		//dd($productList);
        Excel::create('Product', function($excel) use ($productList) {

			$excel->sheet('list', function($sheet) use ($productList) {

				$sheet->row(1, array(
					 'id', 'title', 'description', 'link','tình trạng','giá','giá ưu đãi','còn hàng','liên kết hình ảnh','gtin','mpn','nhãn hiệu','danh mục'
				));
				foreach($productList as $keyProduct => $product){
					$sheet->row(($keyProduct + 2), array(
						$product['main_product_id'],
						$product['name'],
						strip_tags(html_entity_decode($product['description'],ENT_QUOTES, "UTF-8")),
						url($product['slug']),
						'new',
						$product['unit_price'],
						$product['promotion_price'],
						'in stock',
						url('images/upload/product/'.$product['image']),
						'1',
						'1',
						'NHÀ TUI decor',
						'2222'
					));
				}

			});

		})->export('xls');
    }
	public function exportCategory($id_type){
        ob_end_clean();
        ob_start();

		//$productList = $this->producttype->productList($id_type);
		$productList = Products::with('product_type_relationships')
						->where('products.product_status', 1)
						->select('products.*')
						->orderBy('created_at','asc')
						->get();
		//dd($productList->toArray());
		$category_name = "";
        Excel::create('Product', function($excel) use ($productList, $category_name) {

			$excel->sheet('list', function($sheet) use ($productList, $category_name) {

				$sheet->row(1, array(
					 'id', 'title', 'description', 'link','tình trạng','giá','giá ưu đãi','còn hàng','liên kết hình ảnh','gtin','mpn','nhãn hiệu','danh mục'
				));
				foreach($productList as $keyProduct => $product){
					$category_name = "";
					foreach($product->product_type_relationships as $item_relation){
						$category = ProductType::getCate($item_relation->type_products_id);
						if(is_object($category)){
							$category_name .= $category->name.', ';
						}else{
							$category_name = "Chưa xác định";
						}
					};
					$sheet->row(($keyProduct + 2), array(
						$product->id,
						$product->name,
						strip_tags(html_entity_decode($product->description,ENT_QUOTES, "UTF-8")),
						url($product->slug),
						'new',
						$product->unit_price,
						$product->promotion_price,
						'in stock',
						url('images/upload/product/'.$product->image),
						'1',
						'1',
						'NHÀ TUI decor',
						$category_name
					));
				}

			});

		})->export('xls');
    }

    public function postExportExcel(CustomerExcelExport $export,CustomerInterface $customer){
        return $export->sheet('sheetName', function($sheet) use($customer)
        {
            $customers = UserModel::whereHas('roles', function($query) {
                $query->where('id',9);
            })->where('is_customer', 1)->orderBy('id', 'asc')->get();
            dd($customers);
            $result = array();
            foreach($customers as $row) {
                $result[] = array(
                    trans('admin_user.add_user_name') => $row->name,
                    trans('admin_user.add_user_id_card') => $row->id_card,
                    trans('admin_user.add_user_address') => $row->address,
                    trans('admin_user.add_user_phone') => $row->phone,
                    trans('admin_customer.total_contract_number') => count($row->contracts),
                    trans('admin_customer.contract_number') => ''
                );
                if(count($row->contracts) > 0) {
                    foreach($row->contracts as $contract) {
                        $result[] = array(
                            trans('admin_user.add_user_name') => '',
                            trans('admin_user.add_user_id_card') => '',
                            trans('admin_user.add_user_address') => '',
                            trans('admin_user.add_user_phone') => '',
                            trans('admin_customer.total_contract_number') => '',
                            trans('admin_customer.contract_number') => $contract['contract_number']
                        );
                    }
                }
            }

            $sheet->fromModel($result);
        })->export('xlsx');
    }
}
