<?php
//dd($listPost)
//dd($getPage);
?>
@extends('master')
{{--  @section('title',$post->title)  --}}

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
                            <h4 class="text-center">{{$getPage->title}}</h4>
                        </div>
                        <ul>
                            @if( $listPost)
                            @foreach( $listPost as $aboutArticle)
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
                            <li><a href="{!! url('/') !!}"><i class="fas fa-home"></i> @lang('detail.home')</a></li>
                            {{-- <li><a href="{!! url($getPage->slug) !!}">{!! $getPage->title !!}</a></li> --}}
                            <li class="active">{!! $getPage->title !!}</li>  
                        </ul>
                    </div>
                <!-- End Breadcrumb -->
   
                        <div class="team-area default-padding bottom-less">
                                <div class="row">
                                    
                                    <div class="team-items text-center team-standard ">
                                  
                                        <h2>Thành viên hội đồng quản trị</h2>
                                        <!-- Single Item -->
                                        
                                        {{-- @if($listPost) --}}
                                        <div class="col-md-12 col-sm-12 single-item">
                                            <div class="item">
                                                <div class="thumb"><a href="{!! url($listPost[0]->slug) !!}">
                                                    <img src="{!! url('images/upload/post/'.$listPost[0]->image) !!}" width="300px" alt="Thumb">
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <h4>{!! $listPost[0]->title !!}</h4>
                                                    <div>
                                                         {!! $listPost[0]->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Single Item -->
                                        <!-- Single Item -->
                                        @for ($i = 1; $i < count($listPost); $i++)
                                                <div class="col-md-6 col-sm-6 single-item">
                                                    <div class="item">
                                                        <div class="thumb"><a href="{!! url($listPost[$i]->slug) !!}">
                                                            <img src="{!! url('images/upload/post/'.$listPost[$i]->image) !!}" width="300px" alt="Thumb">
                                                        </a>
                                                        </div>
                                                        <div class="info">
                                                            <h4>{!! $listPost[$i]->title !!}</h4>
                                                            <div>
                                                                {!! $listPost[$i]->description !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endfor
                                        <!-- End Single Item -->
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}
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