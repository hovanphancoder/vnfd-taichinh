<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class District extends Model
{
    //
    protected $table = 'district';
    protected $fillable = ['name','_prefix', 'province_id'];
    public $timestamps = false;
    public function province(){
        return $this->belongsTo('App\Province');
    }
    public function ward(){
        return $this->hasMany('App\Ward');
    }

    public function getDistrict($province_id = 0){
        return DB::table('district')
        ->where('province_id', $province_id)
        ->select('id', 'name', 'province_id')
        ->get();
    }

}
