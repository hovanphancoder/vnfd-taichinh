<?php
// dd($orders);
// echo "<pre>";
// print_r($receiver);
// print_r($goCity);
// dd($orders['product_gif']);
use App\Http\Controllers\Admin\OrderController;
?>
@extends('admin.dashboard')
@section('title', 'Edit Order #'.$orders['order_number'])
@section('assets')
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Breadcromb Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="breadcromb-area">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-left">
                                <h3>Edit order # <span style="color: red; text-transform: uppercase;">{!! $orders['order_number'] !!}</span></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li><a href="{!!url('admin/order/list')!!}">Order</a></li>
                                    <li>Order Detail</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
		<!-- <section class="content-header">
			<div style="text-align: right">
				<a href="{!!url('admin/order/pdf/'.$orders['id'].'?client_id='.$orders['customer_id'].'&lg=V')!!}" class="btn btn-primary  btn-flat">PDF VI</a>
				<a href="{!!url('admin/order/pdf/'.$orders['id'].'?client_id='.$orders['customer_id'].'&lg=EN')!!}" class="btn btn-primary btn-flat"></span>PDF EN</a>
			</div>
		</section> -->
        @if(Session::has('status'))
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {!!Session::get('status')!!}
        </div>
        @endif
        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\OrderController@orderUpdate', $orders['id'])!!}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <div class="create-page-left">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="single-profile-bio">
                                                        <h3>Thông Tin Khách Hàng</h3>
														<div class="form-group">
															<div class="row">
																<div class="col-md-2">
																	<label>Điện Thoại:</label>
																	<input id="phone" type="text" name="phone" placeholder="Phone number" value="{!! $customer['phone'] !!}" ><br/>
																	<input type="hidden" name="customer_code" id="customer_code" value="{!! $customer['customer_code'] !!}">
																	<p id="input_feedback1"></p>
																</div><div class="col-md-2">
                                                            <label>Tên khách hàng:</label>
															<input type="text" class="form-control" id="name" name="name" value="{!! $customer['name'] !!}" required>
                                                            <p id="input_feedback1"></p>
																</div>
																<div class="col-md-2">
																	<label>Email:</label>
																	<input id="email" type="text" name="email" placeholder="SEO Keyword" value="{!! $customer['email'] !!}" ><br/>
																	<p id="input_feedback1"></p>
																</div>
																<div class="col-md-2">
																	<label>Thành phố:</label>
																	<select name="province" id="province" onclick="getDistrict()" class="form-control city" >
																		<option value="">Tỉnh / Thành</option>
																		@if(isset($goCity))
																			@foreach($goCity as $city)
																				<option value="{!! $city['id'] !!}" data-id="{!! $city['id'] !!}" {!! $customer['city'] ==  $city['id']?'selected':'' !!}>{!! $city['name'] !!}</option>
																			@endforeach
																		@endif
																	</select>
																</div>
																<div class="col-md-2">
																	<label>Quận / Huyện:</label>
																	<select name="district" id="district" class="form-control city" >
																		<option value="">Quận / Huyện</option>
																		@if($goDistrict)
																		@foreach($goDistrict as $district)
																		<option value="{!! $district['id'] !!}" {!! ($customer['district'] == $district['id'])?'selected':'' !!}>{!! $district['name'] !!}</option>
																		@endforeach
																		@endif
																	</select>
																</div>
																<div class="col-md-2">
																	<label>Địa Chỉ:</label>
																	<textarea id="address" class="form-control" name="address" placeholder="Address" >{{ $customer['address'] }}</textarea>
																	<p id="input_feedback1"></p>
																</div>
															</div>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-md-12 col-sm-12">
													<div class="single-profile-bio">
														<h3 style="float: left; margin-right: 1rem">Thông tin giao hàng</h3>
														<div class="form-group form-checkbox">
															<input type="checkbox" id="show_group_receive_customer" name="receive_group" {!! $receiver?'checked':'' !!}>
															<label class="inline control-label" for="show_group_receive_customer">Tạo thông tin khác</label>
														</div>
														<div id="group_receive_customer" style="{!! $receiver?'display:block':'display:none' !!}">
															<div class="form-group">
																<div class="row">
																	<div class="col-md-2">
																		<label>Điện Thoại:</label>
																		<input id="phone_receive" type="text" name="phone_receive" placeholder="0906.289.587" value="{!! $receiver['phone'] !!}" ><br/>
																		<input type="hidden" name="customer_receive_code" id="customer_receive_code" value="{!! $receiver['customer_id'] !!}">
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="col-md-2">
																		<label>Họ tên:</label>
																		<input id="name_receive" type="text" name="name_receive" placeholder="Ex: Nguyễn Văn Trường" value="{!! $receiver['name'] !!}"><br>
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="col-md-2">
																		<label>Email:</label>
																		<input id="email_receive" type="text" name="email_receive" placeholder="Email" value="{!! $receiver['email'] !!}" ><br/>
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="col-md-2">
																		<label>Thành phố:</label>
																		<select name="province_receive" id="province_receive" onclick="getReceiveDistrict()" class="form-control city" >
																			<option value="">Tỉnh / Thành</option>
																			@if(isset($goCity))
																				@foreach($goCity as $city)
																					<option value="{!! $city['id'] !!}" data-id="{!! $city['id'] !!}" {!! ($city['id'] == $receiver['city'])?'selected':'' !!}>{!! $city['name'] !!}</option>
																				@endforeach
																			@endif
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label>Quận / Huyện:</label>
																		<select name="district_receive" id="district_receive" class="form-control city" >
																			<option value="">Quận / Huyện</option>
																			@if($goDistrictReceive)
																			@foreach($goDistrictReceive as $districtReceive)
																			<option data-id="{!! $districtReceive['id'] !!}" value="{!! $districtReceive['id'] !!}" {!! ($districtReceive['id'] == $receiver['district'])?'selected':'' !!}>{!! $districtReceive['name'] !!}</option>
																			@endforeach
																			@endif
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label>Địa Chỉ:</label>
																		<textarea id="address_receive" class="form-control" name="address_receive" placeholder="Địa Chỉ" >{!! $receiver['address'] !!}</textarea>
																		<p id="input_feedback1"></p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="single-profile-bio">
                                                        <h3>Thông Tin Đơn Hàng</h3>
														<div class="form-group">
															<div class="row">
																<div class="col-md-2">
                                                            <label>Ngày Đặt Hàng:</label>
                                                            <input id="order_date" type="text" name="order_date" placeholder="SEO Keyword" value="{{ $orders['created_at'] }}" class='datepicker'><br/>
                                                            <p id="input_feedback1"></p>
																</div>
																<div class="col-md-2">
																	<label class="control-label" for="select">Phương Thức Thanh Toán:</label>
																	<select class="form-control" id="select" name="payment_method">
																		<option value="Chuyển Khoản" <?php echo ($orders['payment_method'] == 'Chuyển Khoản') ? "selected" : "" ?>>Chuyển Khoản</option>
																		<option value="Tiền Mặt" <?php echo ($orders['payment_method'] == 'Tiền Mặt') ? "selected" : "" ?>>Tiền Mặt</option>
																	</select>
																</div>
																<div class="col-md-2">
																	<label class="control-label" for="select">Tình Trạng Đơn Hàng:</label>
																	<select class="form-control" id="status" name="status" name="category">
																		<option value="Mới" <?php echo ($orders['status'] === "Mới")?"selected":""?>>Mới</option>
																		<option value="Đã đặt" <?php echo ($orders['status'] === "Đã đặt")?"selected":""?>>Đã đặt</option>
																		<option value="Đã huỷ" <?php echo ($orders['status'] === "Đã huỷ")?"selected":""?>>Đã huỷ</option>
																		<option value="Đã giao" <?php echo ($orders['status'] === "Đã giao")?"selected":""?>>Đã giao</option>
																		<option value="Trả hàng" <?php echo ($orders['status'] === "Trả hàng")?"selected":""?>>Trả hàng</option>
																		<option value="Hoàn thành" <?php echo ($orders['status'] === "Hoàn thành")?"selected":""?>>Hoàn thành</option>
																	</select>
																</div>
																<div class="col-md-2">
																	<label>Ghi Chú:</label>
																	<textarea id="notes" class="form-control" name="notes" placeholder="" >{{ $orders['notes'] }}</textarea>
																	<p id="input_feedback1"></p>
																</div>
															</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="single-profile-bio">
                                                        <h3>Quà tặng kèm</h3>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12 col-12">
                                                           			<div class="product_gift">
                                                           				<?php
                                                           				$arr_gift = explode(',',$orders['product_gif']);
                                                           				// dd($arr_gift);
                                                           				$productList = App\ProductLanguage::join('products','products.id','=','products_language.product_id')
                                                           							->whereIn('products_language.product_id', $arr_gift)
                                                           							->where('products_language.language_id', get_id_locale())
                                                           							->select('products_language.product_id','products_language.name', 'products_language.slug', 'products.image')
                                                           							->get();
                                                           				?>
                                                           				<ul>
                                                           					@if($productList)
                                                           					@foreach($productList as $product)
                                                           					<li>
                                                           						<a target="_blank" href="{!! url('admin/product/view/'.$product->product_id) !!}">
                                                           						<img style="width: 100px; height: 100px;" src="{!! url('images/upload/product/'. $product->image) !!}">
                                                           						<h6>{!! $product->name !!}</h6>
	                                                           					</a>
                                                           					</li>
                                                           					@endforeach
                                                           					@endif
                                                           				</ul>
                                                           			</div>
																</div>
															</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="single-profile-bio">
                                            <h3>Thông Tin Sản Phẩm</h3>
											<input type="hidden" id="getnum" name="getnum" value="{{$countpro}}" class="form-control"/>
											<div class="title-table">
												<div class="form-group col-md-3">
													<label>Tên sản phẩm </span></label>
												</div>
												<div class="form-group col-md-3">
													<label>Tuỳ chọn</label>
												</div>
												<div class="form-group col-md-1">
													<label>Số lượng </span></label>
												</div>
												<div class="form-group col-md-1">
													<label>Đơn giá </span></label>
												</div>
												<div class="form-group col-md-1">
													<label>Giá khuyến mãi </span></label>
												</div>
												<div class="form-group col-md-2">
													<label>Thành tiền </span></label>
												</div>
												<div class="form-group col-md-1">
													<label><i class="fa fa-cog"></i></label>
												</div>
											</div>
											@if($orderDetail)
                                            @foreach($orderDetail as $count => $detail)
											 <?php if($count == 0) echo '<div class="blockpropa">'; else echo '<div class="blockaddpro">'; ?>
												<input type="hidden" name="product[{{$count}}][orderdetail_id]" value="{{$detail['id']}}" />
												<div class="blockpro block{{$count+1}}">
													<div class="form-group col-md-3">
														<select placeholder="Chọn hoặc nhập tên để tìm sản phẩm"  class="form-control " data-id="{{$count+1}}" id="product{{$count+1}}" name="product[{{$count}}][product_id]" data-plugin-selectTwo required>
														@foreach ($products as $product)
														<?php
															if($product->promotion_price == 0) $price = $product->unit_price;
															if($product->promotion_price > 100) $price =  $product->promotion_price;
															if($product->promotion_price < 100 && $product->promotion_price > 0) $price = $product->unit_price - (($product->unit_price * $product->promotion_price)/100);
														?>
														<option <?php if($detail['product_id'] == $product->id) echo 'selected'  ?> value="{{$product->id}}" data-price="{{$price}}">{{$product->name}} </option>                                    @endforeach
														</select>
													</div>
													<div class="form-group col-md-3 option{{$count+1}}">
														<?php
															$items = OrderController::getOrderOption($detail['product_id'],$detail['order_id']);
															//echo '<pre>';print_r($item);exit;
															// dd($items);
														?>
															@foreach($items as $key=>$item)
															@if($item['type']=='select')
															<label>{!! $item['name'] !!}</label>
																<select name="product[{{$count}}][option][{{$key}}][product_option_value_id]" id="input-option30" class="opva {{$count}}optionproduct{{$key}} optionproduct form-control" data-option="{{$key}}" data-pt="{{$count}}">
																	<option value="">Choose {{$item['name']}}</option>
																	<?php
																		$op = OrderController::getProductOptionValue($item['product_option_id']);
																		// dd($op);
																		foreach($op as $itm){
																		 ?>
																		<option <?php if($itm['product_option_value_id'] == $item['product_option_value_id']) echo 'selected'; ?> value="{{$itm['product_option_value_id']}}">{{$itm['name']}}</option>
																		<?php } ?>
																</select>
																<input type="hidden" name="product[{{$count}}][option][{{$key}}][type]" value="select" />
																<input type="hidden" name="product[{{$count}}][option][{{$key}}][name]" value="{{$item['name']}}" />
																<input type="hidden" class="{{$count}}optionvalue{{$key}}" name="product[{{$count}}][option][{{$key}}][value]" value="{{$item['value']}}" />
																<input type="hidden" name="product[{{$count}}][option][{{$key}}][product_option_id]" value="{{$item['product_option_id']}}" />
																<input type="hidden" name="product[{{$count}}][option][{{$key}}][order_option_id]" value="{{$item['id']}}" />
															 @endif
														@endforeach
													</div>
													<div class="form-group col-md-1">
														<input id="sl{{$count+1}}" type="number" data-id="{{$count+1}}" min="1" name="product[{{$count}}][sl]" value="{{$detail['quantity']}}" class="form-control inputsl" placeholder="Số lượng" required/>
													</div>
													<div class="form-group col-md-1">
														<input id="unit_price{{$count+1}}" type="number" min="1" name="product[{{$count}}][unit_price]" value="{{$detail['unit_price']}}" class="form-control inputdg" readonly/>
														<input id="dg{{$count+1}}" type="hidden" name="product[{{$count}}][dg]" value="{!! ($detail['promotion_price'] > 0)?$detail['promotion_price']:$detail['unit_price'] !!}" class="form-control inputdg" readonly/>
													</div>
													<div class="form-group col-md-1">
														<input id="promotion_price{{$count+1}}" type="number" min="1" name="product[{{$count}}][promotion_price]" value="{{$detail['promotion_price']}}" class="form-control inputdg" readonly/>
													</div>
													<div class="form-group col-md-2">
														<?php
														if($detail['promotion_price'] > 0 && $detail['promotion_price'] < $detail['unit_price'])
															$final_price = $detail['quantity'] * $detail['promotion_price'];
														else
															$final_price = $detail['quantity'] * $detail['unit_price'];
														?>
														<input id="tt{{$count+1}}" type="number" min="1" name="product[{{$count}}][tt]" value="{!! $final_price !!}" class="form-control thanhtien inputtt" readonly/>
													</div>
													<div class="form-group col-md-1"><span class="block-trash subpronew" id="del{{$count+1}}"><i class="fa fa-trash"></i></span></div>
												</div>
												</div>
												@endforeach
												@endif
												<?php if($countpro == 1) echo '
												<div class="blockaddpro">
												</div>'; ?>
												<div class="form-group " style="width:100%;display: inline-block;">
													<div type="text" id="addpro" class="btn btn-primary" value="Thêm sản phẩm">Thêm sản phẩm</div>
												</div>
												<div class="col-md-8 col-md-offset-4 order-table">
													 <table class="table text-right">
														<tbody>
														   <tr id="subtotal">
															  <td><span class="bold">Tạm tính :</span>
															  </td>
															  <td class="subtotal"><b>{!! number_format($orders['total_price']) !!} </b>đ<input type="hidden" id="inputsubtotal" name="subtotal" value="{!! $orders['total_price'] !!}"></td>
														   </tr>
														   <tr id="discount_area">
															  <td>
																 <div class="row">
																	<div class="col-md-7">
																	   <span class="bold">
																		Chiếu khấu </span>
																	</div>
																	<div class="col-md-5">
																		<div class="input-group" id="discount-total">
																			<input type="number" value="{{$orders['discount_percent']}}" class="form-control pull-left input-discount" min="0" id="discount" name="discount" aria-invalid="false">
																		</div>
																	</div>
																 </div>
															  </td>
															 <?php
																if($orders['discount_percent'] > 0 && $orders['discount_percent'] <= 100){
																	$discount = ($orders['total_price'] * $orders['discount_percent'])/100;
																}else
																	$discount = $orders['discount_percent'];
															 ?>
															  <td class="discount-total">- <b>{!! number_format($discount) !!} </b>đ</td>
														   </tr>
{{--														   <tr>--}}
{{--															  <td><span class="bold">Thuế GTGT: 10%</span>--}}
{{--															  </td>--}}
{{--															  <td class="gtgt"><b>{{number_format($orders['gtgt'])}} </b>đ<input type="hidden" id="inputgtgt" name="gtgt" value="{{number_format($orders['gtgt'])}}"></td>--}}
{{--														   </tr>--}}
														   <tr>
															  <td><span class="bold">Thành tiền :</span>
															  </td>
															  <td class="total"><b>{!! number_format($orders['total_price'] - $discount) !!} </b>đ<input type="hidden" id="inputtotal" name="total" value="{!! $orders['total_price'] !!}"></td>
														   </tr>
														</tbody>
													 </table>
												  </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/order/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Pages Table Row -->
    </div>
</div>
<!-- Footer Area Start -->
<footer class="seipkon-footer-area">
    @include('admin/layouts/footer')
</footer>
<!-- End Footer Area -->
@endsection
@section('assetjs')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  	if($("#show_group_receive_customer")[0].checked == true){
		$('#group_receive_customer').css("display","block");
		$('#show_group_receive_customer').val(1);
	}
	$('#show_group_receive_customer').on('change', function(){
		if(this.checked){
			$('#group_receive_customer').css("display","block");
			$('#show_group_receive_customer').val(1);
		}else{
			$('#group_receive_customer').css("display","none");
		  	$('#show_group_receive_customer').removeAttr("value");
		}
	});
	  function getDistrict(){
		  $("#district").find("option").remove();
		  var data = {
			  province_id: $('#province').val()
		  };
		  $.ajax({
			  url: "{!! url('admin/order/quan-huyen') !!}",
			  type: 'POST',
			  contentType: "application/json; charset=utf-8",
			  // convert data to object
			  data: JSON.stringify(data),
			  success: function (data) {
				  if(data.listDistrict){
					  $('#district').append('<option value="">Chọn Quận / Huyện</option>');
					  $.each(data.listDistrict, function (i, v) {
						  $('#district').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
					  });
				  }
			  },
			  fail: function (data) {
				  $('.alert').html(data);
			  }
		  });
	  }
	  function getReceiveDistrict(){
		  $("#district_receive").find("option").remove();
		  var data = {
			  province_id: $('#province_receive').val()
		  };
		  $.ajax({
			  url: "{!! url('admin/order/quan-huyen') !!}",
			  type: 'POST',
			  contentType: "application/json; charset=utf-8",
			  // convert data to object
			  data: JSON.stringify(data),
			  success: function (data) {
				  if(data.listDistrict){
					  $('#district_receive').append('<option value="">Chọn Quận / Huyện</option>');
					  $.each(data.listDistrict, function (i, v) {
						  $('#district_receive').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
					  });
				  }
			  },
			  fail: function (data) {
				  $('.alert').html(data);
			  }
		  });
	  }
  $( "#order_date" )
        .datepicker({
          changeMonth: true,
          changeYear: true,
		  dateFormat: "dd-mm-yy",
          numberOfMonths: 1
        });
	$( "#duedate" ).datepicker({
        changeMonth: true,
        changeYear: true,
		dateFormat: "dd-mm-yy",
        numberOfMonths: 1
      });
	 $.datepicker.regional["vi-VN"] =
	{
		closeText: "Đóng",
		prevText: "Trước",
		nextText: "Sau",
		currentText: "Hôm nay",
		monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
		monthNamesShort: ["Một", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
		dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
		dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
		dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
		weekHeader: "Tuần",
		dateFormat: "dd/mm/yy",
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ""
	};
	$.datepicker.setDefaults($.datepicker.regional["vi-VN"]);
	$("#addpro").click(function(){
	  var getnumer = $('#getnum').val();
	  getnum = parseInt(getnumer) + 1;
	  html = '<div class="blockpro block'+getnum+'"><div class="form-group col-md-4"><select placeholder="Chọn hoặc nhập tên để tìm sản phẩm" data-plugin-selectTwo class="form-control" data-id="'+getnum+'" id="product'+getnum+'" name="product['+getnumer+'][product_id]" class="form-control"><option value="" data-price="">Chọn sản phẩm</option> <?php foreach($product1 as $product){ ?> <option data-price="<?php
		if($product->promotion_price == '') $price = $product->unit_price;
		if($product->promotion_price > 100 ) $price =  $product->promotion_price;
		if($product->promotion_price < 100 && $product->promotion_price > 0) $price = $product->unit_price - (($product->unit_price * $product->promotion_price)/100);
		echo $price; ?>" value="<?php echo $product->id; ?>" ><?php echo $product->name; ?>  </option><?php } ?> </select></div><div class="form-group col-md-2 option'+getnum+'"></div><div class="form-group col-md-1"><input id="sl'+getnum+'" data-id="'+getnum+'" type="number" min="1" name="product['+getnumer+'][sl]" value="1" class="form-control inputsl" required/></div><div class="form-group col-md-2"><input id="dg'+getnum+'" type="number" min="1" name="product['+getnumer+'][dg]" value="" class="form-control inputdg" readonly/></div><div class="form-group col-md-2">	<input id="tt'+getnum+'" type="number" min="1" name="product['+getnumer+'][tt]" value="" class="form-control thanhtien inputtt" readonly/></div><div class="form-group col-md-1"><span class="block-trash subpronew" id="del'+getnum+'"><i class="fa fa-trash"></i></span></div></div>';
	  $('.blockaddpro').append(html);
	  $('#getnum').val(getnum);
	  $('#product'+getnum).select2();
	});
	$("#subpro").click(function(){
		$('.blockaddpro .blockpro:last-child').remove();
		var getnum = $('#getnum').val();
		if(getnum > 1) getnum = getnum -1;
		$('#getnum').val(getnum);
		subtotal();
	});
	$(document).on("click",'.single-profile-bio .subpronew', function(){
	console.log('cnsdjc');
		$(this).parent().parent().remove();
		subtotal();
	});
	function formatprice(num) {
		// var p = num.toFixed(0).split(".");
		// return  p[0].split("").reverse().reduce(function(acc, num, i, orig) {
			// return  num=="-" ? acc : num + (i && !(i % 3) ? "." : "") + acc;
		// }, "");
		return num;
	}
	function subtotal() {
		var total = 0;
		var thanhtien = document.getElementsByClassName('thanhtien');
		for (var i = 0; i < thanhtien.length; ++i) {
		if (!isNaN(parseInt(thanhtien[i].value)) )
		total += parseInt(thanhtien[i].value);
		}
		$('#inputsubtotal').val(total);
		$('.subtotal b').html(total);
		var discount = $('#discount').val();
		if(discount >0 && discount<=100){
			var discounttotal = (total*discount)/100;
			$('.discount-total b').html(discounttotal);
			sau_chietkhau = total - (total*discount)/100;
			var gtgt = 0;
			var end = sau_chietkhau + gtgt;
			// $('.gtgt b').html(gtgt);
		}
		else{
			sau_chietkhau = total - discount;
			var gtgt = 0;
			var end = sau_chietkhau + gtgt;
			$('.discount-total b').html(formatprice(discount));
			// $('.gtgt b').html(gtgt);
		}
		$('#inputgtgt').val(gtgt);
		$('#inputtotal').val(sau_chietkhau);
		$('.total b').html(formatprice(sau_chietkhau));
	}
	$(document).on("change",'#discount', function(){
	   var sub_total = $('#inputsubtotal').val();
	   var discount = $('#discount').val();
		if(discount >0 && discount<=100){
			var discounttotal = (sub_total*discount)/100;
			$('.discount-total b').html(formatprice(discounttotal));
		}
		else $('.discount-total b').html(formatprice(discount));
		subtotal();
	});
	$(document).on("change",'.inputsl', function(){
		var id = $(this).attr('data-id');
		var sl = $(this).val();
		var dg = $('#dg'+id+'').val();
		$('#tt'+id+'').val(formatprice(dg*sl));
		subtotal();
	});
	$(document).on("change",'.optionproduct', function(){
		//lấy value option product
		//var id = $(this).attr('data-id');
		var option = $(this).attr('data-option');
		var pt = $(this).attr('data-pt');
		var value = $("."+pt+"optionproduct"+option+" option:selected").text();
		console.log('value:'+value);
		$('.'+pt+'optionvalue'+option+'').val(value);
	});
	$(document).on("change",'select[name^=product]', function(){
		// console.log('dasdasssssssssssssssssss');
	     var id = $(this).attr('data-id');console.log(id);
		 id1 = id - 1;
	     var idproduct = $(this).val();
		 var data = $(this).find(':selected').attr('data-price');console.log(data);
		 $('#dg'+id+'').val(formatprice(data));
		 var sl = $('#sl'+id+'').val();
	     $('#tt'+id+'').val(formatprice(parseInt(data)*parseInt(sl)));
		 /*cal ajax option */
		 $.ajax({
            type: 'get',
            url: '{!!url("admin/order/ajaxgetoptionproduct")!!}/' + idproduct,
            data: idproduct,
        }).done(function(res) {
            console.log('mss:'+res);
			var getnumer = $('#getnum').val();
			html ='';
            for (var i in res) {
				console.log('mssbb:'+res[i].option);
					if(res[i].option.length > 0){
						html = '';
						for (var k in res[i].option) {
							option = res[i].option[k];
							console.log(option);
							if (option['type'] == 'select') {
								html += '    <select name="product['+id1+'][option]['+k+'][product_option_value_id]" id="input-option' + option['product_option_id'] + '" class="opva '+id1+'optionproduct'+k+' optionproduct form-control" data-option="'+k+'" data-pt="'+id1+'">';
								html += '      <option value="">Choose '+option['name']+'</option>';
								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['option_value_name'];
									// ko tinh giá
									// if (option_value['price']) {
										// html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									// }
									html += '</option>';
								}
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][type]" value="select" />';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][name]" value="'+option['name']+'" />';
								html += '   <input type="hidden" class="'+id1+'optionvalue'+k+'" name="product['+id1+'][option]['+k+'][value]" value="" />';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['product_option_value'][k]['product_option_value_id'] + '" />';
								html += '    </select>';
							}
							if (option['type'] == 'radio') {
								html += '    <select name="product['+id1+'][option]['+k+'][product_option_value_id]" id="input-option' + option['product_option_id'] + '" data-option="'+k+'" class="'+id1+'optionproduct'+k+' optionproduct form-control radiooption'+id1+'" data-pt="'+id1+'">';
								html += '      <option value="">Choose '+option['name']+'</option>';
								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
									// if (option_value['price']) {
										// html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									// }
									html += '</option>';
								}
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][type]" value="radio" />';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][name]" value="'+option['name']+'" />';
								html += '   <input type="hidden" class="'+id1+'optionvalue'+k+'" name="product['+id1+'][option]['+k+'][value]" value="" />';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
								html += '    </select>';
							}
							if (option['type'] == 'checkbox') {
								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									html += '<div class="checkbox">';
									html += '  <label><input type="checkbox" name="product['+id1+'][option]['+k+'][product_option_value_id][]" value="' + option_value['product_option_value_id'] + '" /> ' + option_value['name'];
									// if (option_value['price']) {
										// html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									// }
								}
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
								html += '    </div>';
							}
							if (option['type'] == 'image') {
								html += '    <select name="product['+id1+'][option]['+k+'][product_option_value_id]" id="input-option' + option['product_option_id'] + '" class="form-control">';
								html += '      <option value="">Choose '+option['name']+'</option>';
								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
									if (option_value['price']) {
										html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									}
									html += '</option>';
								}
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
								html += '    </select>';
							}
							if (option['type'] == 'text') {
								html += '  <div class="col-sm-10"><input type="text" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" class="form-control" placeholder="' + option['name'] + '" /></div>';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
							}
							if (option['type'] == 'textarea') {
								html += '  <div class="col-sm-10"><textarea name="product['+id1+'][option]['+k+'][product_option_value_id]" rows="5" id="input-option' + option['product_option_id'] + '" class="form-control" placeholder="' + option['name'] + '">' + option['value'] + '</textarea></div>';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
							}
							if (option['type'] == 'file') {
								html += '    <button type="button" id="button-upload' + option['product_option_id'] + '" data-loading-text="" class="btn btn-default"><i class="fa fa-upload"></i> </button>';
								html += '    <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" />';
							}
							if (option['type'] == 'date') {
								html += '  <div class="col-sm-12"><div class="input-group date"><input type="text" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
							}
							if (option['type'] == 'datetime') {
								html += '  <div class="col-sm-12"><div class="input-group datetime"><input type="text" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
							}
							if (option['type'] == 'time') {
								html += '  <div class="col-sm-12"><div class="input-group time"><input type="text" name="product['+id1+'][option]['+k+'][product_option_value_id]" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
								html += '   <input type="hidden" name="product['+id1+'][option]['+k+'][product_option_id]" value="' + option['product_option_id'] + '" />';
							}
							k++;
						}//end for
					}
            }$('.option'+id).html(html);
        });
		 subtotal();
	});
  </script>
  <script type="text/javascript">
		$(document).ready(function() {
			$('#product1').select2();
			var countpro = {!! $countpro !!};
			for(i = 2; i < (countpro + 1); i++){
				$('#product' + i).select2();
			}
		});
    </script>
	<link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
	<script src="{{asset('admin_assets/plugins/select2/js/select2.full.js')}}"></script>
@endsection