<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectType extends Model {

	//
	protected $table = "project_type";
    protected $fillable = ['id_project_type', 'name', 'slug', 'description', 'language_id', 'created_at', 'updated_at'];

    public function getList(){
    	return DB::table('project_type')->orderby('created_at','desc')->where('language_id', get_id_locale())->get();
    }

}
