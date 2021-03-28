@extends('admin.dashboard')
@section('title', 'Add Order')
@section('assets')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <h3>Add order</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li><a href="{!!url('admin/order/list')!!}">Order</a></li>
                                    <li>Add Order</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        @if(Session::has('status'))
                <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {!!Session::get('status')!!}
        </div>
        @endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\OrderController@doAddOrder')!!}" method="post" enctype="multipart/form-data">
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
{{--                                                        <div style="float: right;">--}}
{{--															<button type="button" class="btn-success btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">--}}
{{--  																Thêm khách hàng mới--}}
{{--															</button>--}}
{{--                                       					</div>--}}
														<div class="form-wrap">
															<div class="row">
																<div class="col-md-2">
																	<div id="customer_phone" class="form-group has-success has-feedback">
																		<label>Điện Thoại:</label>
																		<input id="phone" type="text" name="phone" placeholder="0906.289.587" value="" onchange="getPhoneNumber(this.value, '')" ><br/>
																		<input type="hidden" name="customer_code" id="customer_code" value="{!! goGenID() !!}">
																	</div>
																</div>
																<div class="col-md-2">
																	<label>Họ tên:</label>
																	<input id="name" type="text" name="name" placeholder="Ex: Nguyễn Văn Trường" value=""><br>
																	<p id="input_feedback1"></p>
																</div>
																<div class="col-md-2">
																	<label>Email:</label>
																	<input id="email" type="text" name="email" placeholder="Email" value="" ><br/>
																	<p id="input_feedback1"></p>
																</div>
																<div class="col-md-2">
																	<label>Thành phố:</label>
																	<select name="province" id="province" onchange="getDistrict(this.value)" class="form-control city" >
																		<option value="0">Tỉnh / Thành</option>
																		@if(isset($goCity))
																			@foreach($goCity as $city)
																				<option value="{!! $city['id'] !!}" data-id="{!! $city['id'] !!}">{!! $city['name'] !!}</option>
																			@endforeach
																		@endif
																	</select>
																</div>
																<div class="col-md-2">
																	<label>Quận / Huyện:</label>
																	<select name="district" id="district" class="form-control city" >
																		<option value="">Quận / Huyện</option>
																	</select>
																</div>
																<div class="col-md-2">
																	<label>Địa Chỉ:</label>
																	<textarea id="address" class="form-control" name="address" placeholder="Địa Chỉ" ></textarea>
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
															<input type="checkbox" id="show_group_receive_customer" name="receive_group">
															<label class="inline control-label" for="show_group_receive_customer">Tạo thông tin khác</label>
														</div>
														<div id="group_receive_customer">
															<div class="form-wrap">
																<div class="row">
																	<div class="col-md-2">
																		<div id="customer_phone_receive" class="form-group has-success has-feedback">
																		<label>Điện Thoại:</label>
																		<input onchange="getPhoneNumber(this.value, '_receive')" id="phone_receive" type="text" name="phone_receive" placeholder="0906.289.587" value="" ><br/>
																		<input type="hidden" name="customer_receive_code" id="customer_receive_code" value="{!! goGenID() !!}">
																		</div>
																	</div>
																	<div class="col-md-2">
																		<label>Họ tên:</label>
																		<input id="name_receive" type="text" name="name_receive" placeholder="Ex: Nguyễn Văn Trường" value=""><br>
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="col-md-2">
																		<label>Email:</label>
																		<input id="email_receive" type="text" name="email_receive" placeholder="Email" value="" ><br/>
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="col-md-2">
																		<label>Thành phố:</label>
																		<select name="province_receive" id="province_receive" onclick="getReceiveDistrict(this.value)" class="form-control city" >
																			<option value="">Tỉnh / Thành</option>
																			@if(isset($goCity))
																				@foreach($goCity as $city)
																					<option value="{!! $city['id'] !!}" data-id="{!! $city['id'] !!}">{!! $city['name'] !!}</option>
																				@endforeach
																			@endif
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label>Quận / Huyện:</label>
																		<select name="district_receive" id="district_receive" class="form-control city" >
																			<option value="">Quận / Huyện</option>
																		</select>
																	</div>
																	<div class="col-md-2">
																		<label>Địa Chỉ:</label>
																		<textarea id="address_receive" class="form-control" name="address_receive" placeholder="Địa Chỉ" ></textarea>
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
															<div class="col-md-2">
                                                            <label>Ngày Đặt Hàng:</label>
                                                            <input id="order_date" type="text" name="order_date" placeholder="d/m/Y" value="<?php echo date('d-m-Y'); ?>" class='datepicker'><br/>
                                                            <p id="input_feedback1"></p>
															</div>
															<div class="col-md-2">
																<label class="control-label" for="select">Phương Thức Thanh Toán:</label>
																<select class="form-control" id="select" name="payment_method">
																	<option value="Chuyển Khoản" >Chuyển Khoản</option>
																	<option value="Tiền Mặt" >Tiền Mặt</option>
																</select>
															</div>
															<div class="col-md-2">
																<label class="control-label" for="select">Tình Trạng Đơn Hàng:</label>
																<select class="form-control" id="status" name="status" name="category">
																	<option value="Đã đặt">Đã đặt</option>
																	<option value="Đã huỷ">Đã huỷ</option>
																	<option value="Đã giao">Đã giao</option>
																	<option value="Trả hàng">Trả hàng</option>
																	<option value="Hoàn thành">Hoàn thành</option>
																</select>
															</div>
															<div class="col-md-2">
																<label>Ghi Chú:</label>
																<textarea id="notes" class="form-control" name="notes" placeholder="Ghi Chú" ></textarea>
																<p id="input_feedback1"></p>
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
											<input type="hidden" id="getnum" name="getnum" value="1" class="form-control"/>
											<div class="title-table">
												<div class="form-group col-md-4">
													<label>Tên sản phẩm </label>
												</div>
												<div class="form-group col-md-2">
													<label>Tuỳ chọn</label>
												</div>
												<div class="form-group col-md-1">
													<label>Số lượng </label>
												</div>
												<div class="form-group col-md-2">
													<label>Đơn giá </label>
												</div>
												<div class="form-group col-md-2">
													<label>Thành tiền </label>
												</div>
												<div class="form-group col-md-1">
													<label><i class="fa fa-cog"></i></label>
												</div>
											</div>
											<div class="blockpropa">
												<div class="blockpro block1">
													<div class="form-group col-md-4">
														<select placeholder="Chọn hoặc nhập tên để tìm sản phẩm"  data-plugin-selectTwo class="selectproduct form-control option0" data-id="1" id="product1" name="product[0][product_id]" required>
															<option value="">Chọn hoặc gõ để tìm kiếm</option>

														@foreach ($products as $product)
														<?php
															$price = '';
															if($product->promotion_price == '') $price = $product->unit_price;
															if($product->promotion_price == 0) $price = $product->unit_price;
															if( $product->promotion_price > 100) $price =  $product->promotion_price;
															if($product->promotion_price < 100 && $product->promotion_price > 0) $price = $product->unit_price - (($product->unit_price * $product->promotion_price)/100);
														?>
														<option value="{{$product->id}}" data-price="{{$price}}">{{$product->name}} </option>                                    @endforeach
														</select>


													</div>
													<div class="form-group col-md-2 option1">

													</div>
													<div class="form-group col-md-1">
														<input id="sl1" type="number" data-id="1" min="1" name="product[0][sl]" value="1" class="form-control inputsl" placeholder="Số lượng" required/>
													</div>
													<div class="form-group col-md-2">
														<input id="dg1" type="number" min="1" name="product[0][dg]" value="" class="form-control inputdg" readonly/>
													</div>
													<div class="form-group col-md-2">
														<input id="tt1" type="number" min="1" name="product[0][tt]" value="" class="form-control thanhtien inputtt" readonly/>
													</div>
													<div class="form-group col-md-1">

													</div>
												</div>
												</div>
												<div class="blockaddpro">
												</div>
												<div class="form-group " style="width:100%;display: inline-block;">
													<div type="text" id="addpro" class="btn btn-primary" value="Thêm sản phẩm">Thêm sản phẩm</div>
													<!--<div type="text" id="subpro" class="btn btn-primary" value="Bớt sản phẩm">Bớt sản phẩm</div>-->
												</div>
												<div class="col-md-8 col-md-offset-4 order-table">
													 <table class="table text-right">
														<tbody>
														   <tr id="subtotal">
															  <td><span class="bold">Tổng :</span>
															  </td>
															  <td class="subtotal"><b>0.000 </b>đ<input type="hidden" id="inputsubtotal" name="subtotal" value="0"></td>
														   </tr>
														   <tr id="discount_area">
															  <td>
																 <div class="row">
																	<div class="col-md-7">
																	   <span class="bold">
																		Chiếu khấu                         </span>
																	</div>
																	<div class="col-md-5">
																		<div class="input-group" id="discount-total">

																			<input type="number" value="0" class="form-control pull-left input-discount" min="0" id="discount" name="discount" aria-invalid="false" placeholder="">


																		</div>
																	</div>
																 </div>
															  </td>
															  <td class="discount-total">-<b>0.000 </b>đ</td>
														   </tr>
{{--														   <tr>--}}
{{--															  <td><span class="bold">Thuế GTGT: 10%</span>--}}
{{--															  </td>--}}
{{--															  <td class="gtgt"><b>0.000 </b>đ<input type="hidden" id="inputgtgt" name="gtgt" value=""></td>--}}
{{--														   </tr>--}}
														   <tr>
															  <td><span class="bold">Thành tiền :</span>
															  </td>
															  <td class="total"><b>0.000 </b>đ<input type="hidden" id="inputtotal" name="total" value="0"></td>
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
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Add</button>
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
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Thông tin khách hàng</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="getCustomer()">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    </div>
  </div>
</div>
@endsection
@section('assetjs')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
	  $('#group_receive_customer').css("display","none");
	  $('#show_group_receive_customer').on('change', function(){
		  if(this.checked){
		  	$('#group_receive_customer').css("display","block");
		  	$('#show_group_receive_customer').val(1);
		  }else{
			  $('#group_receive_customer').css("display","none");
			  $('#show_group_receive_customer').removeAttr("value");
		  }
	  });
  function getDistrict(province_id){
	    $("#district").find("option").remove();
	    var data = {
	        province_id: province_id
	    };
	    $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
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

	function getCustomer(){
	    $("#customer_name").find("option").remove();
	    $.ajax({
	        url: "{!! url('admin/customer/quicklylist') !!}",
	        type: 'POST',
	        contentType: "application/json; charset=utf-8",
	        // convert data to object
	        success: function (data) {
	            if(data.listCustomer){
	                $('#customer_name').append('<option value="">Chọn hoặc gõ để tìm kiếm</option>');
	                $.each(data.listCustomer, function (i, v) {
	                    $('#customer_name').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
	                });
	            }
	        },
	        fail: function (data) {
	            console.log('failed');
	        }
	    });
	}
	function getPhoneNumber(phone, receive){
	    var data = {
			phone: phone
		};
		var selected = "";
		var type_customer;
		if(receive == ""){
			type_customer = "";
		}else{
			type_customer = receive;
		}
		console.log($("#phone" + type_customer).val());
	    $.ajax({
	        url: "{!! action('Admin\CustomerController@getPhoneNumber') !!}",
	        type: 'POST',
	        data: JSON.stringify(data),
	        contentType: "application/json; charset=utf-8",
	        // convert data to object
	        success: function (data) {
				$("#province" + type_customer).find("option").remove();
				$("#district" + type_customer).find("option").remove();
	            if(data.customer){
	            	$.each(data.customer, function(){
	            		// console.log(data.customer.name);
	            		$('#name' + type_customer).val(data.customer.name);
	            		$('#email' + type_customer).val(data.customer.email);
	            		$('#address' + type_customer).val(data.customer.address);
	            	});
	            	$("#customer_phone" + type_customer).append('<div class="form-control-feedback"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></div>');
	            }
	            if(data.listCity){
	            	// $('#province').remove();
	                $('#province' + type_customer).append('<option value="">Chọn Tỉnh / Thành</option>');
	                $.each(data.listCity, function (i, v) {
	                	if(v['id'] == data.id_city){
	                		selected = "selected";
	                	}else{
	                		selected = "";
	                	}
	                    $('#province' + type_customer).append('<option data-id="'+ v['id'] +'" value="'+ v['id'] +'" '+selected+'>'+v['name']+'</option>');
	                });
	            }
	            if(data.listDistrict){
	            	// $('#province').remove();
	                $('#district' + type_customer).append('<option value="">Chọn Tỉnh / Thành</option>');
	                $.each(data.listDistrict, function (id, vd) {
	                	if(vd['id'] == data.id_district){
	                		selected = "selected";
	                	}else{
	                		selected = "";
	                	}
	                    $('#district' + type_customer).append('<option data-id="'+ vd['id'] +'" value="'+ vd['id'] +'" '+selected+'>'+vd['name']+'</option>');
	                });
	            }
	        },
	        fail: function (data) {
	            console.log('failed');
	        }
	    });
	}
	function getReceiveDistrict(province_id){
		$("#district_receive").find("option").remove();
		var data = {
			province_id: province_id
		};
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
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
	  function getReceiveCustomer(){
		  $("#customer_name").find("option").remove();
		  $.ajax({
			  url: "{!! url('admin/customer/quicklylist') !!}",
			  type: 'POST',
			  contentType: "application/json; charset=utf-8",
			  // convert data to object
			  success: function (data) {
				  if(data.listCustomer){
					  $('#customer_name').append('<option value="">Chọn hoặc gõ để tìm kiếm</option>');
					  $.each(data.listCustomer, function (i, v) {
						  $('#customer_name').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
					  });
				  }
			  },
			  fail: function (data) {
				  console.log('failed');
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
	  html = '<div class="blockpro block'+getnum+'"><div class="form-group col-md-4"><select placeholder="Chọn hoặc nhập tên để tìm sản phẩm" data-plugin-selectTwo class="selectproduct form-control" data-id="'+getnum+'" id="product'+getnum+'" name="product['+getnumer+'][product_id]" class="form-control"><option value="" data-price="">Chọn sản phẩm</option> <?php foreach($product1 as $product){ ?> <option data-price="<?php
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
		subtotal();
	});

	$(document).on("click",'.single-profile-bio .subpronew', function(){
	console.log('cnsdjc');
		$(this).parent().parent().remove();
		subtotal();
	});
	function formatprice(num) {
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
		var sau_chietkhau;
		// var gtgt = 0;
		if(discount >0 && discount<=100){

			var discounttotal = (total*discount)/100;
			$('.discount-total b').html(discounttotal);
			sau_chietkhau = total - (total*discount)/100;
			var gtgt = 0;
			var end = total + gtgt + sau_chietkhau;
			// $('.gtgt b').html(gtgt);
		}
		else{
			sau_chietkhau = total - discount;
			var gtgt = 0;
			var end = total + gtgt + sau_chietkhau;
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
		// console.log(discounttotal);

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
		var id = $(this).attr('data-id');
		var dg = $('#product'+id).find(':selected').attr('data-price');
		$('.optionproduct'+id).each(function(index,item){
			var data_price_prefix = $(item).find(':selected').attr('data-price-prefix');
			var data_price = $(item).find(':selected').attr('data-price');
			if(data_price_prefix == '-')
				dg = parseInt(dg) - parseInt(data_price);
			else
				dg = parseInt(dg) + parseInt(data_price);

		});
		$('#dg'+id+'').val(formatprice(parseInt(dg)));
		var sl = $('#sl'+id+'').val();
		$('#tt'+id+'').val(formatprice(parseInt(dg)*parseInt(sl)));
		subtotal();
	});

		$(document).on("change",'.selectproduct', function(){

	     var id = $(this).attr('data-id');
		 id1 = id - 1;
	     var idproduct = $(this).val();
		 var data = $(this).find(':selected').attr('data-price');//console.log(data);
		 $('#dg'+id+'').val(formatprice(parseInt(data)));
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
			html = '';
            for (var i in res) {
				console.log('mssbb:'+res[i].option);

					if(res[i].option.length > 0){

						for (var k in res[i].option) {
							option = res[i].option[k];
							// console.log(option['product_option_value'][k]['product_option_value_id']);
							if (option['type'] == 'select') {
								html += '    <select name="productoption['+id1+'][option]['+k+'][product_option_value_id]" id="input-option' + option['product_option_id'] + '" class="opva '+id1+'optionproduct'+k+' optionproduct optionproduct'+getnumer+' form-control" data-option="'+k+'" data-pt="'+id1+'" data-id="'+getnumer+'">';
								html += '      <option value="" data-price-prefix="+" data-price="0">Choose '+option['name']+'</option>';

								for (j = 0; j < option['product_option_value'].length; j++) {
									option_value = option['product_option_value'][j];
									html += '<option value="' + option_value['product_option_value_id'] + '" data-price-prefix="' + option_value['price_prefix'] + '" data-price="' + option_value['price'] + '">' + option_value['option_value_name'];
									// ko tinh giá
									if (option_value['price']) {
										html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
									}
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

								html += '    <select name="productoption['+id1+'][option]['+k+'][product_option_value_id]" id="input-option' + option['product_option_id'] + '" data-option="'+k+'" data-pt="'+id1+'" class="'+id1+'optionproduct'+k+' optionproduct form-control radiooption'+id1+'">';
								html += '      <option value="" data-price-prefix="+" data-price="0">Choose '+option['name']+'</option>';

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
						$('.option'+id).html(html);
					}


            }$('.option'+id).html(html);
        });

		 subtotal();
	});


  </script>
  <script type="text/javascript">

		$(document).ready(function() {
			$('#product1').select2({
			});
			$("#customerform").submit(function (e) {
	            e.preventDefault();
	            $('.error').text('');
	            $('.alert').text('');
	            $.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
	            $.ajax({
	                url: "{!! url('admin/customer/quicklyadd') !!}",
	                method: 'post',
	                data: {
	                    name: $('#quickly_name').val(),
	                    phone: $('#quickly_phone').val(),
	                    email: $('#quickly_email').val(),
	                    tel: $('#quickly_tel').val(),
	                    message: $('#quickly_message').val(),
	                    address: $('#quickly_address').val(),
	                    fax: $('#quickly_fax').val(),
	                    position: $('#quickly_position').val(),
	                    district: $('#district').val(),
	                    customer_id: $('#customer_id').val(),
	                    province: $('#province').val()
	                },
	                success: function (data) {
	                    $("#customerform").trigger('reset');
	                    if ($.type(data.result) === "object") {
	                        $.each(data.result, function (i, v) {
	                            $('.error').append('<p><i class="fa fa-exclamation"></i> ' + v + '</p>');
	                        });
	                        if (data.hoten != '') {
	                            $('#quickly_name').val(data.hoten);
	                        }
	                        if (data.phone != '') {
	                            $('#quickly_phone').val(data.phone);
	                        }
	                        if (data.email != '') {
	                            $('#quickly_email').val(data.email);
	                        }
	                        if (data.message != '') {
	                            $('#quickly_message').val(data.message);
	                        }
	                        $('.alert').html('');
	                    } else {
	                        $('.error').html('');
	                        $("#btn_quicklysend").attr("disabled", true);
	                        $('.alert').html(data.result);
	                    }
	                },
	                fail: function (data) {
	                    $('.alert').html(data.fail);
	                }
	            });
	        });
		});

$('#tab-product select[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id'],
						model: item['model'],
						option: item['option'],
						price: item['price']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('#tab-product input[name=\'product\']').val(item['label']);
		$('#tab-product input[name=\'product_id\']').val(item['value']);

		if (item['option'] != '') {
 			html  = '<fieldset>';
            html += '  <legend></legend>';

			for (i = 0; i < item['option'].length; i++) {
				option = item['option'][i];

				if (option['type'] == 'select') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'radio') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'checkbox') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <div id="input-option' + option['product_option_id'] + '">';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<div class="checkbox">';

						html += '  <label><input type="checkbox" name="option[' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" /> ' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '  </label>';
						html += '</div>';
					}

					html += '    </div>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'image') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'text') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" class="form-control" /></div>';
					html += '</div>';
				}

				if (option['type'] == 'textarea') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10"><textarea name="option[' + option['product_option_id'] + ']" rows="5" id="input-option' + option['product_option_id'] + '" class="form-control">' + option['value'] + '</textarea></div>';
					html += '</div>';
				}

				if (option['type'] == 'file') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <button type="button" id="button-upload' + option['product_option_id'] + '" data-loading-text="" class="btn btn-default"><i class="fa fa-upload"></i> </button>';
					html += '    <input type="hidden" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" />';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'date') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group date"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}

				if (option['type'] == 'datetime') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group datetime"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}

				if (option['type'] == 'time') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group time"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}
			}

			html += '</fieldset>';

			$('#option').html(html);

			$('.date').datetimepicker({
				pickTime: false
			});

			$('.datetime').datetimepicker({
				pickDate: true,
				pickTime: true
			});

			$('.time').datetimepicker({
				pickDate: false
			});
		} else {
			$('#option').html('');
		}
	}
});
  </script>
	<link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
	<script src="{{asset('admin_assets/plugins/select2/js/select2.full.js')}}"></script>
@endsection