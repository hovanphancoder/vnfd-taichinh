<?php
// dd(json_decode(Session::get('status')));
//print_r(Session::get('status'));
function categoryTree($parent_id = 0, $submark = '') {
    $query = App\ProductType::getParent($parent_id);
    if ($query > 0) {
        foreach ($query as $catepost) {
            ?>
            <option value="{!!$catepost->id!!}"><?php echo (session('locale') == 'vn')?$submark.$catepost->name:$submark.$catepost->name?></option>
            <?php
            categoryTree($catepost->id, $submark . '---- ');
        }
    }
}
?>
@extends('admin.dashboard')
@section('title', 'Created Coupon')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('assets')
<link rel="stylesheet" href="{!! url('admin_assets/css/select2.css') !!}">
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
                                <h3>Create coupon</h3>                    
                            </div>           
                        </div>      
                        <div class="col-md-6 col-sm-6">         
                            <div class="seipkon-breadcromb-right">      
                                <ul>                              
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>         
                                    <li>coupon</li>                           
                                    <li>Create coupon</li>                        
                                </ul>             
                            </div>         
                        </div>     
                    </div>       
                </div>    
            </div>     
        </div>     
        <!-- End Breadcromb Row -->  
        @if(Session::has('errors'))        
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
		    	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	        @foreach (Session::get('errors') as $error)       
		    	{!! $error.'<br>' !!}
	        @endforeach
		    </div>     
        @endif    
        @if (Session::has('status'))
		    <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
		    	<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		        {!! Session::get('status') !!}
		    </div>
		@endif

        <!-- Pages Table Row Start -->    
        <div class="row">       
            <div class="col-md-12">     
                <div class="page-box">
                <div class="form-wrap">  
                    <form action="{!! action('Admin\CouponController@create') !!}" method="post">      
                        <div class="row">              
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">                   
                            <div class="col-md-9">                  
                                <div class="create-page-left">               
                                    <div class="form-group">                              
                                        <label>Code</label>
                                        <input type="text" name="code" placeholder="Enter code" value=""  >
                                    </div>                         
                                    <div class="form-group">
                                    	<label>Value</label>
                                    	<input type="text" name="value" placeholder="Enter value" value="" >
                                    </div>                      
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity" placeholder="Enter quantity" value="" >
                                    </div>
                                    
                                </div>                         
                            </div>                  
                            <div class="col-md-3">
                            	<div class="form-group form-radio">
                                        <label>Type unit</label><br>
                                        <input type="radio" name="type_unit" id="percent" value="percent">
                                        <label class="inline control-label" for="percent">Percent (%)</label>&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="type_unit" id="fixed" value="fixed">
                                        <label class="inline control-label" for="fixed">Fixed (100000)</label>
                                    </div>
                                    <div class="form-group form-radio">
                                    	<label>Type discount</label><br>
	                                    <input id="p_" name="type_discount" type="radio" checked value="p_" onchange="getTypeDiscount(this.value)">
                                        <label for="p_" class="inline control-label">Product list</label>
	                                    &nbsp;&nbsp;&nbsp;
                                        <input id="c_" name="type_discount" type="radio" value="c_" onchange="getTypeDiscount(this.value)">
                                        <label for="c_" class="inline control-label">Product category</label>
	                                    &nbsp;&nbsp;&nbsp;
	                                    <input id="none" name="type_discount" type="radio" value="null" onchange="getTypeDiscount(this.value)">
	                                    <label for="none" class="inline control-label">None</label>
	                                    <select class="form-control select2" name="select_type_discount" id="select_type_discount">
	                                    	<option value="">Chọn loại giảm giá</option>
	                                       	@if($categoryProduct)
	                                       	@foreach($categoryProduct as $category)
	                                       	<option value="{!! $category->id !!}">{!! $category->name !!}</option>
	                                       	@endforeach
	                                       	@endif
                                       </select>
                                   	</div>
                            </div>                    
                        </div>                     
                        <div class="form-layout-submit">        
                            <p>
                            	<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Publish</button>
                                <a class="btn btn-default" href="{!!url('admin/coupon/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>         
                            </p>          
                        </div>           
                    </form>
                </div>
                </div>      
            </div>      
        </div>    
        <!-- End Pages Table Row -->   
    </div></div><!-- Footer Area Start -->
    <footer class="seipkon-footer-area"> 
        @include('admin/layouts/footer')
    </footer><!-- End Footer Area -->
    @endsection
@section('assetjs')
<script src="{!! url('admin_assets/js/select2.full.js') !!}"></script>
<script src="{!! url('admin_assets/js/advance_component_form.js') !!}"></script>
<script type="text/javascript">
function getTypeDiscount(type){
	if(type == 'null'){
        $('#select_type_discount').prop("disabled", true);
    }else{
        $('#select_type_discount').prop("disabled", false);
    }
    $('#select_type_discount').find('option').remove();
	var data = {
        type_discount: type
    };
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
	$.ajax({
        url: "{!! action('Admin\CouponController@getProductCategory') !!}",
        type: 'POST',
        contentType: "application/json; charset=utf-8",
        // convert data to object
        data: JSON.stringify(data),
        success: function (data) {
        	console.log(data.type_discount);
            if(data.result_type_discount){
                $('#select_type_discount').append('<option value="">Chọn loại giảm giá</option>');
                $.each(data.result_type_discount, function (i, v) {
                    $('#select_type_discount').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
                });
            }
        },
        fail: function (data) {
            $('.alert').html(data);
        }
    });
}
</script>
@endsection