<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageLanguage extends Model {

    //
    protected $table = 'page_language';
	protected $fillable=['page_id','language_id','title','slug','description','content','created_at', 'updated_at'];

    
   
}
