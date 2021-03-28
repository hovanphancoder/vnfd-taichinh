<?php



namespace App\Http\Controllers;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;



class SearchController extends AppController

{

    //

    public function __construct(Post $post){

    	parent::__construct();

    	$this->post = $post;

    }



    public function index(Request $request){
    	if(!$request->isMethod('get') || !$request->isMethod('GET')){
    		return redirect()->back();
		}
		if(!$request->has('keyword') || $request->input('keyword') == ""){
			return view('pages.search',[
			'result' => false,
			'listPost' => [],
		]);
		}
    	$keyword = $request->input('keyword');
		//  dd($keyword);
		//  if(!$request->has($keyword)){
		//  		return  redirect();
		//  }

		$post =Post::join('post_language','post.id','=','post_language.post_id')
					->where('post_language.language_id',get_id_locale(Session()->get('locale')))
					->where('post_language.title','like', '%'. $keyword .'%')
					->select('post_language.title','post.image','post_language.slug')
					->get();
		// $countPost=$post->count();
		
		return view('pages.search',[
			'listPost' => $post,
			// 'count'=>$countPost,
			'key'=>$keyword,
			'result'=>true,
		]);
    }



}