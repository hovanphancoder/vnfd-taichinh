<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategorypostLanguage extends Model {

    //


    protected $table = 'categorypost_language';
    protected $fillable=['categorypost_id','language_id','title','slug','description','created_at','updated_at'];
}
