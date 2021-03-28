<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

class VideoController extends Controller
{
    //
    public function __construct()
    {

    }

    public function getVideo(Request $request){
    	if (!$request->isMethod('post') || !$request->isMethod('POST')) {
            return response()->json(['result' => '<p>Lỗi! Vui lòng thử lại</p>']);
        }
        $video = Video::where('embed', $request->input('youtube_id'))->first();
        if(!$video){
        	return response()->json(['result' => '<p>Lỗi! Video không tồn tại</p>']);
        }
        return response()->json(['result' => 1]);
    }
}
