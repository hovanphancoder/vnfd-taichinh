<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model {

    //
    public function listGallery() {
        $listgallery = DB::table('gallery')->orderby('orderby', 'asc')->get();
        return $listgallery;
    }
    
    public function getItem($id) {
        return DB::table("gallery")->whereId($id)->first();
    }
    
    public function addItem($title, $description, $content, $image, $created_at) {
        return DB::table('gallery')
                        ->insertGetId([
                            'title' => $title,
                            'description' => $description,
                            'content' => $content,
                            'image' => $image,
                            'created_at' => $created_at
        ]);
    }

    public function viewGallery($id) {
        return DB::table("gallery")->whereId($id)->first();
    }

    public function updateItem($id, $title, $description, $content, $image, $updated_at) {
        return DB::table('gallery')
                        ->where('id', $id)
                        ->update([
                            'title' => $title,
                            'description' => $description,
                            'content' => $content,
                            'image' => $image,
                            'updated_at' => $updated_at
        ]);
    }
    
    public function getListId() {
        return DB::table('gallery')->lists('id');
    }
    
    public function delItem($id) {
        return DB::table('gallery')->where('id', $id)->delete();
    }
    
    /* Front End*/
    
    public function listGalleryFE($limit) {
        $listgallery = DB::table('gallery')
                ->orderby('orderby', 'asc')
                ->limit($limit)
                ->get();
        return $listgallery;
    }

}
