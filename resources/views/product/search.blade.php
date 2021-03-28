<?php
// dd($result);
?>
@extends('master')
@section('title','Tìm Kiếm')

@section('meta') 
	@parent
@stop 
@section('header') 
	@parent
	@include('layouts.header') 
@stop 
@section('content')
	<div class="shop-area pt--40 pb--80 pt-sm--30 pb-sm--60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 order-lg-2 mb-md--40">
                            <div class="new-products-area section-sm-padding section-sm-padding">
                                    	<h1 class="title__search">Hiển thị kết quả tìm kiếm cho Từ Khóa "{!! $keyword !!}": <span>có {!! count($result) !!} sản phẩm</span></h1>
                                <div class="container">
                                    <div class="row custom-gutter">
                                    	@if($result)
                                    	@foreach($result as $product)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="product-box product-box-hover-down bg--white color-1">
                                                <div class="product-box__img">
                                                    <a href="{!! url('/'.$product->slug) !!}">
                                                        <img src="{!! url('images/upload/product/'.$product->image) !!}" alt="{!! $product->name !!}" class="primary-image">
                                                        <img src="{!! url('images/upload/product/'.$product->image) !!}" alt="{!! $product->name !!}" class="secondary-image">
                                                    </a>
                                                </div>
                                                <div class="product-box__content">
                                                    <h3 class="product-box__title"><a href="{!! url('/'.$product->slug) !!}">{!! $product->name !!}</a></h3>
                                                </div>
                                                <div class="product-box__footer">
                                                <div class="product-box__price product-box__footer-item">
                                                        @if($product->unit_price > 0)
                                                            @if($product->promotion_price > 0 && $product->promotion_price < $product->unit_price)
                                                                <span class="sale-price">{!! number_format($product->promotion_price) !!} đ</span>
                                                                <span class="regular-price">{!! number_format($product->unit_price) !!} đ</span>
                                                            @else
                                                                <span class="sale-price">{!! number_format($product->unit_price) !!} đ</span>
                                                            @endif
                                                        @else
                                                            <span class="contact-sale">Giá: liên hệ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($product->unit_price > 0)
                                                    <div class="product-box__footer-item">
                                                        {{--                                                    <a href="{!! url('add-to-cart/'.$productCate->product_id) !!}"><span><i class="fa fa-cart-plus"></i></span> <span>Mua Hàng</span></a>--}}
                                                        <button class="addtocart" onclick="addToCart(this)" data-id="{!! $product->id !!}" class="btn add-to-cart btn-style-1 color-1" data-toggle="modal" data-product_title="{!! $product->name !!}" data-target="#productModal" class="productModal" data-backdrop="static" data-keyboard="false"> <span><i class="fa fa-cart-plus"></i></span><span>Mua Hàng</span></button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- San Pham Da Xem -->
            @section('product_view')
                @include('layouts.product_view')
            @stop
            <!-- End San Pham Da Xem -->
	
@stop

@section('scripts')
<script type="text/javascript">
    function getURL(link = ''){
        var url;
        url = window.location.protocol + '//' + window.location.hostname + '/nhatui/public/' + link;
        return url;
    }
    function formatNumber(number) {
        return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function addToCart(elem){
        var dataId = $(elem).data("id");
        var productTitle = $(elem).data("product_title");
        var current_count = $('.mini-cart__count').text();
        $('#mini-cart__footer').empty();
        $('.mini-cart__item--single').remove();
        $('.modal-body').empty();
        $('.soluong').empty();
        $.ajax({
            url: "{!! url('add-to-cart') !!}" + '/' + dataId,
            method: 'get',
            success: function (data) {
                $('.productModal').modal('show');
                $('#empty_cart').remove();
                // console.log(data.fail);
                $(".mini-cart__count").text(parseInt(current_count) + 1);
                $("#soluong").text({!! (Session('cart'))?Session('cart')->totalQty:0 !!});
                var html = '';
                var cart_total = '';
                var current_price;
                var i = 0;
                // html += '<div class="mini-cart__content"><div class="mini-cart__item">';
                if ($.type(data.result) === "object") {
                    $.each(data.result, function (i, v) {
                        if(v['item']['promotion_price'] > 0)
                            current_price = v['item']['promotion_price'];
                        else
                            current_price = v['item']['price'];
                        html += '<div class="mini-cart__item--single">';
                        html += '<div class="mini-cart__item--image">';
                        html += '<a href="#"><img src="'+ getURL('/images/upload/product/') + v['item']['image']+'" alt="img"></a>';
                        html += '</div>';
                        html += '<div class="mini-cart__item--content">';
                        html += '<h4><a href="#"></a>'+v['item']['name']+'</h4>';
                        html += '<p>Số Lượng: <span class="soluong">'+v['qty']+'</span></p>';
                        html += '<p>'+formatNumber(current_price)+' đ</p>';
                        html += '</div>';
                        html += '<a class="mini-cart__item--remove" href="' + getURL('gio-hang/del-cart/') + v['item']['id'] + '"><i class="fa fa-times"></i></a>';
                        html += '</div>';
                    });
                    console.log(data.result.items);
                    // $.each(data.session_cart, function (sc_i, sc_v) {
                    // console.log(sc_i);
                    // console.log(sc_v.totalQty);
                    // console.log(count_click);
                    // if(count_click == 1) {
                    cart_total += '<div class="mini-cart__total">';
                    cart_total += '<h4>';
                    cart_total += '<span class="mini-cart__total--title">Tổng Cộng</span>';
                    cart_total += '<span class="mini-cart__total--ammount" id="thanhtien_head">' + formatNumber(data.session_cart.totalPrice) + ' đ</span>';
                    cart_total += '</h4>';
                    cart_total += '</div>';
                    cart_total += '<div class="mini-cart__btn">';
                    cart_total += '<a href="' + getURL("san-pham/gio-hang") + '" class="btn btn-small btn-icon btn-style-1 color-1">Giỏ Hàng <i class="fa fa-angle-right"></i></a>';
                    cart_total += '<a href="' + getURL("san-pham/thanh-toan") + '" class="btn btn-small btn-icon btn-style-1 color-1">Thanh Toán <i class="fa fa-angle-right"></i></a>';
                    cart_total += '</div>';
                    // }
                    // });
                };
                // html += '</div></div>';
                // console.log(html);

                //if(html != '' || cart_total != ''){
                if(html != '' || cart_total != ''){
                    $('.mini-cart__content').append(html);
                    $('#mini-cart__footer').append(cart_total);
                }
                html = "";
                cart_total = "";
                $('.modal-body').append("<p><i class=\"fa fa-check\"></i> Đã thêm sản phẩm " + productTitle + " vào giỏ Hàng!</p>");
                $('.productModal').modal({backdrop: 'static', keyboard: false})
                // console.log(data.session_cart);
                // console.log(cart_total);
                // j("#thanhtien_head").text(formatNumber(res) + ' đ');
                // j("#thanhtien_cart").text(formatNumber(res) + ' đ');
                // j("#thanh_tien").text(formatNumber(res) + ' đ');
            }
        });
    }
</script>
@stop
