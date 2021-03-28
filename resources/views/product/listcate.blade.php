<?php
// dd($getPage['name']);
?>
@extends('master')
@section('title', !is_null($getPage)?$getPage->title:'')

@section('header')
@parent
@include('layouts.header')
@endsection

@section('css')@endsection

@section('content')
<div class="page-title-section section" data-bg-image="{!! asset('images/upload/page/'.$getPage->image) !!}">
    <div class="container">
        <div class="row">
            <div class="col-6">

                <div class="page-title">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                        <li class="breadcrumb-item active">{!! $getPage->title !!}</li>
                    </ul>
                    <h1 class="title">{!! $getPage->title !!}</h1>
                    <div class="desc">
                        <p>{!! $getPage->description !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="section section-fluid section-padding pt-0 learts-mb-60">
    <div class="container"> 
        <div class="row">
            <div class="col-12">
                <div class="products row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                    @foreach($productCategory as $category)
                    <div class="col">
                        <div class="product">
                            <div class="product-thumb">
                                <a href="{!! url($category['slug']) !!}" class="image">
                                    <img src="{!! asset('images/upload/product/'.$category['image']) !!}" alt="Product Image">
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{!! url($category['slug']) !!}">{!! $category['name'] !!}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
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