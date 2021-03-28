<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Video;
use App\VideoLanguage;
use Session;
use App\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VideoController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
        $listItem = Video::orderby('created_at','desc')->paginate(10);
        return view('admin.video.list',[
            'listItem' => $listItem
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
        $viewVideo = Video::join('video_language','video.id','=','video_language.video_id')->where('video_language.video_id', $id)->get();
        $item = Video::find($id);
        return view('admin/video/view', [
            'viewVideo' => $viewVideo,
            'item' => $item
        ]);
    }
    
    public function viewVideo($id) {
        $video = new Video();
        return $video->viewVideo($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function add() {
        return view('admin.video.add',[

        ]);
    }

    public function create(Request $request) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back()->with('result','Error! Try again.');
        }
        $data = [];
        //bo sung language
        foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name'] = '';
        }
        $this->validate($request,$rules);
        $language = [];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language') !== false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/video';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = '';
        }
        $data['name'] = $request->input('language-1-name');
        $data['path'] = $request->input('language-1-path');
        $data['embed'] = $request->input('language-1-embed');
        $data['description'] = $request->input('language-1-description');
        $data['image'] = $image;
        $data['created_at'] = date('Y-m-d h:i:s');
        $data['updated_at'] = date('Y-m-d h:i:s');
        $result = Video::create($data);
        if ($result) {
            if($language){
                foreach($language as $lang_id => $item){
                    $item['language_id'] = $lang_id;
                    $item['video_id'] = $result['id'];
                    VideoLanguage::create($item);
                }
           }
        }else{
            return redirect()->back()->with('result','Error! Try again.');
        }

        return redirect()->to('admin/video/view/'.$result['id'])->with('result','Success.');
    }

    public function edit(Request $request, $id) {
        //
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            return redirect()->back()->with('result','Error! Try again.');
        }
        if ($request->hasFile('image')) {
            $image = time() . "-" . $request->file('image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/video';
            $request->file('image')->move($destinationPath, $image);
        } else {
            $image = $request->input('path');
        }
        //bo sung language
        foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name'] = '';
        }
        $this->validate($request,$rules);
        $language = [];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language') !== false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]] = $v;
            }
        }
        $item = Video::find($id);
        $item->name = $request->input('language-1-name');
        $item->description = $request->input('language-1-description');
        $item->path = $request->input('language-1-path');
        $item->image = $image;
        $item->embed = $request->input('language-1-embed');
        $item->updated_at = date('Y-m-d h:i:s');
        $item->save();
        if ($item) {
            Session::flash('status', 'Success!');
            //save table: page language, xoá ghi lại 
            VideoLanguage::where('video_id', $id)->delete();
            if($language){
                foreach($language as $lang_id=>$item){
                    $item['language_id'] = $lang_id;
                    $item['image'] = $image;
                    $item['video_id'] = $id;
                    VideoLanguage::create($item);
                }
           }
        }
        return redirect()->back()->with('result','Sucess!');
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
