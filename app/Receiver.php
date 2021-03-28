<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Receiver extends Model {

	//
	protected $table = "receiver";
    protected $fillable = ['customer_id', 'name', 'phone', 'address', 'province', 'district', 'ward', 'created_at', 'updated_at'];

    public function customer_orther_address(){
    	return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function update_receiver($id, $data){
    	return DB::table('receiver')
                        ->where('id', $id)
                        ->update($data);
    }

    public function insert_receiver($data){
    	return DB::table('receiver')->insertGetId($data);
    }

    public function current_receiver($customer_id){
    	return DB::table('receiver')
    	->where('customer_id','=',$customer_id)
    	->where('active', 1)
    	->select('id')
    	->first();
    }

}
