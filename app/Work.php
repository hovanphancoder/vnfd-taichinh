<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model {

	//
	protected $table = "work";
    protected $fillable = ['id_work','name','slug', 'description', 'language_id', 'created_at', 'updated_at'];

    public function getList(){
    	return DB::table('work')->orderby('created_at','desc')->where('language_id', get_id_locale())->get();
    }

}
