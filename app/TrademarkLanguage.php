<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrademarkLanguage extends Model
{
    //
    protected $table='trademark_language';
    protected $fillable=['trademark_id','language_id','name','description'];
    public $timestamps=false;
}
