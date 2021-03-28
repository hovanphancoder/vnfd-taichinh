<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model {

    protected $table = "contact";
    protected $fillable = ['firstname','lastname','fullname','company', 'email', 'phone', 'address', 'subject', 'message'];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public function add($name, $email, $phone, $address = "", $company = "", $subject = "", $message, $currentdate) {
        return DB::table('contact')->insert([
                    'fullname' => $name,
                    'email' => $email,
                    'company' => $company,
                    'phone' => $phone,
                    'subject' => $subject,
                    'address' => $address,
                    'message' => $message,
                    'created_at' => $currentdate,
                    'updated_at' => $currentdate
        ]);
    }

    public function contactList() {
        return DB::table('contact')->orderby('created_at', 'desc')->get();
    }

    public function delContact($id) {
        return DB::table('contact')->where('id', $id)->delete();
    }

    public function countContactCurrent() {
        return DB::table('contact')
                        ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as currentdate'))
                        ->pluck('currentdate');
//                ->toSql()
    }

    public function getContact($id) {
        return DB::table('contact')->whereId($id)->first();
    }
    
    public function getListId()
    {
        return DB::table('contact')->pluck('id');
    }

    public function doUpdate($id, $fullname, $email, $subject, $message, $updated_at) {
        return DB::table('contact')
                        ->where('id', $id)
                        ->update([
                            'fullname' => $fullname,
                            'email' => $email,
                            'subject' => $subject,
                            'message' => $message,
                            'updated_at' => $updated_at
        ]);
    }

}
