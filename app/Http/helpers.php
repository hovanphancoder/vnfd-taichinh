<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Custom helper
function detect(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    return true;
  }
  return false;
}
function formatInline($str){
  $str = preg_replace( "/\r|\n/", "", $str );
  return $str;
}
function generateBarcodeNumber() {
	$number = mt_rand(1, 9999); 
	// otherwise, it's valid and can be used
	return uniqid($number, true).'387';
}
function goGenID(){
  return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
}
function pathFilemanger() {
    $pathtinymce = url('admin_assets/filemanager/').'/';
    return $pathtinymce;
}

function removeDau($str) {
    $str = str_replace('.', '', $str);
    $str = str_replace('"', '', $str);
    $str = trim($str);
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        '' => '"|:|;|@|#|%|&|,|\?|\!|\$|\^|\*'
    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
//        $str = preg_replace("/[^_a-zA-Z0-9 -] /", "",$str);
    }
    $str = str_replace(' ', '-', $str);
    return strtolower($str);
}
function convert_lang($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    // $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
    return $str;
}
function convert_url($str){
    $str=convert_lang($str);
    $str=strtolower($str);
    $str=preg_replace('/\s/','_', $str);
    $str=str_replace('/', '_', $str);
    $str=str_replace('+', '', $str);
    $str=str_replace(',', '_', $str);
    $str=str_replace('-', '_', $str);
    $str=str_replace('.', '_', $str);
    $str=str_replace('(', '_', $str);
    $str=str_replace(')', '_', $str);
    $str=str_replace('[', '_', $str);
    $str=str_replace(']', '_', $str);
    $str=str_replace(':', '_', $str);
    $str=str_replace('&', '_', $str);
    $str=str_replace('?', '_', $str);
    $str=str_replace('"', '_', $str);
    $str=str_replace('___', '_', $str);
    $str=str_replace('__', '_', $str);
    $str=str_replace('_', '-', $str);
    if(substr($str,0,1)=='-'){
        $str=substr($str,1);
    }
    if(substr($str,-1,1)=='-'){
        $str=substr($str,0,-1);
    }
    return $str;
}
function get_id_locale($code=''){
  $locales=config('app.locales');
  if(!$code){
    $code=App::getLocale();
  }
  foreach($locales as $k=>$item){
    if($item==$code){
      return $k;
    }
  }
  return 1;
}
function merge_field(&$data,$field,$select=[],$model=''){
  
  if(isset($data->id)){
    $relationship = $data->$field;
    if(isset($relationship->id)){
      if($relationship->getFillable()){
                $fillable=$relationship->getFillable();
            }
            else{
                 $fillable=$model->getFillable();
            }
            foreach($fillable as $value){
              if($select){
                if(in_array($value, $select)){
                  $data->$value=$relationship->$value;
                }
              }
              else{
                $data->$value=$relationship->$value;
              }

                
            }
    }
    else{
      foreach($relationship as $item){
              if($item->getFillable()){
                  $fillable=$item->getFillable();
              }
              else{
                   $fillable=$model->getFillable();
              }
              foreach($fillable as $value){
                  $data->$value=$item->$value;
              }
             
          }
    }
    
  }
  else {
    
      foreach($data as $k=>$dt){
          if($dt->$field){
            $relationship = $dt->$field;
        if(isset($relationship->id)){

          if($relationship->getFillable()){
                      $fillable=$relationship->getFillable();
                  }
                  else{
                       $fillable=$model->getFillable();
                  }
                  foreach($fillable as $value){
                    if($select){
                      if(in_array($value, $select)){
                        $data[$k]->$value=$relationship->$value;
                      }
                    }
                    else{
                      $data[$k]->$value=$relationship->$value;
                    }

                      
                  }
        }
        else{
          foreach($relationship as $item){
                    if($item->getFillable()){
                        $fillable=$item->getFillable();
                    }
                    else{
                         $fillable=$model->getFillable();
                    }
                    foreach($fillable as $value){
                    
                      if($select){
                        if(in_array($value, $select)){
                          $data[$k]->$value=$item->$value;
                        }
                      }
                      else{
                        $data[$k]->$value=$item->$value;
                      }

                        
                    }
                   
                }
        }
              
          }
      }
  }

}
// function cate_tree($array, $parent=0) { 
    // if(count($array) > 0)print "<ul class='categories_mega_menu'>";
    // foreach ($array as $row) {	
        // if ($row->parent_id == $parent) {
			// if($parent==0)$pa = 'menu_item_children'; else $pa = 'sub_menu_item_children';
            // print "<li class='".$pa."'><a href='#'>$row->name<i class='fa fa-angle-right'></i></a>";
            // cate_tree($array, $row->cate_id);  # recurse
            // print "</li>";
    // }   }
    // if(count($array) > 0)print "</ul>";
// }