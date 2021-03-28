<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OptionValue extends Model
{
    protected $table = "option_value";
    protected $fillable = ['option_id', 'image', 'sort_order', 'name'];


	public function option(){
    	return $this->belongsTo('App\Option','option_id','id');
    }

    public function getOption($id){
        // dd($id);
        // DB::connection()->enableQueryLog();
    	$query = DB::table('option_value');
    	$query->join('option_value_language','option_value_language.option_value_id','=','option_value.id');
    	$query->where('option_value_language.option_id','=',$id);
    	$query->where('option_value_language.language_id','=',get_id_locale());
    	$query->select('option_value_language.option_value_id','option_value_language.option_id','option_value_language.name', 'option_value.image');
        // $query->groupby('option_value_language.option_value_id');
    	// $query->get();
     //    $queries = DB::getQueryLog();
     //  dd(end($queries));

    	return $query->get();
    }

}
