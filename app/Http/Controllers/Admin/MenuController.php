<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuLanguage;
use App\Categorymenu;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MenuController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Menu $menu) {
        $this->menu = $menu;
    }

    public function index() {
        //
        return view('admin/menu/list', [
            'listcate' => $this->menu->getCate()
        ]);
    }

    public function showCate($id_catemenu) {
        $getCateMenu = Categorymenu::find($id_catemenu)->first()->toArray();
        // dd($getCateMenu['title_vn']);
        return view('admin/menu/catemenu', [
            'getcatemenu' => $this->menu->getCateMenu($id_catemenu),
            'listmenu' => $this->menu->getListCate($id_catemenu),
            'cateNameMenu' => $getCateMenu['title_vn']
        ]);
    }

    public function showMenu($id) {
        $item = Menu::find($id);
        // dd($item->id_catemenu);
        if(!$item){
            return redirect()->back()->with('result','Error! Menu is not exists.');
        }
        // $checkcate = $this->menu->getMenu($id);
        $parentMenu = Menu::where('id_catemenu','=', $item->id_catemenu)
                        // ->where('id','!=',$id)
                        ->get()->toArray();
        $detailmenu = Menu::join('menu_language','menu.id','=','menu_language.menu_id')
                ->where('menu_language.menu_id', $id)
                ->select('menu_language.menu_id as id', 'menu_language.title as title', 'menu_language.link as link')
                ->get()->toArray();

        // dd($detailmenu);
        return view('admin/menu/detailmenu', [
            // 'detailmenu' => $this->menu->getMenu($id),
            'detailmenu' => $detailmenu,
            'cate' => $this->menu->getOneCate($item->id_catemenu),
            'parentMenu' => $parentMenu,
            'id_cate' => $item->id_catemenu,
            'category' => $this->menu->getCate(),
            'item' => $item
        ]);
    }

    public function getParentMenu(Request $request){
        if(!$request->isMethod('post') || !$request->isMethod('POST')){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        $id_catemenu = $request->input('id_catemenu');
        if(!$id_catemenu){
            return response()->json([
                'result' => 'Lỗi! Không có quận huyện.',
            ]);
        }
        $parentMenu = Menu::where('id_catemenu','=',$id_catemenu)
                        ->where('id','!=',$request->id)
                        ->orderby('created_at')
                        ->get()
                        ->toArray();
        if(!$parentMenu){
            return response()->json(['result' => 'Lỗi! Vui lòng thử lại.']);
        }
        // $this->province->getProvince();
        return response()->json([
            'result' => 'Thành Công',
            'parentMenu' => $parentMenu
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
        $parentMenu = Menu::where('parent_id','=',0)
                        ->orderby('created_at')
                        ->get()
                        ->toArray();
        return view('admin/menu/add',[
            'listid_catemenu' => $this->menu->getCate(),
            'parentMenu' => $parentMenu
        ]);
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
    
    public function doAddMenu(Request $request)
    {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back()->with('result','Error! Please try again.');
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
        $data = [];
        $data['title'] = $request->input('language-1-title');
        $data['link'] = $request->input('language-1-link')?str_slug($request->input('language-1-link')):str_slug($request->input('language-1-title'));
        $data['id_catemenu'] = $request->input('id_catemenu')?$request->input('id_catemenu'):0;
        $data['parent_id'] = $request->input('parent_id');
        $data['orderby'] = 0;
        $result = Menu::create($data);
        // $id = $this->menu->setMenuLinhVuc($request->input('title_vn'), $request->input('link_vn'), $request->input('id_catemenu'), $request->input('parent_id'));
        if(!$result){
            return redirect()->back()->with('result','Error! Please try again.');
        }

        // dd($language);
        if($language){
            foreach($language as $lang_id => $item){
                $item['menu_id'] = $result['id'];
                $item['language_id'] = $lang_id;
                $item['link'] = $item['title']?str_slug($item['title']):str_slug($item['link']);
                $result_lang = MenuLanguage::create($item);
            }
       }

        return redirect('admin/menu/detailmenu/'.$result['id'])->with('result', 'Success.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function setMenu(Request $request, $id) {
        //

        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back()->with('result','Error! Please try again.');
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

        //dd($language);
        $item = Menu::find($id);
        $item->title = $request->input('language-1-title');
        $item->link = $request->input('language-1-link')?str_slug($request->input('language-1-link')):str_slug($request->input('language-1-title'));
        $item->id_catemenu = $request->input('id_catemenu');
        $item->parent_id = $request->input('parent_id')?$request->input('parent_id'):0;
        $item->orderby = 0;
        $result = $item->save();

        if(!$result){
            return redirect()->back()->with('result','Error! Please try again.');
        }
        MenuLanguage::where('menu_id', $id)->delete();
        if($language){
            foreach($language as $lang_id => $item){
                $item['menu_id'] = $id;
                $item['language_id'] = $lang_id;
                if(empty($item['link'])){
                    $item['link'] = str_slug($item['title']);
                }else{
                    if($item['link'] == '/'){
                        $item['link'] = '/';
                    }else{
                        $item['link'] = str_slug($item['link']);
                    }
                }
                $result_lang = MenuLanguage::create($item);
            }
        }
        return redirect('admin/menu/detailmenu/'.$id)->with('result','Success.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
//        echo "dsadasda";exit;
        $this->menu->doDelLinhVuc($id);
        Session::flash('status', 'Thành công');
        return redirect('admin/menu/catemenu/1');
    }
	
	public function destroyCateMenu($id) {
        //
//        echo "dsadasda";exit;
        $this->menu->delCateMenu($id);
        Session::flash('status', 'Thành công');
        return redirect('admin/menu/list');
    }

}