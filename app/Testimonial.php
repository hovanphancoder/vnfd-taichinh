<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Testimonial extends Model {

	//
    public function getListPartner()
    {
        $partner = DB::table('testimonial')->orderBy('created_at', 'desc')->take(10)->get();
        return $partner;
    }
    
    public function getListAvatar()
    {
        $avatar = DB::table('testimonial')->select('avatar')->orderBy('created_at', 'desc')->take(10)->get();
        return $avatar;
    }

}
