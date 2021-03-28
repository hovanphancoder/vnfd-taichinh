<?php namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Categorymenu extends Model {

	//
	protected $table = 'categorymenu';
    protected $fillable = ['title_vn','title_en','id_catemenu','created_at','updated_at'];

}
