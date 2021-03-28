<?php
$data=App\Language::where('language_group_id',1)->get();
		
if($data){
	foreach($data as $item){
		$lang[$item->lang_key]=$item->lang_vi;
	}
}

return $lang;