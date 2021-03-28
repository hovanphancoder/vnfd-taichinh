<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Section;

use Session;
use App\SectionLanguage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;



class SectionController extends AppController {



    /**

     * Display a listing of the resource.

     *

     * @return Response

     */

    public function __construct(Section $section) {

        $this->section = $section;

    }



    public function index() {

        //

        return view('admin/section/list', [

            'sectionlist' => $this->section->getListSection()

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
        $item = Section::find($id);
        if(!$item){
            return redirect()->back()->with(['result', 'Error! Section is not exists.']);
        }

        $view = Section::join('section_language','section_language.section_id','=','section.id')->where('section.id',$id)->select('*','section.id as section_id')->get()->toArray();

        return view('admin/section/view', [

            // 'viewsection' => $this->section->viewSection($id)
            'view' => $view

        ]);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return Response

     */

    public function edit(Request $request, $id) {
        if (!$request->isMethod("POST") || !$request->isMethod("post")) {
            Session::flash('status', 'Error!');
            return redirect("admin/section/list");
        }


        // kiem tra id co ton tai trong table post

        $item = Section::find($id);
        if(!$item){
            return redirect()->back()->with('result','Error! Section is not exists.');
        }

        $language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }

        if ($request->hasFile('language-1-image')) {
            $image1 = time() . "-" . $request->file('language-1-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/section';
            $request->file('language-1-image')->move($destinationPath, $image1);
        } else {
            $image1 = $request->input('language-1-url');
        }
        if ($request->hasFile('language-2-image')) {
            $image2 = time() . "-" . $request->file('language-2-image')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload/section';
            $request->file('language-2-image')->move($destinationPath, $image2);
        } else {
            $image2 = $request->input('language-2-url');
        }

        $viewItem = Section::find($id);
        // dd($viewItem->toArray());
        $viewItem->name = $request->input('language-1-name');
        $viewItem->title = $request->input('language-1-title');
        $viewItem->description = $request->input('language-1-description');
        $viewItem->link = $request->input('language-1-link');
        $viewItem->video = $request->input('language-1-video');
        $viewItem->setting = $request->input('language-1-setting');
        $viewItem->image = $image1;
        $viewItem->updated_at = date("Y-m-d H:i:s");;
        $viewItem->save();
        if ($viewItem) {
            Session::flash('status', 'Success!');
            //save table: category language
            // dd($language);
            if($language){
                SectionLanguage::where('section_id',$id)->delete();
                foreach($language as $lang_id=>$item){
                    $item['language_id'] = $lang_id;
                    $item['section_id'] = $id;
                    if($lang_id == 1) $image = $image1;
                    if($lang_id == 2) $image = $image2;
                    $item['image'] = $image;
                    SectionLanguage::create($item);
                }
           }
            Session::flash('status', 'Update Section success!');
            return redirect('admin/section/view/' . $id);
        } else {
            Session::flash('status', 'Failed, try again!');
            return redirect()->back();
        }
        Session::flash('status', 'Update Section success!');
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

    }



    public function viewService($id) {

        $section = new Section();

        return $section->viewService($id);

    }



}

