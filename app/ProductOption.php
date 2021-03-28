<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductOption;
use App\ProductOptionValue;
use App\Option;
use App\OptionValue;
class ProductOption extends Model
{
    protected $table = "product_option";
    protected $fillable = ['product_id', 'option_id', 'value', 'required'];

    public function productOptionValue(){
    	return $this->hasMany('App\ProductOptionValue','product_option_id','id');
    }
	public static function getProductOptions($product_id){
		$product_option_data = array();
		
		$product_option_query = ProductOption::select('*','product_option.id as product_option_id')->join('option','option.id','=','product_option.option_id')->where('product_id',$product_id)->get();
		
		foreach ($product_option_query as $product_option) {
			$product_option_value_data = array();
			
			$product_option_value_query = ProductOptionValue::select('*','product_option_value.id as product_option_value_id')
											->join('option_value','option_value.id','=','product_option_value.option_value_id')
											->where('product_option_value.product_option_id','=',$product_option['product_option_id'])
											->get();
		
			foreach ($product_option_value_query as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'sku'                => $product_option_value['sku'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}
			// echo "<pre>";
			// print_r($product_option_data);
			// echo "</pre>";exit;
		return $product_option_data;
	}
	public function getOptionValues($option_id) {
		$option_value_data = array();
		$option_value_query = OptionValue::where('option_id',$option_id)->get();		

		foreach ($option_value_query as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}
			
		return $option_value_data;
	}
	public static function getoptionproduct($id) {
		$option = '';
		$json = array();
		if(isset($id)){
			$optionproduct = ProductOption::where('product_id',$id)->get()->toArray();
			
			if(isset($optionproduct) && count($optionproduct)>0){
				foreach($optionproduct as $result){
					$option_data = array();
					$th = new ProductOption();
					$product_options = $th->getProductOptions($result['product_id']);
					
					  foreach ($product_options as $product_option) {
						$option_info = Option::where('option.id',$product_option['option_id'])->first();;
						if (isset($option_info)) {
							$product_option_value_data = array();

							foreach ($product_option['product_option_value'] as $product_option_value) {
								$option_value_info = OptionValue::where('option_value.id',$product_option_value['option_value_id'])->first();
								$option_value_info1 = OptionValue::find($product_option_value['option_value_id'])->toArray();
								
								if ($option_value_info1) {
									$product_option_value_data[] = array(
										'product_option_value_id' => $product_option_value['product_option_value_id'],
										'option_value_id'         => $product_option_value['option_value_id'],
										'price'         => $product_option_value['price'],
										'option_value_name'                    => $option_value_info1['name'],
										'option_value_image'                    => $option_value_info1['image'],
										'price_prefix'            => $product_option_value['price_prefix']
									);
								}
							}


							$option_data[] = array(
								'product_option_id'    => $product_option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $product_option['option_id'],
								'name'                 => $option_info['name'],
								'type'                 => $option_info['type'],
								'value'                => $product_option['value'],
								'required'             => $product_option['required']
							);
						}
					}
				}
				$json[] = array(
					'option'     => $option_data
				);
				$option = $option_data;
			}
		}
		return $option;
	}
	
}
