<?php
  
namespace App\Traits;

use App\Customer;
use App\Province;
use App\Ward;
use App\District;
use Illuminate\Http\Request;
  
trait LocateTrait {
  
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function goCity() {
    	$city = Province::OrderBy('name','desc')->get()->toArray();
    	return $city;
    }

    public function goDistrict($province_id) {
        $district = District::where('province_id', $province_id)->OrderBy('name','desc')->get()->toArray();
        return $district;
    }

    public function goWard($city_id) {
    	$ward = Ward::where('name','desc')->get()->toArray();
    	return $ward;
    }

    public function goCustomer() {
    	$customer = Customer::OrderBy('name','desc')->get()->toArray();
    	return $customer;
    }
  
}