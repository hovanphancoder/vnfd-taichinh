<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consultant extends Model {

    //
    protected $table = "consultant";
    protected $fillable = ['name', 'email', 'phone', 'phong_cach', 'huong_nha', 'dia_diem', 'nhu_cau', 'the_loai', 'address', 'acreage', 'so_tang', 'so_phong', 'ngan_sach', 'mau_sac', 'track_id', 'message', 'page', 'url', 'image', 'created_at', 'updated_at'];

    public function addItem($name, $phone, $course, $created_at) {
        return DB::table('consultant')
                        ->insert([
                            'name' => $name,
                            'email' => '',
                            'phone' => $phone,
                            'message' => '',
                            'page' => $course,
                            'url' => '',
                            'created_at' => $created_at
        ]);
    }
    public function consultantList() {
        return DB::table('consultant')->orderby('created_at', 'desc')->get();
    }
    
    public function getConsultant($id) {
        return DB::table('consultant')->whereId($id)->first();
    }
    public function getListId()
    {
        return DB::table('consultant')->lists('id');
    }
    public function delConsultant($id) {

        return DB::table('consultant')->where('id', $id)->delete();

    }

    public function consultant($name, $email, $phone, $message, $page, $url, $created_at) {
        return DB::table('consultant')
                        ->insert([
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'message' => $message,
                            'page' => $page,
                            'url' => $url,
                            'created_at' => $created_at
        ]);
    }

}
