<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionLanguage extends Model
{
    protected $table = "option_language";
    protected $fillable = ['option_id', 'language_id', 'name'];

 
}
