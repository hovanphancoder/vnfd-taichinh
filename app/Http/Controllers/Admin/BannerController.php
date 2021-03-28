<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use App\BannerLanguage;
use Session;
use Illuminate\Support\Facades\Validator;

class BannerController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Banner $banner) {
        $this->banner = $banner;
        $this->defaultimage = "defaultimage.jpg";
    }

    public function index() {
        //
        return view('admin/banner/list', [
            'listbanner' => $this->getAdminListBanner(),
            'viewbanner' => $this->viewBanner(1)
        ]);
    }

    public function add() {
        //
        return view('admin/banner/add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request) {
        //
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/banner/list");
        }
        //bo sung language
        foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-link']= 'required';
        }
        //$this->validate($request,$rules);
        $language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        

        if ($request->hasFile('language-1-image')) {
            $image1 = time() . "-" . $request->file('language-1-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/bannerslides';
            $request->file('language-1-image')->move($destinationPath, $image1);
        } else {
            $image1 = $this->defaultimage;
        }
        if ($request->hasFile('language-2-image')) {
            $image2 = time() . "-" . $request->file('language-2-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/bannerslides';
            $request->file('language-2-image')->move($destinationPath, $image2);
        } else {
            $image2 = $this->defaultimage;
        }
        
        $input["id_cate"] = $request->input('language-1-id_cate');
        $input["title"] = $request->input('language-1-title');
        $input["label"] = $request->input('language-1-label');
        $input["description"] = $request->input('language-1-description');
        $input["link"] = $request->input('language-1-link');
        $input['feature'] = ($request->input('language-1-feature') == 'on')?1:0;
        $input["created_at"] = date("Y-m-d H:i:s");
        $input["image"] = $image1;
        $result = Banner::create($input);
        if ($result) {
            Session::flash('status', 'Success!');
            //save table: category language
            if($language){
                foreach($language as $lang_id=>$item){
                    $item['language_id'] = $lang_id;
                    $item['id_banner'] = $result['id'];
                    if($lang_id == 1) $image = $image1;
                    if($lang_id == 2) $image = $image2;
                    $item['image'] = $image;
                    BannerLanguage::create($item);
                }
           }
            Session::flash('status', 'Add banner success!');
            return redirect('admin/banner/view/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
        //  lay danh sach id
        // kiem tra id co ton tai trong table post

        $item = Banner::find($id);
        if(!$item){
            Session::flash('result','Banner is not exist.');
            return redirect()->back();
        }
        $viewbann = Banner::join('banner_language','banner_language.id_banner','=','banner.id')->where('banner.id',$id)->select('*','banner.id as banner_id')->get()->toArray();
        //print_r($viewbann);exit;
        return view('admin/banner/view', [
            'viewbanner' => $this->banner->getViewSlide($id),
            'viewbann' => $viewbann
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edits(Request $request, $id) {
        //
//        echo $id; exit;
//        echo session('locale');exit;
//        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
//            Session::flash('status', 'Error!');
//            return redirect("admin/banner/list");
//        }
//        if (session('locale') == "en") {
//            $rules = [
//                'title_en' => 'required|max:255',
//                'label_en' => 'required|max:255',
//                'link_en' => 'required|max:255',
//            ];
//            $title = $request->input('title_en');
//            $label = $request->input('label_en');
//            $link = $request->input('link_en');
//        } else {
//            $rules = [
//                'title_vn' => 'required|max:255',
//                'label_vn' => 'required|max:255',
//                'link_vn' => 'required|max:255',
//            ];
//            $title = $request->input('title_vn');
//            $label = $request->input('label_vn');
//            $link = $request->input('link_vn');
//        }
////        $validator = Validator::make($request->all(), $rules);
////        if ($validator->fails()) {
////            return redirect()->back()->withErrors($validator->errors());
////        }
//        if ($request->hasFile('image')) {
//            $image = time() . "-" . $request->file('image')->getClientOriginalName();
//            $destinationPath = public_path() . '\images\upload\bannerslides';
//            $request->file('image')->move($destinationPath, $image);
//        } else {
//            $image = $request->input('url');
//        }
//
//        $updated_at = date("Y-m-d H:i:s");
//
//
//        $this->banner->updateBanner(session('locale'), $id, $title, $label, $request->input('id_cate'), $link, $image, $updated_at);
//
//        Session::flash('status', 'Cập nhật banner thành công.');
//        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/banner/list");
        }
        // dd($request->input('id_cate'));
        //bo sung language
        // foreach(config('app.locales') as $key=>$code){
            // $rules['language-'.$key.'-link']= 'required';
        // }
        //$this->validate($request,$rules);
        $language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
 
        if ($request->hasFile('language-1-image')) {
            $image1 = time() . "-" . $request->file('language-1-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/bannerslides';
            $request->file('language-1-image')->move($destinationPath, $image1);
        } else {
            $image1 = $request->input('language-1-url');
        }
        if ($request->hasFile('language-2-image')) {
            $image2 = time() . "-" . $request->file('language-2-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/bannerslides';
            $request->file('language-2-image')->move($destinationPath, $image2);
        } else {
            $image2 = $request->input('language-2-url');
        }
        $viewItem = Banner::find($id);
        $viewItem->title = $request->input('language-1-title');
        $viewItem->label = $request->input('language-1-label');
        $viewItem->description = $request->input('language-1-description');
        $viewItem->link = $request->input('language-1-link');
        $viewItem->id_cate = $request->input('language-1-id_cate');
        $viewItem->feature = ($request->input('language-1-feature') == 'on')?1:0;
        $viewItem->image = $image1;
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
            //save table: category language
            if($language){
                BannerLanguage::where('id_banner',$id)->delete();
                foreach($language as $lang_id=>$item){
                    $item['language_id'] = $lang_id;
                    $item['id_banner'] = $id;

                    if($lang_id == 1) $image = $image1;
                    if($lang_id == 2) $image = $image2;
                    $item['image'] = $image;
                    BannerLanguage::create($item);
                }
           }
            Session::flash('status', 'Update banner success!');
            return redirect('admin/banner/view/' . $id);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }

        Session::flash('status', 'Cập nhật banner thành công.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        //  lay danh sach id

        $item = Banner::find($id);
        if(!$item){
            Session::flash('result','Banner is not exists.');
            return redirect()->back();
        }
        $this->banner->delBanner($id);
        Session::flash('status', 'Banner is deleted.');
        return redirect('admin/banner/list');
    }

    public function getAdminListBanner() {
        $bannerslide = new Banner();
        return $bannerslide->getAdminListBanner();
    }

    public function viewBanner($id) {
        $bannerslide = new Banner();
        return $bannerslide->getViewSlide($id);
    }

}
