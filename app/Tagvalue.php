<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tagvalue extends Model
{
    //
    protected $table = 'vagvalue';
    protected $guarded = [];
    protected $fillable = ['id', 'id_post', 'id_tag', 'created_at', 'updated_at'];
}
