<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostLanguage extends Model {

    //
    protected $table = 'post_language';
	protected $fillable=['post_id','language_id','title','slug','description','content','post_status','created_at', 'updated_at'];

    
   
}