<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Post;
use App\Categorypost;
use App\Posttag;

class TagController extends Controller
{
    //
    public function index(){
    	$tag = Posttag::orderBy('created_at', 'desc')
    				->get()
    				->toArray();
    	return view('admin.post.tag',[
    		'listTag' => $tag
    	]);
    }

    public function add(Request $request){
    	if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'max:255'
        ];
        $message = [
            'name.required' => 'Tên tag không được để trống',
            'name.max' => 'Tên tag quá dài',
            'slug.max' => 'Slug tag quá dài',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            Session::flash('status', $validator->errors());
            return redirect()->back()->withErrors($validator->errors());
        }
        $image = '';
        if ($request->hasFile('image')) {
            // dd($request->image);
            $file = explode('.',$request->image->getClientOriginalName());
            $image = time() . "-" . str_slug($file[0]).'.'.$file[1];
            $destinationPath = public_path() . '/images/upload/tag';
            $request->file('image')->move($destinationPath, $image);
        }
    	$tag = array();
    	$tag['name'] = $request->name;
    	$tag['slug'] = $request->slug?str_slug($request->slug):str_slug($request->name);
    	$tag['description'] = $request->description;
        $tag['image'] = $image;
    	$tag['created_at'] = date('Y-m-d h:i:s');
    	$tag['updated_at'] = date('Y-m-d h:i:s');
    	$result = Posttag::create($tag);
    	if(!$result){
    		Session::flash('status', $validator->getMessageBag()->add('result', 'Error! Try again.'));
    		return redirect()->back();
    	}
		Session::flash('status', $validator->getMessageBag()->add('result', 'Success.'));
    	return redirect()->back();
    }

    public function show($id_tag){
        $tag = Posttag::orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
        $item = Posttag::find($id_tag);
        return view('admin.post.viewtag',[
            'listTag' => $tag,
            'item' => $item
        ]);
    }

    public function edit(Request $request, $id_tag){
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'max:255'
        ];
        $message = [
            'name.required' => 'Tên tag không được để trống',
            'name.max' => 'Tên tag quá dài',
            'slug.max' => 'Slug tag quá dài',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            Session::flash('status', $validator->errors());
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->hasFile('image')) {
            // dd($request->image);
            $file = explode('.',$request->image->getClientOriginalName());
            $image = time() . "-" . str_slug($file[0]).'.'.$file[1];
            $destinationPath = public_path() . '/images/upload/tag';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->old_image;
        }

        $item = Posttag::find($id_tag);
        $item->name = $request->name;
        $item->slug = $request->slug?str_slug($request->slug):str_slug($request->name);
        $item->description = $request->description;
        $item->image = $image;
        $result = $item->save();
        if(!$result){
            Session::flash('status', $validator->getMessageBag()->add('result', 'Error!. '));
        }
        Session::flash('status', $validator->getMessageBag()->add('result', 'Sucess!. '));
        return redirect()->back();
    }

    public function destroy(Request $request, $id){
    	$item = Posttag::find($id);
        $validator = Validator::make($request->all(), [], []);
    	if(!$item){
    		Session::flash('status', $validator->getMessageBag()->add('result', 'Error!. '));
    	}
        $result = $item->delete();
        if ($result) {
            Session::flash('status', $validator->getMessageBag()->add('result', 'Success.'));
        } else {
            Session::flash('status', $validator->getMessageBag()->add('result', 'Failed.'));
        }
        return redirect()->route('tag');
    }
}
