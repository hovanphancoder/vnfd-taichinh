<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    //
    protected $table='province';
    protected $fillable= ['name', '_code'];

	public function district(){
		return $this->hasMany('App\District');
	}

	public function getProvince(){
		return DB::table('province')
				->select('id', 'name')
				->get();
	}

}
