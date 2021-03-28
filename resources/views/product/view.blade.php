<?php
// dd($getPage);
?>
@extends('master')
@section('title', $getProduct->name)

@section('header')
@parent
@include('layouts.header')
@endsection

@section('css')@endsection

@section('content')
<!-- Page Title/Header Start -->
<div class="learts-mt-20 learts-pb-10 learts-pt-10 section" data-bg-color="#f8f8f8">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-title">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{!! url($getProduct->cate_slug) !!}">{!! $getProduct->cate_name !!}</a></li>
                        <li class="breadcrumb-item active">{!! $getProduct->name !!}</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page Title/Header End -->

 <!-- Single Products Section Start -->
<div class="section border-bottom learts-mt-20">
    <div class="container">
        <div class="row learts-mb-n40">

            <!-- Product Images Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-images">
                    <div class="product-gallery-slider">
                        <div class="product-zoom" data-image="assets/images/product/single/1/product-zoom-1.jpg">
                            <img src="{!! asset('images/upload/product/'.$getProduct->image) !!}" alt="">
                        </div>
                        <!-- <div class="product-zoom" data-image="assets/images/product/single/1/product-zoom-2.jpg">
                            <img src="assets/images/product/single/1/product-2.jpg" alt="">
                        </div>
                        <div class="product-zoom" data-image="assets/images/product/single/1/product-zoom-3.jpg">
                            <img src="assets/images/product/single/1/product-3.jpg" alt="">
                        </div>
                        <div class="product-zoom" data-image="assets/images/product/single/1/product-zoom-4.jpg">
                            <img src="assets/images/product/single/1/product-4.jpg" alt="">
                        </div> -->
                    </div>
                    <!-- <div class="product-thumb-slider">
                        <div class="item">
                            <img src="assets/images/product/single/1/product-thumb-1.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="assets/images/product/single/1/product-thumb-2.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="assets/images/product/single/1/product-thumb-3.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="assets/images/product/single/1/product-thumb-4.jpg" alt="">
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- Product Images End -->

            <!-- Product Summery Start -->
            <div class="col-lg-6 col-12 learts-mb-40">
                <div class="product-summery">
                    <h1 class="product-title">{!! $getProduct->name !!}</h1>
                    <div class="product-price">$38.00</div>
                    <div class="product-description">
                        <p>{!! $getProduct->description !!}</p>
                    </div>
                    <div class="product-variations">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="label"><span>Quantity:</span></td>
                                        <td class="value">
                                            <div class="product-quantity">
                                                <span class="qty-btn minus"><i class="ti-minus"></i></span>
                                                <input type="text" class="input-qty" value="1">
                                                <span class="qty-btn plus"><i class="ti-plus"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <div class="product-meta">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="label"><span>SKU:</span></td>
                                    <td class="value">{!! $getProduct->sku !!}</td>
                                </tr>
                                <tr>
                                    <td class="label"><span>Category:</span></td>
                                    <td class="value">
                                        <ul class="product-category">
                                            <li><a href="#">{!! $getProduct->cate_name !!}</a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="product-buttons">
                        <a href="#" class="btn btn-dark btn-outline-hover-dark"><i class="fal fa-shopping-cart"></i> Add to Cart</a>
                    </div>
                </div>
            </div>
            <!-- Product Summery End -->

        </div>
    </div>

</div>
<!-- Single Products Section End -->
<div class="section section-padding border-bottom learts-mb-40">
        <div class="container">

            <ul class="nav product-info-tab-list">
                <li><a class="active" data-toggle="tab" href="#tab-description">Description</a></li>
                <li><a data-toggle="tab" href="#tab-additional_information">Specifications</a></li>
            </ul>
            <div class="tab-content product-infor-tab-content">
                <div class="tab-pane fade show active" id="tab-description">
                    <div class="row">
                        <div class="col-lg-10 col-12 mx-auto">
                            {!! $getProduct->content !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-additional_information">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 col-12 mx-auto">
                            <div class="table-responsive">
                                <ul>
                                    <li>Indoor/Outdoor</li>
                                    <li>Natural ageing</li>
                                    <li>Waterproof (under request)</li>
                                    <li>Frost proof</li>
                                    <li>Drainage hole</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('footer')
@parent
@include('layouts.footer')
@endsection
@section('scripts')
@endsection