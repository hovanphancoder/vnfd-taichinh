<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SectionLanguage extends Model {

	//
	protected $table = 'section_language';
	protected $fillable=['section_id','name','title', 'description', 'video','link', 'language_id', 'image','setting','created_at','updated_at'];
	

}
