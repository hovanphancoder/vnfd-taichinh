<?php
//$galleries = json_decode($post->galleries);
//dd($getAboutArticle);
//dd($post)

?>
@extends('master')
@section('title',$post->title)

@section('meta')
@include('layouts.meta')
@endsection
{{--  
@section('header_contact')
@include('layouts.header_contact')
@endsection  --}}

@section('header')
@parent
@include('layouts.header')
@endsection

@section('css')
<style>
    .services-single-area .info ul{
       list-style-type: inherit !important;
    }
</style>
@endsection

@section('content')

<!-- Start 404 
    ============================================= -->
    <div class="services-single-area default-padding">
        <div class="container">
            <div class="row " id="page-detail">
           
                <div class="sidebar col-md-4" id="sidebar">
                    <div class="sidebar-item link">
                        <div class="title">
                            <h4 class="text-center">{{$post->titlecate}}</h4>
                        </div>
                        <ul>
                            @if($getAboutArticle)
                            @foreach($getAboutArticle as $aboutArticle)
                            <li><i class="	fas fa-newspaper"></i> <a href="{!! url($aboutArticle->slug) !!}">{!! $aboutArticle->title !!}</a></li>
                            @endforeach
                            @endif 
                        </ul>
                    </div>
                </div>     
                <div class="services-content col-md-8" id="services-content">
                    <!-- Start Breadcrumb 
                        ============================================= -->
                    <div class="breadcrumb-area  text-light">
                        <ul class="breadcrumb">
                            <li><a href="{!! url('/') !!}"><i class="fas fa-home"></i> Trang chủ</a></li>
                             <li><a href="{!! url($post->slugcate) !!}">{!! $post->titlecate !!}</a></li>
                            <li class="active">{!! $post->title !!}</li> 
                        </ul>
                    </div>
                <!-- End Breadcrumb -->
                    <div class="info">
                        <h1>{!! $post->title !!}</h1>
                        {!! $post->content !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End 404 -->

@endsection

@section('footer')
@parent
@include('layouts.footer')
@endsection

@section('scripts')
@endsection