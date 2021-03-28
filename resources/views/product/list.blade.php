<?php
//echo "<pre>";
//print_r($listProduct);
//echo "</pre>";
//exit;
?>
@extends('master')
@section('title','Bánh Trung Thu Kinh Đô')

@section('css')
<link href="{!!url('vendors/nice-select/css/nice-select.css')!!}" rel="stylesheet">
@stop


@section('header')
@parent
@include('layouts.header')
@stop

@section('content')
<!--================End Main Header Area =================-->
<section class="banner_area">
    <div class="container">
        <div class="banner_text">
<!--            <h3>Shop</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
            </ul>-->
        </div>
    </div>
</section>
<!--================End Main Header Area =================-->

<!--================Product Area =================-->
<section class="product_area p_100">
    <div class="container">
        <div class="row product_inner_row">
            <div class="col-lg-9 col-md-9">
                <div class="row m0 product_task_bar"> 
                    <div class="product_task_inner"> 
                        <div class="float-left">
                            <!--<a class="active" href="#"><i class="fa fa-th-large" aria-hidden="true"></i></a>-->
<!--                            <a href="#"><i class="fa fa-th-list" aria-hidden="true"></i></a>-->
                            <span>Tổng cộng: {!!count($listProduct)!!} sản phẩm</span>
                        </div>
                        <div class="float-right">
                            <h4>Sắp xếp theo:</h4>
                            <select class="short" onchange="return window.location.href = 'banh-trung-thu-kinh-do?sort_by='+ $(this).val(); ">
                                <option value="all" data-display="Tất cả">Tất cả</option>
                                <option value="title-ascending">Ký tự từ A - Z</option>
                                <option value="title-descending">Ký tự từ Z - A</option>
                                <option value="price-ascending">Giá từ thấp đến cao</option>
                                <option value="price-descending">Giá từ cao xuống thấp</option>
                                <option value="created-descending">Mới nhất</option>
                                <option value="created-ascending">Cũ nhất</option>
                            </select>
                            <p id="demo"></p>
                        </div>
                    </div>
                </div>
                <div class="row product_item_inner">
                    @if($listProduct)
                    @foreach($listProduct as $product)
                    <?php
//                    echo "<pre>";
//                    print_r($product);
//                    echo "</pre>";
//                    exit;
                    ?>
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="cake_feature_item">
                            <div class="cake_img">
                                <img src="{!!url('images/upload/product/'.$product['image'])!!}" alt="{!!$product['name']!!}">
                            </div>
                            <div class="cake_text">
                                <h4>
								<?php
								if($product['unit_price'] > 0){
								?>
									{!!number_format($product['unit_price'])!!} <sup>đ</sup>
								<?php
								}else{
									echo "Giá: liên hệ";
								}
								?>
								</h4>
                                <h3>{!!$product['name']!!}</h3>
                                <a class="pest_btn" href="{!!url('san-pham/'.$product['product_type']['slug'].'/'.$product['slug'])!!}">Chi Tiết</a>
                                <?php
								if($product['unit_price'] > 0){
									?>
									<a class="pest_btn" href="{!!route('themgiohang', $product['id'])!!}">Đặt Hàng</a>
									<?php
								}else{
								?>
								<a class="pest_btn" href="{!!url('/lien-he')!!}">Liên Hệ</a>
								<?php
								}
								?>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
<!--                <div class="product_pagination">
                    <div class="left_btn">
                        <a href="#"><i class="lnr lnr-arrow-left"></i> New posts</a>
                    </div>
                    <div class="middle_list">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">12</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="right_btn"><a href="#">Older posts <i class="lnr lnr-arrow-right"></i></a></div>
                </div>-->
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="product_left_sidebar">
                    <aside class="left_sidebar p_catgories_widget jteck-sidebar">
                        <div class="p_w_title">
                            <h3>Hotline</h3>
                        </div>
                        <ul class="list_style">
                            <li><a href="tel:0917966067"><i class="fa fa-phone" aria-hidden="true"></i> 091 796 6067 (Ms. Phụng)</a></li>
                            <li><a href="tel:0967931680"><i class="fa fa-phone" aria-hidden="true"></i> 0967 931 680 (Ms. Nga)</a></li>
                        </ul>
                    </aside>
                    
                    <aside class="left_sidebar p_catgories_widget jteck-sidebar">
                        <div class="p_w_title">
                            <h3>Bánh Trung Thu</h3>
                        </div>
                        <ul class="list_style">
                            @if($category)
                            @foreach($category as $cate)
                            <li><a href="{!!url('san-pham/'.$cate->slug)!!}">{!!$cate->name!!}</a></li>
                            @endforeach
                            @endif
                        </ul>
                    </aside>
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Area =================-->


@stop
@section('scripts')

@stop