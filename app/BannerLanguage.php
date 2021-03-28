<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BannerLanguage extends Model
{
    //
    protected $table='banner_language';
    protected $fillable=['id_banner','language_id','title','label','description','link','image'];
    public $timestamps=false;

    
}
