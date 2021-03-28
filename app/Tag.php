<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model {

    //
    public function listTag() {
        return DB::table('tag')->get();
    }

}
