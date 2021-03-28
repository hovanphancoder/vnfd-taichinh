<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Newsletter extends Model {

    //
    protected $table = 'newsletter';
    protected $fillable = ['email','updated_at','created_at'];

    public function add($name, $email, $subject, $message, $currentdate) {
        return DB::table('newsletter')->insert([
                    'fullname' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                    'created_at' => $currentdate
        ]);
    }
    
    public function createForm($email, $currentdate){
        return DB::table('newsletter')->insert([
                    'email' => $email,
                    'created_at' => $currentdate,
                    'updated_at'=>$currentdate
        ]);
    }

    public function checkEmail($email){
        return DB::table('newsletter')->where('email',$email)->first();
    }

    public function getList() {
        return DB::table('newsletter')->orderby('created_at', 'desc')->get();
    }

    public function delContact($id) {
        return DB::table('newsletter')->where('id', $id)->delete();
    }

    public function countContactCurrent() {
        return DB::table('newsletter')
                        ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as currentdate'))
                        ->lists('currentdate');
//                ->toSql()
    }

    public function getContact($id) {
        return DB::table('newsletter')->whereId($id)->first();
    }
    
    public function getListId()
    {
        return DB::table('newsletter')->lists('id');
    }

}