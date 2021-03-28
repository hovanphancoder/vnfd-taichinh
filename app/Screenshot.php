<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Screenshot extends Model {



    //

    public function getAdminListScreenshot() {

        return DB::table("screenshot")->get();

    }

    

    public function getHomeList()

    {

        return DB::table("screenshot")->orderBy('orderby', 'desc')->get();

    }



    public function delScreen($id) {

        return DB::table('screenshot')->where('id', $id)->delete();

    }



    public function getListId() {

        return DB::table('screenshot')->lists('id');

    }



    public function viewScreen($id) {

        return DB::table('screenshot')->whereId($id)->first();

    }



    public function updateScreen($id, $image, $order, $updated_at) {

        return DB::table('screenshot')

                        ->where('id', $id)

                        ->update([

                            'image' => $image,

                            'orderby' => $order,

                            'updated_at' => $updated_at

        ]);

    }



    public function addScreen($image, $order, $created_at) {

        return DB::table('screenshot')->insertGetId([

            'image' => $image,

            'orderby' => $order,

            'created_at' => $created_at

        ]);

    }



}

