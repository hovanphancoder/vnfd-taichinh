<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "option";
    protected $fillable = ['type', 'sort_order', 'name'];

    public function optionValue(){
    	return $this->hasMany('App\OptionValue','option_id','id');
    }
	
	
}
