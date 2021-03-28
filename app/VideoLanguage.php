<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VideoLanguage extends Model {
    protected $table = "video_language";
    protected $fillable = ['video_id', 'name', 'description', 'embed', 'path', 'image', 'created_at', 'updated_at', 'language_id'];


}

