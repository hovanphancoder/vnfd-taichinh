<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model {

    //
    public function getUser($id) {
        return DB::table('users')->whereId($id)->first();
    }
    
    public function getUserAdmin() {
        return DB::table('users')->whereId(1)->first();
    }

    public function setUserAdmin($name, $email, $password, $image) {
        if (empty($password)) {
            $updateuser = DB::table('users')
                    ->where('id', 1)
                    ->update([
                'name' => $name,
                'email' => $email,
                'image' => $image
            ]);
        } else {
            $updateuser = DB::table('users')
                    ->where('id', 1)
                    ->update([
                'name' => $name,
                'email' => $email,
                'image' => $image,
                'password' => $password
            ]);
        }
        return $updateuser;
    }
    
    public function getListUser(){
        return DB::table('users')->orderby('created_at', 'desc')->get();
    }
    
    public function getUserGroup($id){
        return DB::table('users')->where('group_id',$id)->lists('group_id');
    }
    
    public function setUser($id, $name, $email, $password, $image, $phone, $group_id, $updated_at) {
        if (empty($password)) {
            $updateuser = DB::table('users')
                    ->where('id', $id)
                    ->update([
                'name' => $name,
                'email' => $email,
                'image' => $image,
                'phone' => $phone,
                'group_id' => $group_id,
                'updated_at' => $updated_at
            ]);
        } else {
            $updateuser = DB::table('users')
                    ->where('id', $id)
                    ->update([
                'name' => $name,
                'email' => $email,
                'image' => $image,
                'phone' => $phone,
                'password' => $password,
                'group_id' => $group_id,
                'updated_at' => $updated_at
            ]);
        }
        return $updateuser;
    }
    
    public function addUser($name, $email, $password, $image, $phone, $group_id, $created_at) {
        return DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'image' => $image,
                'phone' => $phone,
                'password' => $password,
                'group_id' => $group_id,
                'created_at' => $created_at
        ]);
    }
    
    public function delUser($id){
        return DB::table('users')->where('id', $id)->delete();
    }

    public static function getUserCustomer($id){
        return DB::table('users')->where('customer_id', $id)->first();
    }

    public function updateUser($id, $data){
        $sql = DB::table('users')
                    ->where('id', $id)
                    ->update($data);
        return $sql;
    }
            

}
