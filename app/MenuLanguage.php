<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuLanguage extends Model
{
    //
    protected $table = 'menu_language';
    protected $primaryKey = 'id';
    protected $fillable = ['menu_id','language_id','title', 'link', 'created_at', 'updated_at'];

}