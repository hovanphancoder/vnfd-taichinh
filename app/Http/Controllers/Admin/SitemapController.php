<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Post;
use App\Categorypost;
use Session;

class SitemapController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(Post $post, Categorypost $categorypost) {
        $this->post = $post;
        $this->getlistslugvn = $this->post->getListSlugVN();
        $this->getlistslugen = $this->post->getListSlugEN();
        $this->categorypost = $categorypost;
    }

    public function index() {
        //
        echo "Dsadsad";exit;
//        $listcate = [];
        $posts = Post::all()->orderBy('updated_at', 'DESC')->get();
        return response()->view('vendor.sitemap', compact('posts'))->header('Content-Type', 'text/xml');
    }

    public function searchPostCate(Request $request) {
        $keyword = $request->input('keyword');
        $id_cate = $request->input('id_cate');
//        exit();
//        if(empty($keyword)){
//            return redirect()->route('admin/post/list', $id_cate);
//        }
        $listid = $this->post->getListCateSearch($id_cate);

        return view('admin/post/list', [
            'listpost' => $this->post->searchPost(session('locale'), $keyword, $listid),
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
        return view('admin/post/listcategorypost');
    }

    public function viewCategoryPost($id) {
        if (!in_array($id, $this->post->getListIdCategory())) {
            return redirect("admin/post/listcategorypost");
        }
        return view('admin/post/viewcategorypost', [
            'viewcategorypost' => $this->post->viewCategoryPost($id),
            'listcate' => $this->getlistcate
        ]);
    }

    public function editCategoryPost(Request $request, $id) {
        if (!in_array($id, $this->post->getListIdCategory())) {
            return redirect("admin/post/listcategorypost");
        }
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/post/listcategorypost");
        }
        if (session('locale') == "en") {
            $title = $request->input('title_en');
            $slug = !empty($request->input('slug_en')) ? str_slug($request->input('slug_en')) : str_slug($title);
            $description = $request->input('description_en');
        } else {
            $title = $request->input('title_vn');
            $slug = !empty($request->input('slug_vn')) ? str_slug($request->input('slug_vn')) : str_slug($title);
            $description = $request->input('description_vn');
        }
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('url');
        }
        $parent_id = ($request->input('parent_id') == 1) ? 0 : $request->input('parent_id');
        $updated_at = date("Y-m-d H:i:s");
        $this->post->editCategoryPost($id, session('locale'), $title, $slug, $description, $parent_id, $image, $updated_at);
        Session::flash('status', 'Success');
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
        if (!in_array($id, $this->post->getListId())) {
            return redirect("admin/post/list");
        }

        return view('admin/post/view', [
            'view' => $this->post->adminViewPost($id),
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
        //
//        echo "Dsadas";exit;
        if ($request->isMethod("POST") || $request->isMethod("post")) {
            if (session('locale') == "vn") {
                $rules = [
                    'title_vn' => 'required|max:255',
                    'content_vn' => 'required',
//            'feature' => 'required',
//            'image' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }

                $title = $request->input('title_vn');
//                $slug = $request->input('slug_vn');
//                if (in_array($slug, $this->getlistslugvn)) {
//                    echo "<br>" . $slug .= "-" . $this->countpost;
//                }
                $slug = !empty($request->input('slug_vn')) ? str_slug($request->input('slug_vn')) : str_slug($request->input('title_vn'));




                $description = $request->input('description_vn');
                $content = $request->input('content_vn');
                $checkSlug = $this->post->getSlug($id, (session('locale')));
            } else {
                $rules = [
                    'title_en' => 'required|max:255',
                    'content_en' => 'required',
//            'feature' => 'required',
//            'image' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }

                $title = $request->input('title_en');
                $slug = !empty($request->input('slug_en')) ? str_slug($request->input('slug_en')) : str_slug($request->input('title_en'));

                $description = $request->input('description_en');
                $content = $request->input('content_en');
                $checkSlug = $this->post->getSlug($id, (session('locale')));
            }

            if ($request->hasFile('image')) {
                $image = time() . "-" . $request->file('image')->getClientOriginalName();
                $destinationPath = public_path() . '/images/upload/post';
                $request->file('image')->move($destinationPath, $image);
            } else {
                $image = $request->input('path');
            }
            $seotitle = $request->input('seotitle');
            $seokeyword = $request->input('seokeyword');
            $seodescription = $request->input('seodescription');
            $category = $request->input('category');
            $collection = $request->input('collection');
            $feature = ($request->input('feature') == "on") ? 1 : 0;
            $updated_at = date("Y-m-d H:i:s");

//        exit;
            // neu loi xuat ra "The title may not be greater than 255 characters."
            $this->post->updatePost($id, session('locale'), $title, $slug, $description, $content, $image, $category, $collection, $feature, $seotitle, $seokeyword, $seodescription, $checkSlug, $updated_at);
            Session::flash('status', 'Cập nhật bài viết thành công.');
            return redirect()->back();
        }
        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function add() {
        return view('admin/post/add', [
            'listcate' => $this->post->getListCate(),
            'listcollection' => $this->getlistcollection
        ]);
    }

    public function doAdd(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect()->back();
        }
        if (session('locale') == "vn") {
            $rules = [
                'title_vn' => 'required|max:255',
                    //'description_vn' => 'required|max:255'
//                'category' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            $title_vn = $request->input('title_vn');
            $title_en = "";
            $slug_vn = empty($request->input('slug_vn')) ? str_slug($request->input('title_vn')) : str_slug($request->input('slug_vn'));
            if (in_array($slug_vn, $this->getlistslugvn)) {
                $slug_vn .= "-" . $this->countpost;
            }
            $slug_en = "";

            $description_vn = $request->input('description_vn');
            $description_en = "";
            $content_vn = $request->input('content_vn');
            $content_en = "";
        } else {
            $rules = [
                'title_en' => 'required|max:255',
                    //'description_en' => 'required|max:255'
//                'category' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            $title_en = $request->input('title_en');
            $title_vn = "";
            $slug_en = empty($request->input('slug_en')) ? str_slug($request->input('title_en')) : str_slug($request->input('slug_en'));
            if (in_array($slug_en, $this->getlistslugen)) {
                $slug_en .= "-" . $this->countpost;
            }
            $slug_vn = "";
            $description_en = $request->input('description_en');
            $description_vn = "";
            $content_en = $request->input('content_en');
            $content_vn = "";
        }
//            exit;
        $seotitle = $request->input('seotitle');
        $seokeyword = $request->input('seokeyword');
        $seodescription = $request->input('seodescription');
        $category = $request->input('category');
        $collection = $request->input('collection');
        $feature = ($request->input('feature') == "on") ? 1 : 0;
        $created_at = date("Y-m-d H:i:s");
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $this->defaultimage;
        }
        $id = $this->post->addPost($title_vn, $title_en, $slug_vn, $slug_en, $description_vn, $description_en, $content_vn, $content_en, $image, $category, $collection, $feature, $seotitle, $seokeyword, $seodescription, $created_at);
        $this->post->updateSlugPost($id, $slug_vn, $slug_en);
        Session::flash('status', 'Thêm bài viết thành công');
        return redirect('admin/post/view/' . $id);

        Session::flash('status', 'Lỗi! Đã xảy ra sự cố. Vui lòng thử lại!');
        return redirect()->back();
    }

    public function doAddCatePost(Request $request) {
//        echo "<pre>";
//        print_r($request);
//        echo "</pre>";
//        exit;
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Errors!');
            return redirect()->back();
        }
        if (session('locale') == "en") {
            $title = $request->input('title_en');
            $slug = !empty($request->input('slug_en')) ? str_slug($request->input('slug_en')) : str_slug(($title));
            $description = $request->input('description_en');
        } else {
            $title = $request->input('title_vn');
            $slug = !empty($request->input('slug_vn')) ? str_slug($request->input('slug_vn')) : str_slug(removeDau($title));
            $description = $request->input('description_vn');
        }
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/post';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $this->defaultimage;
        }
        $parent_id = ($request->input('parent_id') == 1) ? 0 : $request->input('parent_id');

        $created_at = date("Y-m-d H:i:s");
        $id = $this->post->addCatePost(session('locale'), $title, $slug, $description, $parent_id, $image, $created_at);
        Session::flash('status', 'Success');
        return redirect("admin/post/viewcategorypost/" . $id);
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

        $this->post->delCatePost($id);
        Session::flash('status', 'Xóa bài viết thành công');
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

}
