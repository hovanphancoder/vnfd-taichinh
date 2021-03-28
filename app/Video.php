<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model {
    protected $table = "video";
    protected $fillable = ['name', 'description', 'embed', 'path', 'image', 'created_at', 'updated_at'];

    public function listItem($limit){
        return DB::table("video")->orderBy('created_at', 'desc')->limit($limit)->get();
    }


}

