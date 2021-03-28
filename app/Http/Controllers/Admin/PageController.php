<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Page;
use App\PageLanguage;
use Session;

class PageController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Page $page) {
        $this->page = $page;
        //$this->getlistcate = $this->page->getListCate();		
        $this->countPage = $this->page->countPage();
        $this->defaultimage = "defaultimage.jpg";
        // $this->getlistslugvn = $this->page->getListSlugVN();
        // $this->getlistslugen = $this->page->getListSlugEN();
        //$this->menu = $this->getListMenu();
    }

    public function index() {
        //
        return view('admin/page/list', [
            'listpage' => $this->page->adminListPage()
        ]);
    }

    public function add() {
        return view('admin/page/add');
    }

    public function doAdd(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        //bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-title'] = '';
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
            $destinationPath = public_path() . '/images/upload/page';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $this->defaultimage;
        }
		$input["title"] = $request->input('language-1-title');
        $input["slug"] = !empty($request->input('language-1-slug'))?str_slug($request->input('language-1-slug')):str_slug($request->input('language-1-title'));
        $input["description"] = $request->input('language-1-description');
        $input["content"] = $request->input('language-1-content');
		$input["seotitle"] = $request->input('seotitle')?$request->input('seotitle'):"";
        $input["seokeyword"] = $request->input('seokeyword')?$request->input('seokeyword'):"";
        $input["seodescription"] = $request->input('seodescription')?$request->input('seodescription'):"";
        $input["image"] = $image;
        $result = Page::create($input);
		if ($result) {
            
			//save table: post language, by newbie ana
            // dd($language);
			if($language){
				foreach($language as $lang_id => $item){
                    if(empty($item['slug'])){
                        $item['slug'] = str_slug($item['title']);
                    }
					$item['language_id'] = $lang_id;
					$item['page_id'] = $result['id'];
					PageLanguage::create($item);
				}
				Session::flash('status', 'Thêm bài viết thành công');
				return redirect('admin/page/view/' . $result['id']);
		   }
	    }      

        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function create() {
        //
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
        // kiem tra id co ton tai trong table post
        $item = Page::find($id);
        if (!$item) {
            return redirect("admin/page/list");
        }
		$viewPage = Page::join('page_language','page_language.page_id','=','page.id')->where('page.id',$id)->select('*','page.id as main_page_id')->get();
        return view('admin/page/view', [
            'view' => $this->page->adminViewPage($id),
            'viewPage' => $viewPage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        
        if ($request->isMethod("POST") || $request->isMethod("post")) {
            
            if ($request->hasFile('image')) {
                $image = time() . "-" . $request->file('image')->getClientOriginalName();
                $destinationPath = public_path() . '/images/upload/page';
                $request->file('image')->move($destinationPath, $image);
            } else {
                $image = $request->input('path');
            }
            //bo sung language
			foreach(config('app.locales') as $key=>$code){
				$rules['language-'.$key.'-title'] = '';
			}
			$this->validate($request,$rules);
			$language=[];
			foreach($request->all() as $k=>$v){
				if(strpos($k,'language')!==false){
					$str=explode('-', $k);
					$language[$str[1]][$str[2]]=$v;
				}
			}
			$viewItem = Page::find($id);
			$viewItem->title = $request->input('language-1-title');
			$viewItem->slug = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-2-title'));
			$viewItem->description = $request->input('language-1-description');
			$viewItem->content = $request->input('language-1-content');
			$viewItem->image = $image;
			$viewItem->seotitle = $request->input('seotitle')?$request->input('seotitle'):"";
			$viewItem->seokeyword = $request->input('seokeyword')?$request->input('seokeyword'):"";
			$viewItem->seodescription = $request->input('seodescription')?$request->input('seodescription'):"";
			$viewItem->save();
			if ($viewItem) {
				Session::flash('status', 'Success!');
				//save table: page language, xoá ghi lại 
				PageLanguage::where('page_id',$id)->delete();
				if($language){
					foreach($language as $lang_id=>$item){
                        if(empty($item['slug'])){
                            $item['slug'] = str_slug($item['title']);
                        }
						$item['language_id'] = $lang_id;
						$item['page_id'] = $id;
						PageLanguage::create($item);
					}
					Session::flash('status', 'Cập nhật bài viết thành công.');
			   }
			} else {
				Session::flash('status', 'Failed!');
			}
            Session::flash('status', 'Cập nhật trang thành công.');
            return redirect()->back();
        }
        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
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
        $this->page->delPage($id);
        Session::flash('status', 'Xóa trang thành công');
        return redirect('admin/page/list');
    }

}
