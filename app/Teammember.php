<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teammember extends Model {

	//
    public function getListTeam()
    {
        $team = DB::table('teammember')->orderBy('created_at', 'desc')->take(4)->get();
        return $team;
    }

}
