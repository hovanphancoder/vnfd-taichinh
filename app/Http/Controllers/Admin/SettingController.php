<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Setting;
use Illuminate\Support\Facades\Session;

class SettingController extends AppController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    
    public function __construct(Setting $setting) {
        $this->setting = $setting;
        $this->defaultimage = "defaultimage.jpg";
    }
    public function index() {
        //

    }

    public function configMail() {
        $setting = new Setting();
        return view('admin/setting/mail', [
            'mail' => $setting->setMail()
        ]);
    }

    public function setMail(Request $request) {
        $rules = [
            'name' => 'required|max:255',
            'from' => 'required|max:255',
            'title' => 'required|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $name = $request->input('name');
        $title = $request->input('title');
        $from = $request->input('from');
        $cc = $request->input('cc');
        $setting = new Setting();
        $setting->updateMail($name, $title, $from, $cc);
        Session::flash('status', 'Cập nhật thành công');
        return redirect('admin/setting/mail');
    }
    
    public function setAds()
    {
        $ads = new Setting();
        return view('admin/tracking/advertising',[
            'ads' => $ads->getAds()
        ]);
    }
    
    public function setAdvertising(Request $request)
    {
        $rules = [
            'name' => 'required|max:255'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        
        $name = $request->input('name');
        $code = $request->input('code');
        $ads = new Setting();
        $ads->setAdvertising($name, $code);
        Session::flash('status', 'Cập nhật thành công');
        return redirect('admin/setting/advertising');
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
    public function frontend() {
        // 
        
        return view('admin/setting/frontend',[
            'currency' => $this->setting->getSetting(6),
            'social' => $this->setting->getSetting(3),
            'header' => $this->setting->getSetting(4),
            'footer' => $this->setting->getSettingFooter('footer')
        ]);
    }
    
    public function setSocial(Request $request){
        if(!$request->isMethod('POST') || !$request->isMethod('post')){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        $result_social = $this->setting->updateSocial(3, $request->input('link_facebook'), $request->input('link_youtube'), $request->input('link_googleplus'), $request->input('link_twitter'), $request->input('link_linkedin'), $request->input('link_instagram'), $request->input('link_skype'), $request->input('link_whatsapp'));
        if(!$result_social){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        Session::flash('status', 'Success');
        return redirect('admin/setting/frontend');
    }
    
    public function setHeader(Request $request){
        if(!$request->isMethod('POST') || !$request->isMethod('post')){
            Session::flash('status', 'Error! Please, try agai');
            return redirect('admin/setting/frontend');
        }
        if ($request->hasFile('logo')) {
            $logo = time() . "-" . $request->file('logo')->getClientOriginalName();
            $destinationPath = public_path() . '/images/upload';
            $request->file('logo')->move($destinationPath, $logo);
        } else {
            $logo = $request->input('old_logo');
        }
        $result_header = $this->setting->updateHeader(4, $logo, $request->input('hotline'), $request->input('email'));
        if(!$result_header){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        Session::flash('status', 'Success');
        return redirect('admin/setting/frontend');
    }
    
    public function setFooter(Request $request){
        if(!$request->isMethod('POST') || !$request->isMethod('post')){
            Session::flash('status', 'Error! Please, try again 1');
            return redirect('admin/setting/frontend');
        }
		//bo sung language
		
		$language=[];
		foreach($request->all() as $k=>$v){
			if(strpos($k,'language')!==false){
				$str=explode('-', $k);
				$language[$str[1]][$str[2]]=$v;
			}
		}
		if($language){
			foreach($language as $lang_id=>$item){
				$item['language_id'] = $lang_id;
				$result_footer = $this->setting->updateFooterLanguage(5, $item['copyright'], $item['development'], $item['phone'], $item['address'], $item['link'],$lang_id);
			}
			Session::flash('status', 'Cập nhật bài viết thành công.');
	   }
        
        if(!$result_footer){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        Session::flash('status', 'Success');
        return redirect('admin/setting/frontend');
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
	public function setCurrency(Request $request){
        if(!$request->isMethod('POST') || !$request->isMethod('post')){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        $result_currency = $this->setting->updateCurrency(6, $request->input('currency'));
        if(!$result_currency){
            Session::flash('status', 'Error! Please, try again');
            return redirect('admin/setting/frontend');
        }
        Session::flash('status', 'Success');
        return redirect('admin/setting/frontend');
    }
}
