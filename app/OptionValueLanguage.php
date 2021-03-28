<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValueLanguage extends Model
{
    protected $table = "option_value_language";
    protected $fillable = ['option_value_id','option_id', 'language_id', 'name'];

 
}
