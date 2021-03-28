<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    protected $table = "trademark";
    protected $fillable = ['name', 'description', 'image', 'created_at', 'updated_at'];

    public function product(){
    	return $this->hasMany('App\Products','id_trademark','id');
    }
	public function language()
	{
		return $this->hasMany('App\TrademarkLanguage','trademark_id','id');	    
	}
	public function currentLanguage()
	{
		return $this->hasMany('App\TrademarkLanguage','trademark_id','id')->where('language_id',get_id_locale());    
	}
	
}
