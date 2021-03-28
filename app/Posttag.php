<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posttag extends Model
{
    //
    protected $table = 'posttag';
    protected $guarded = [];
    protected $fillable = ['id', 'name', 'slug', 'description', 'image', 'created_at', 'updated_at'];


    public function singleTag($tag_slug, $data = []){
    	return DB::table('posttag')->get($data)->where('slug','=',$tag_slug)->first();
    }
}
