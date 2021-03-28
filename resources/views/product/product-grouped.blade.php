<?php
use App\Http\Controllers\Module\MenuController;
use App\ProductOption;
use App\Http\Controllers\ProductController;
?>
@extends('master')
@section('title','Product grouped')

@section('header')
@parent
@include('layouts.header')
@stop

@section('content')
	<!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li><a href="javascript:void()">Product</a></li>
                            <li>Ovens, Incubator YAMATO</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
	<div class="product_page_bg">
        <div class="container">
            <div class="content_product_tab">
                <div class="product_tab_button">
                    <ul class="nav" role="tablist">
						<?php $count=1;?>
						@if($listTrade)
						@foreach($listTrade as $key=>$item)
							<li>
								<a class="{{($count++==1)?'active':''}}" data-toggle="tab" href="#tab{{$key}}" role="tab" aria-controls="binder" aria-selected="true" class="active show">{{$item['name']}}</a>
							</li>
						@endforeach
						@endif
                    </ul>
                </div>
                <div class="tab-content">
					<?php $count=1;?>
					@if($listTrade)
					@foreach($listTrade as $key=>$item)
					<div class="tab-pane fade show {{($count++==1)?'active':''}}" id="tab{{$key}}" role="tabpanel">
						<?php  
							$producttrade = ProductController::getProductTrade($item['id']);
						?>
						@if(isset($producttrade))
                        <div class="row no-gutters shop_wrapper">
								@foreach($producttrade as $key=>$itempro)
                                <div class="col-lg-3 col-md-4 col-12 ">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a class="primary_img" href="product-details.html"><img src="{!!url('images/upload/product/'.$itempro['image'])!!}" alt=""></a>
                                                <a class="secondary_img" href="product-details.html"><img src="{!!url('images/upload/product/'.$itempro['image'])!!}" alt=""></a>
                                                <div class="label_product">
                                                    <span class="label_sale">Sale</span>
                                                </div>
                                                <div class="action_links">
                                                     <ul>
                                                        <li class="quick_button"><a href="#" data-id="{{$itempro['id']}}" data-toggle="modal" data-target="#modal_box">View Product</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_content grid_content">
                                                <div class="product_content_inner">
                                                    <h4 class="product_name"><a href="{!!url('san-pham/'.$itempro['slug'])!!}">{!!$itempro['name']!!}</a></h4>
                                                </div>   
                                            </div>
                                        </figure>
                                    </article>
                                </div>
								@endforeach
                        </div>
						<!-- Pagination -->
						<div class="row fe-pagination">
							<div class="col-md-12">
								<div class="page-box">
									<div class="pagination-example">
										<nav aria-label="Page navigation" class="navi">
											<?php 
											if(isset($producttrade)) echo $producttrade->render(new App\Pagination\CustomPaginate($producttrade));
											?>
										</nav>
									</div>
								</div>
							</div>
						</div>
						<!-- End Pagination -->
						@endif
						
                    </div>
					@endforeach
					@endif
                    
                </div>
            </div>

            
        </div>
    </div>

@stop
@section('scripts')
<script>
$(function () {
    $('.product_variant .color li').on('click', function(e) { 
        $('.product_variant .color li').removeClass('active');
        $(this).addClass('active');
        var atrrclass = $(this).attr('data');
		$('.product_variant .color .radio_option').click();
		console.log('aa:'+$(atrrclass).val());
    });
});
</script>
@stop
