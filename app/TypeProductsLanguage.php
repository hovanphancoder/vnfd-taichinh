<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeProductsLanguage extends Model
{
    //
    protected $table='type_products_language';
    protected $fillable=['id_type','language_id','name','slug','description'];
    public $timestamps=false;
}
