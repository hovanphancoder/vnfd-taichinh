<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Post;
use App\ProjectType;
use App\Work;
use App\PostLanguage;
use App\Categorypost;
use App\CategorypostLanguage;
use Session;
use File;
use Helper;
use Illuminate\Support\Facades\Cache;

class PostController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Work $work, Post $post, Categorypost $categorypost) {
        $this->post = $post;
        $this->work = $work;
        $this->categorypost = $categorypost;
        $this->getlistcate = $this->post->getListCate();
        $this->countpost = $this->post->countPost();
        $this->defaultimage = "defaultimage.jpg";
        $this->categorypost = $categorypost;
    }

    public function index(Request $request) {
        //
       // $listcate = [];
        // dd('dasda');
        // $categoriepost=[];
        if ($request->input('id_cate')) {
            $listcate = $this->categorypost->categorypost_tree($request->input('id_cate'));
        } else {
            $listcate = $this->categorypost->getListIdCategory();
        }
        // dd($listcate);
        return view('admin/post/list', [
            'listpost' => $this->post->adminListPost($listcate),
            'listcate' => $this->getlistcate
        ]);
    }

    public function searchPostCate(Request $request) {
        $keyword = $request->input('keyword');
        $id_cate = $request->input('id_cate');
//        exit();
//        if(empty($keyword)){
//            return redirect()->route('admin/post/list', $id_cate);
//        }
        $listid = $this->post->getListCateSearch($id_cate);
//        echo "<pre>";
//        print_r($listid);
//        echo "</pre>";
//        exit;

        return view('admin/post/list', [
            'listpost' => $this->post->searchPost($keyword, $listid),
            'listcate' => $this->post->getListCate()
        ]);
//        return redirect("admin/post/viewcategorypost/" . $id);
//        return redirect()->route('admin/post/list', [
//            'id_cate' => $id_cate,
//            'listpost' => $this->post->searchPost(session('locale'), $id_cate, $keyword),
//            'listcate' => $this->post->getListCate()
//        ]);
    }

    public function categoryPost() {
        //return view('admin/post/listcategorypost');
		return view('admin/post/listcategorypost', [
            'listcate' => $this->getlistcate
        ]);
    }

    public function viewCategoryPost($id) {
		$getCategory = Categorypost::find($id);
        if(!$getCategory){
            return redirect("admin/post/listcategorypost");
        }
        $viewCategoryPost = Categorypost::join('categorypost_language','categorypost_language.categorypost_id','=','categorypost.id')->where('categorypost.id',$id)->select('*','categorypost.id as categorypost_id')->get();
		$categoriepost = [];
		$Categorypost = new Categorypost();
        $Categorypost->categorypost_tree(0,'',$categoriepost);
        return view('admin/post/viewcategorypost', [
            'id' => $id,
            'viewCategoryPost' => $viewCategoryPost,
            'viewCategoryPost1' => $getCategory,
            'categoriepost' => $categoriepost,
            'listcate' => $this->getlistcate
        ]);
    }

    public function editCategoryPost(Request $request, $id) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/post/listcategorypost");
        }
        //bo sung language
		/*foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-title']= 'required';
        }
		$this->validate($request,$rules);*/
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language') !== false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
		$viewItem = Categorypost::find($id);
        if(!$viewItem){
            Session::flash('status', 'Category not exist!');
            return redirect("admin/post/listcategorypost");
        }
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('url');
        }
        $viewItem->title = $request->input('language-1-title');
        $viewItem->parent_id = $request->input('parent_id');
        $viewItem->slug = !empty($request->input('language-1-slug'))?str_slug($request->input('language-1-slug')):str_slug($request->input('language-1-title'));
        $viewItem->description = $request->input('language-1-description');
		$viewItem->image = $image;
		$viewItem->save();
		if ($viewItem) {
            Session::flash('status', 'Success!');
			//save table: categorypost language, xoá ghi lại 
			CategorypostLanguage::where('categorypost_id',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
                    if(empty($item['slug'])){
                        $item['slug'] = str_slug($item['title']);
                    }
					$item['language_id'] = $lang_id;
					$item['categorypost_id'] = $id;
					CategorypostLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect("admin/post/viewcategorypost/" . $id);
    }

    public function addCategoryPost() {
        return view('admin/post/addcategorypost', [
            'listcate' => $this->getlistcate
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

        // kiem tra id co ton tai trong table post
        // if (!in_array($id, $this->post->getListId())) {
        //     return redirect("admin/post/list");
        // }
        $item = Post::find($id);
        if(!$item){
            return redirect("admin/post/list");
        }
		$viewPost = Post::join('post_language','post_language.post_id','=','post.id')->where('post.id','=',$id)->select('post_language.*','post.id as main_post_id')->get();
        $listWork = Work::orderby('created_at','desc')->where('language_id',get_id_locale())->get()->toArray();
        $listProject = ProjectType::orderby('created_at','desc')->where('language_id',get_id_locale())->get()->toArray();
        // dd($listWork);
		// dd($viewPost->toArray());
        return view('admin/post/view', [
            'view' => $this->post->adminViewPost($id),
            'viewPost' => $viewPost,
            'listWork' => $listWork,
            'listProject' => $listProject,
            'listcatepost' => $this->getlistcate,
            'id_cate' => $this->post->getCurrentCate($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        $view = $this->post->getPost($id);

        if ($request->isMethod("POST") || $request->isMethod("post")) {

            if ($request->hasFile('image')) {
                $image = time() . "-" . $request->file('image')->getClientOriginalName();
                $destinationPath = public_path() . '/images/upload/post';
                $request->file('image')->move($destinationPath, $image);
                // get image size
                $image_info = getimagesize(url('images/upload/post/'.$image));
                $size = $image_info[0].'x'.$image_info[1];
                $src_image = url('images/upload/post/'.$image);
                // dd($image);
                // $tmp_currentimage = explode('.',$image);
                // $this->abtCropImage($src_image, $tmp_currentimage[0], 283, 184, 0, 0);
                // $this->abtResizeImage($src_image, $tmp_currentimage[0], 283, 283);
            } else {
                $image = $request->input('path');
                $size = "";
            }
            
            $currentGallery = [];
            if (!empty($view->galleries)) {
                $currentGallery = json_decode($view->galleries);
            }

            $newGalleries = !empty($request->input('new_galleries')) ? json_decode($request->input('new_galleries')) : [];

            $removedGalleries = array_diff($currentGallery, $newGalleries);


            // IF SOME IMAGES IN GALLERY ARE REMOVED
            if (count($removedGalleries) > 0) {
                foreach ($removedGalleries as $key => $value) {
                    File::delete(public_path('images/upload/post/' . $value));
                }
            }
            $gallery_thum = [];
            if ($request->hasFile('galleries')) {
                $total = count($request->file('galleries'));
                if ($total > 0) {
                    for ($i = 0; $i < $total; $i++) {
                        $file = $request->file('galleries')[$i];
                        $galleryImage = time() . "-" . $i . '-' . $file->getClientOriginalName();
                        $file->move(public_path('images/upload/post/'), $galleryImage);
                        $tmp_currentphoto = explode('.',$galleryImage);
                        $src_photo = url('images/upload/post/'.$galleryImage);
                        //$abt_photo = $this->abtResizeImage($src_photo, $tmp_currentphoto[0], 170, 0);
                        //$gallery_thum[] = $abt_photo;
                        $gallery[] = $galleryImage;
                        $newGalleries[] = $galleryImage;
                    }
                }
            }
            $gallery_thum = count($gallery_thum) === 0 ? null : json_encode($gallery_thum);
            $newGalleries = count($newGalleries) === 0 ? null : json_encode($newGalleries);


            // neu loi xuat ra "The title may not be greater than 255 characters."
           
			//bo sung language
			/*foreach(config('app.locales') as $key=>$code){
				$rules['language-'.$key.'-title']= 'required';
			}
			$this->validate($request,$rules);*/
			$language=[];
			foreach($request->all() as $k=>$v){
				if(strpos($k,'language')!==false){
					$str=explode('-', $k);
					$language[$str[1]][$str[2]]=$v;
				}
			}
            // dd($language);
			$viewItem = Post::find($id);
			$viewItem->title = $request->input('language-1-title');
            $viewItem->slug = empty($request->input('language-1-slug'))?str_slug($request->input('language-1-title')):$request->input('language-1-slug');
            $viewItem->id_cate = $request->input('category');
			$viewItem->post_status = $request->input('post_status');
            $viewItem->id_work = $request->input('work');
            $viewItem->id_project_type = $request->input('project_type');
			$viewItem->slug = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-title'));
			$viewItem->description = $request->input('language-1-description');
			$viewItem->content = $request->input('language-1-content');
			$viewItem->galleries = $newGalleries;
            $viewItem->galleries_thumb = $gallery_thum;
            $viewItem->setting = $size;
			$viewItem->image = $image;
            $viewItem->id_work = $request->input('work')?$request->input('work'):0;
            $viewItem->id_project_type = $request->input('project_type')?$request->input('project_type'):0;
			$viewItem->seotitle = $request->input('seotitle');
			$viewItem->seokeyword = $request->input('seokeyword');
			$viewItem->seodescription = $request->input('seodescription');
			$viewItem->feature = ($request->input('feature') == "on") ? 1 : 0;
			$viewItem->save();
			if ($viewItem) {
				Session::flash('status', 'Success!');
				//save table: post language, xoá ghi lại 
				PostLanguage::where('post_id',$id)->delete();
				if($language){
					foreach($language as $lang_id=>$item){
                        $item['language_id'] = $lang_id;
						$item['slug'] = empty($request->input('language-'.$lang_id.'-slug'))?str_slug($item['title']):$request->input('language-'.$lang_id.'-slug');
                        $item['post_id'] = $id;
                        $item['post_status'] = $request->input('post_status');
                        // dd($item);
						PostLanguage::create($item);
					}
					Session::flash('status', 'Cập nhật bài viết thành công.');
			   }
			} else {
				Session::flash('status', 'Failed!');
			}
            Cache::forget('post');
            return redirect()->back();
        }
        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function add() {

        $listWork = Work::orderby('created_at','desc')->where('language_id',get_id_locale())->get()->toArray();
        $listProject = ProjectType::orderby('created_at','desc')->where('language_id',get_id_locale())->get()->toArray();
        return view('admin/post/add', [
            'listcate' => $this->post->getListCate(),
            'listWork' => $listWork,
            'listProject' => $listProject,
        ]);
    }

    public function doAdd(Request $request) {
        
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        //bo sung language
		// foreach(config('app.locales') as $key=>$code){
  //           $rules['language-'.$key.'-title']= 'required';
  //       }
		// $this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        $gallery = [];
        $gallery_thumb = [];
        if ($request->hasFile('galleries')) {
            $total = count($request->file('galleries'));
            if ($total > 0) {
                for ($i = 0; $i < $total; $i++) {
                    $file = $request->file('galleries')[$i];
                    $galleryImage = time() . "-" . $i . '-' . $file->getClientOriginalName();
                    $destinationPath = public_path( 'images/upload/post/');
                    $file->move($destinationPath, $galleryImage);
                    $tmp_currentphoto = explode('.',$galleryImage);
                    $src_photo = url('images/upload/post/'.$galleryImage);
                    $abt_photo = $this->abtResizeImage($src_photo, $tmp_currentphoto[0], 170, 0);
                    $gallery_thumb[] = $abt_photo;
                    $gallery[] = $galleryImage;
                }
                    // dd($gallery_thum);
                
            }
        }
        $gallery_thumb = count($gallery_thumb) === 0 ? null : json_encode($gallery_thumb);
        $gallery = count($gallery) === 0 ? null : json_encode($gallery);
		if ($request->hasFile('image')) {
            
            // $image       = $request->file('image');
            // // $filename    = $image->getClientOriginalName();
            // $filename = explode('.',$image->getClientOriginalName());
            // // dd($filename);
            // $image_resize = Image::make($image->getRealPath());              
            // // $image_resize->resize(300, null);
            // $image_resize->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $image_resize->save(public_path('images/upload/test/' .str_slug($filename[0]).'-1.'.$filename[1]));
            // $image_resize->crop(300,150,0,0);
            // $image_resize->save(public_path('images/upload/test/' .str_slug($filename[0]).'-2.'.$filename[1]));
            // exit;


            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
            $src_image = url('images/upload/post/'.$image);
            // dd($image);
            // $tmp_currentimage = explode('.',$image);
            // $this->abtCropImage($src_image, $tmp_currentimage[0], 400, 450, 0, 0);
            // $this->abtResizeImage($src_image, $tmp_currentimage[0], 400, 400);
        } else {
            $image = $this->defaultimage;
        }
        $size = "";
        // dd($gallery);
		$input["title"] = $request->input('language-1-title');
        $input["slug"] = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-title'));
        $input["description"] = $request->input('language-1-description');
        $input["content"] = $request->input('language-1-content');
        $input["galleries"] = $gallery;
        $input["galleries_thumb"] = $gallery_thumb;
        $input["setting"] = $size;
		$input["seotitle"] = $request->input('seotitle');
        $input["seokeyword"] = $request->input('seokeyword');
        $input["seodescription"] = $request->input('seodescription');
        $input["id_cate"] = $request->input('category');
        $input["id_work"] = $request->input('work')?$request->input('work'):0;
        $input["id_project_type"] = $request->input('project_type')?$request->input('project_type'):0;
        $input["feature"] = ($request->input('feature') == "on") ? 1 : 0;
        $input["track_id"] = $request->input('track_id');
        $input["image"] = $image;
        $result = Post::create($input);
		if ($result) {
            
			//save table: post language, by newbie ana
            // dd($language);
			if($language){
				foreach($language as $lang_id => $item){
					$item['language_id'] = $lang_id;
                    $item['post_id'] = $result['id'];
					$item['slug'] = !empty($item['slug'])?str_slug($item['slug']):str_slug($item['title']);
					PostLanguage::create($item);
				}
				Session::flash('status', 'Thêm bài viết thành công');
				return redirect('admin/post/view/' . $result['id']);
		   }
	    }
        

        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function work(Request $request){
        $listItem = Work::orderby('created_at','desc')->where('language_id', 1)->get();

        return view('admin.post.list_work',[
            'listItem' => $listItem->toArray(),
        ]);

    }
    public function projecttype(Request $request){
        $listItem = ProjectType::orderby('created_at','desc')->where('language_id', 1)->get();

        return view('admin.post.list_project_type',[
            'listItem' => $listItem->toArray(),
        ]);

    }

    public function workAdd(Request $request){
        return view('admin.post.addwork');
    }
    public function projecttypeAdd(Request $request){
        return view('admin.post.addprojecttype');
    }

    public function workShow(Request $request, $id_work){
        $item = Work::where('id_work',$id_work)->get();
        // dd($item->toArray());
        // $viewPost = Post::join('post_language','post_language.post_id','=','post.id')->where('post.id','=',$id)->select('post_language.*','post.id as main_post_id')->get();
        if(!$item){
            Session::flash('status', 'Không tồn tại!');
            return redirect()->back();
        }
        return view('admin.post.viewwork',[
            'item' => $item->toArray()
        ]);
    }

    public function projecttypeShow(Request $request, $id_project_type){
        $item = ProjectType::where('id_project_type',$id_project_type)->get();
        // dd($item->toArray());
        // $viewPost = Post::join('post_language','post_language.post_id','=','post.id')->where('post.id','=',$id)->select('post_language.*','post.id as main_post_id')->get();
        if(!$item){
            Session::flash('status', 'Không tồn tại!');
            return redirect()->back();
        }
        return view('admin.post.viewprojecttype',[
            'item' => $item->toArray()
        ]);
    }

    public function workEdit(Request $request, $id_work){
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $language=[];
        // dd($request->all());
        foreach($request->all() as $k => $v){
            if(strpos($k,'language') !== false){
                $str = explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }
        $result = Work::where('id_work', $id_work)->delete();
        // dd($result);
        if($language){
            foreach($language as $lang_id => $item){
                $item['language_id'] = $lang_id;
                $item['id_work'] = $id_work;
                Work::create($item);
            }
            Session::flash('status', 'Success!');
            // return redirect('admin/post/work/' . $result['id']);
            return redirect()->back();
        }
        Session::flash('status', 'Warning, try again!');
        return redirect()->back();
    }

    public function projecttypeEdit(Request $request, $id_project_type){
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $language=[];
        // dd($request->all());
        foreach($request->all() as $k => $v){
            if(strpos($k,'language') !== false){
                $str = explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }
        $result = ProjectType::where('id_project_type', $id_project_type)->delete();
        // dd($result);
        if($language){
            foreach($language as $lang_id => $item){
                $item['language_id'] = $lang_id;
                $item['id_project_type'] = $id_project_type;
                ProjectType::create($item);
            }
            Session::flash('status', 'Success!');
            // return redirect('admin/post/work/' . $result['id']);
            return redirect()->back();
        }
        Session::flash('status', 'Warning, try again!');
        return redirect()->back();
    }

    public function workCreate(Request $request){
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $language=[];
        // dd($request->all());
        foreach($request->all() as $k => $v){
            if(strpos($k,'language') !== false){
                $str = explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }

        $count = Work::all()->count();

        if($language){
            foreach($language as $lang_id => $item){
                $item['language_id'] = $lang_id;
                $item['id_work'] = $count + 1;
                Work::create($item);
            }
            Session::flash('status', 'Success!');
            // return redirect('admin/post/work/' . $result['id']);
            return redirect('admin/post/work/');
        }
        return redirect()->back();
    }
    public function projecttypeCreate(Request $request){
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        $language=[];
        // dd($request->all());
        foreach($request->all() as $k => $v){
            if(strpos($k,'language') !== false){
                $str = explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }

        $count = ProjectType::all()->count();

        if($language){
            foreach($language as $lang_id => $item){
                $item['language_id'] = $lang_id;
                $item['id_project_type'] = $count + 1;
                ProjectType::create($item);
            }
            Session::flash('status', 'Success!');
            // return redirect('admin/post/work/' . $result['id']);
            return redirect('admin/post/project_type/');
        }
        return redirect()->back();
    }

    public function destroyWork($id_work){
        $item = Work::where('id_work',$id_work)->get();
        if(!$item){
            Session::flash('status','Work not exist!');
            return redirect()->back();
        }
        $result = Work::where('id_work',$id_work)->delete();
        if(!$result){
            Session::flash('status','Error! Try again.');
            return redirect()->back();
        }
        Session::flash('status','Success!');
        return redirect()->back();

    }

    public function destroyProjecttype($id_project_type){
        $item = ProjectType::where('id_project_type',$id_project_type)->get();
        if(!$item){
            Session::flash('status','Work not exist!');
            return redirect()->back();
        }
        $result = ProjectType::where('id_project_type',$id_project_type)->delete();
        if(!$result){
            Session::flash('status','Error! Try again.');
            return redirect()->back();
        }
        Session::flash('status','Success!');
        return redirect()->back();

    }

    public function doAddCatePost(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Errors!');
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
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $this->defaultimage;
        }
        $input["title"] = $request->input('language-1-title');
        $input["slug"] = !empty($request->input('language-1-slug'))?$request->input('language-1-slug'):str_slug($request->input('language-1-title'));
        $input["description"] = $request->input('language-1-description');
        $input["parent_id"] = $request->input('parent_id');
		$input["image"] = $image;
		$result = Categorypost::create($input);
		if ($result) {
            
			//save table: categorypost language, by newbie ana
            // dd($language);
			if($language){
				foreach($language as $lang_id=>$item){
                    if(empty($item['slug'])){
                        $item['slug'] = str_slug($item['title']);
                    }
					$item['language_id'] = $lang_id;
					$item['categorypost_id'] = $result['id'];
					CategorypostLanguage::create($item);
				}
		   }
           Session::flash('status', 'Success!');
	    }
        
        return redirect("admin/post/viewcategorypost/" . $result['id']);
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

        $this->post->delPost($id);
        Session::flash('status', 'Xóa bài viết thành công');
        return redirect()->back();
    }

    public function destroyCatePost($id) {
        //

		$viewItem = Categorypost::find($id);
		$check = Post::where('id_cate',$id)->get();
		
		if(count($check)==0)
			$result = $viewItem->delete();
        if (isset($result)) {
			CategorypostLanguage::where('categorypost_id',$id)->delete();
			Session::flash('status', 'Success!');
        } else {
            Session::flash('status', 'Failed! This item maybe using!');
        }
        return redirect()->back();
    }

    public function listCatePost($id_cate) {
//        echo "dsadsa";exit;
//        return view('admin/post/list', [
//            'listpost' => $this->post->adminListPost(),
//            'listcate' => $this->getlistcate
//        ]);
//        return redirect('admin/post/list/'.$id_cate);
        return view('admin/post/list', [
            'id_cate' => $id_cate,
            'listpost' => $this->post->adminListCatePost($id_cate),
            'listcate' => $this->getlistcate
        ]);
    }

    public function setOrder(Request $request) {

        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }

        $this->post->updatePost($id, session('locale'), $title, $slug, $description, $content, $image, $category, $collection, $feature, $seotitle, $seokeyword, $seodescription, $checkSlug, $updated_at);
    }

}
