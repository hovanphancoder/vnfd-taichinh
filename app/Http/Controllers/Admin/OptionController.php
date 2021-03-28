<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Products;
use App\ProductType;
use App\ProductOption;
use App\Trademark;
use App\OrderDetail;
use App\Option;
use App\OptionValue;
use App\OptionLanguage;
use App\OptionValueLanguage;
use Session;
use Illuminate\Http\Request;

class OptionController extends Controller {

	protected $model;
    public function __construct() {
        $this->model=new ProductType();
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        //
		$listOptions = Option::orderBy('id', 'desc')->get();
		
        return view('admin.option.list')->with('listOptions',$listOptions);
    }
	public function addOption() {
		$data['title'] = 'Add product option';
		$data['action'] = action('Admin\OptionController@doAddOption');
		$data['type'] = '';
		$data['name'] = '';
		$data['option_values'] = '';
		$data['btnsave'] = 'Save';
        return view('admin.option.form')->with($data);
    }
	public function viewOption($id) {
		$data['title'] = 'Edit product option';
		$data['action'] = action('Admin\OptionController@editOption',['id' => $id]);
		$getOption = Option::find($id);
		if (!empty($getOption)) {
			$data['type'] = $getOption->type;
			$data['name'] = $getOption->name;
		} else {
			$data['type'] = '';
			$data['name'] = '';
		}
		$getOptionLanguage = OptionLanguage::where('option_id',$id)->get();
		$itemoptionlang = array();
		foreach ($getOptionLanguage as $result) {
			$itemoptionlang[$result['language_id']] = array('name' => $result['name']);
		}
		$data['name'] = $itemoptionlang;
		
		$getOptionValue = OptionValue::where('option_id',$id)->orderBy('id', 'desc')->get();
		
		$itemoptionvaluelang = array();
		$option_value_data = array();
		if(isset($getOptionValue)){
			foreach ($getOptionValue as $result) {
				$getOptionNalueLanguage = OptionValueLanguage::where('option_value_id',$result['id'])->get();
				foreach ($getOptionNalueLanguage as $item) {
					$itemoptionvaluelang[$item['language_id']] = array('name' => $item['name']);
				}
				$option_value_data[] = array(
					'option_value_language'          => $itemoptionvaluelang,
					'option_value_id'          => $result['id'],
					'image'                    => $result['image'],
					'sort_order'               => $result['sort_order']
				);
			}
		}
		$data['option_values'] = $option_value_data;
		$data['value_name'] = $itemoptionvaluelang;//echo '<pre>';print_r($option_value_data);exit();
		$data['btnsave'] = 'Update';
        return view('admin.option.form')->with($data);
    }
	public function doAddOption(Request $request){
        if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		//bo sung language
		foreach(config('app.locales') as $key=>$code){
            $rules['language-'.$key.'-name']= 'required';
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
        $input = array();
       
        $input["name"] = $request->input('language-1-name');
        $input["type"] = $request->input('type');
        $input["sort_order"] = 0;
        $result = Option::create($input);
		if ($result['id']) {
			
			$data = $request->all();
			
			if (isset($data['option_value'])) {
				foreach ($data['option_value'] as $key =>$option_value) {
					
					$input_image = $option_value['image'];
					if ($input_image) {
						$image[$key] = time() . "-" . $input_image->getClientOriginalName();
						$destinationPath = public_path() . '/images/upload/product';
						$input_image->move($destinationPath, $image[$key]);
					} else {
						$image[$key] = "default.png";
					}
					$optionvalue = OptionValue::create(['option_id' => $result['id'],'image' => $image[$key],'sort_order' => 0,'name' => $option_value['option_value_language'][1]['name']]);

					foreach ($option_value['option_value_language'] as $language_id => $option_value_language) {
						
						$item['language_id'] = $language_id;
						$item['option_id'] = $result['id'];
						$item['option_value_id'] = $optionvalue['id'];
						$item['name'] = $option_value_language['name'];
						OptionValueLanguage::create($item);
					}
				}
			}
		}
        if ($result) {
            Session::flash('status', 'Success: You have modified options!');
			//save table: option language
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['option_id'] = $result['id'];
					OptionLanguage::create($item);
				}
		   }
            return redirect('admin/product/option/' . $result['id']);
        } else {
            Session::flash('status', 'Failed!');
            return redirect()->back();
        }
    }
	public function editOption(Request $request, $id) {
		$viewItem = Option::find($id);
		if (!$request->isMethod('POST') || !$request->isMethod('post')) {
            Session::flash('status', 'Error! Try agains');
            return redirect()->back();
        }
		$rules = [];
		//bo sung language
		if(config('app.locales') !=''){
			foreach(config('app.locales') as $key=>$code){
				$rules['language-'.$key.'-name']= 'required';
			}
        }
		$this->validate($request,$rules);
		$language=[];
        foreach($request->all() as $k=>$v){
            if(strpos($k,'language')!==false){
                $str=explode('-', $k);
                $language[$str[1]][$str[2]]=$v;
            }
        }
		$viewItem->name = $request->input('language-1-name');
		$viewItem->type = $request->input('type');
		$viewItem->save();
		
		if ($id) {
			$data = $request->all();
			
			if (isset($data['option_value']) && $request->isMethod('POST')) {
				OptionValue::where('option_id',$id)->delete(); //update lại, ko xoá
				//xoá option value language cũ, ghi lại
				OptionValueLanguage::where('option_id',$id)->delete();
				foreach ($data['option_value'] as $key =>$option_value) {
					
					$input_option_value_oldimage = $option_value['imageold'];
					$input_image = $option_value['image'];
					if (isset($input_image)) {
						$image[$key] = time() . "-" . $input_image->getClientOriginalName();
						$destinationPath = public_path() . '/images/upload/product';
						$input_image->move($destinationPath, $image[$key]);
					}elseif($input_option_value_oldimage !=0){
						$image[$key] = $input_option_value_oldimage;
					} else {
						$image[$key] = "default.png";
					}//print_r($image[$key]);exit('themn');
					
					
					$optionvalue = OptionValue::create(['option_id' => $id,'image' => $image[$key],'sort_order' => 0,'name' => $option_value['option_value_language'][1]['name']]);
					// đổi thành update
					// $optionvalue = OptionValue::find($option_value['option_value_id']);
					// $optionvalue->image = $image[$key];
					// $optionvalue->sort_order = 0;
					// $optionvalue->name = $option_value['option_value_language'][1]['name'];
					// $optionvalue->save();
					
					foreach ($option_value['option_value_language'] as $language_id => $option_value_language) {
						
						$item['language_id'] = $language_id;
						$item['option_id'] = $id;
						$item['option_value_id'] = $optionvalue['id'];
						$item['name'] = $option_value_language['name'];
						OptionValueLanguage::create($item);
					}
				}
			}
		}
		if ($viewItem) {
            Session::flash('status', 'Success: You have modified options!');
			//save table: trademark language, xoá item cũ ghi lại
			OptionLanguage::where('option_id',$id)->delete();
			if($language){
				foreach($language as $lang_id=>$item){
					$item['language_id'] = $lang_id;
					$item['option_id'] = $id;
					OptionLanguage::create($item);
				}
		   }
        } else {
            Session::flash('status', 'Failed!');
        }
        return redirect()->back();
	}	
	public function destroyOption($id) {
        
        $viewItem = Option::find($id);
		$check = ProductOption::where('option_id',$id)->get();
		//print_r(count($check));exit('fdsb');
		if(count($check)==0)
			$result = $viewItem->delete(); 
        if (isset($result)) {
			OptionLanguage::where('option_id',$id)->delete();
			OptionValue::where('option_id',$id)->delete();
			OptionValueLanguage::where('option_id',$id)->delete();
            Session::flash('status', 'Success!');
        } else {
            Session::flash('status', 'Failed! This item can not delete');
        }
        return redirect()->back();
    }

}
