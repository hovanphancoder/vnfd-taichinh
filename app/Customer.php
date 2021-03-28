<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model {
    //
    protected $table = "customer";
    protected $fillable = ['name', 'email', 'phone', 'address', 'ward' , 'district', 'city', 'customer_code', 'customer_type','company','mst','password', 'remember_token', 'app_code', 'app_name_en', 'app_name_vi', 'tel', 'fax', 'contact', 'position', 'comment', 'image'];
    
    public function orders(){
    	return $this->hasMany('App\Orders','customer_id','id');
    }

    public function customer_list_address(){
        return $this->hasMany('App\Receiver','customer_id','id');
    }
    
    
    
    public function product_type(){
    	return $this->belongsTo('App\ProductType','id_type','id');
    }

    public function bill_detail(){
    	return $this->hasMany('App\BillDetail','id_product','id');
    }
    
    public function getAdminListCustomer() {
        return DB::table("customer")->orderBy('created_at','DESC')->get();
    }

    

    public function getHomeList()
    {
        return DB::table("customer")->orderBy('orderby', 'desc')->get();
    }



    public function delCustomer($id) {
        return DB::table('customer')->whereId($id)->delete();
    }

    
    public function listCustomer() {
        return DB::table("customer")->orderBy('created_at','DESC')->get();
    }



    public function viewCustomer($id) {
        return DB::table('customer')->whereId($id)->first();
    }



    public function updateCustomer($id, $data) {
        return DB::table('customer')
                        ->where('id', $id)
                        ->update($data);
    }



    public function addCustomer($name, $position, $comment, $image, $created_at) {
        return DB::table('customer')->insertGetId([
            'name' => $name,
            'position' => $position,
            'comment' => $comment,
            'image' => $image,
            'created_at' => $created_at
        ]);
    }

    public function getCustomer($id, $data){
        return DB::table('customer')
                ->whereId($id)
                ->select($data)
                ->first();
    }

    public function getCustomerLocate($province_id, $district_id){
        return DB::table('customer as c')
                ->join('province as p', 'p.id', '=', 'c.city')
                ->join('district as d', 'd.id', '=', 'c.district')
                ->select('p.name as province_name','d.name as district_name','d._prefix')
                ->first();
    }

    public function filter($customer_type = "") {
        $result = DB::table("customer");
        $result->join('district','customer.district','=','district.id');
        $result->join('province','customer.city','=','province.id');
        if($customer_type > 0){
            $result->where(function($query) use ($customer_type){
                    $query->where('customer_type', $customer_type);
            });
        }
        $result->select('customer.customer_code','customer.email','customer.phone','customer.name','customer.address','district.name as district_name','province.name as province_name');
        $result->orderBy('name','desc');
        return $result->get();
    }

}

