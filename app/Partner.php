<?php



namespace App;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Partner extends Model {



    //

    public function getAdminListPartner() {

        return DB::table("partner")->get();

    }

    

    public function getPartnerList()

    {

        return DB::table("partner")->orderBy('orderby', 'desc')->get();

    }



    public function delPartner($id) {

        return DB::table('partner')->whereId($id)->delete();

    }



    public function getListId() {

        return DB::table('partner')->pluck('id');

    }



    public function view($id) {

        return DB::table('partner')->whereId($id)->first();

    }



    public function updatePartner($id, $title, $message, $position, $image, $order, $updated_at) {
        return DB::table('partner')
                ->where('id', $id)
                ->update([
                    'title' => $title,
                    'message' => $message,
                    'position' => $position,
                    'image' => $image,
                    'orderby' => $order,
                    'updated_at' => $updated_at
                ]);
    }



    public function addPartner($title, $message, $position, $image, $order, $created_at) {
        return DB::table('partner')->insertGetId([
            'title' => $title,
            'message' => $message,
            'position' => $position,
            'image' => $image,
            'orderby' => $order,
            'created_at' => $created_at,
            'updated_at' => $created_at
        ]);

    }



}

