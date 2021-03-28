<?php
//dd($listPost);
//dd($count);
//dd(count($listPost));
//dd($tukhoarong);
?>
@extends('master')
@section('title','Tìm kiếm '.$key)

{{--  @section('header_contact')
@include('layouts.header_contact')
@endsection  --}}
@section('header')

@include('layouts.header')
@endsection
@section('css')
<style type="text/css">
.int_dark_about_section2 {
    {{-- background: url({!! url('images/upload/page/'.$getPage->image) !!}) no-repeat center left; --}}
	background-color: #282d32;
}

</style>
@endsection

@section('content')
<!-- Start Blog Area
	============================================= -->
	@php
		//dd($categoryPost)
	@endphp
    <div class="blog-area default-padding bottom-less page-search">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>@lang('search.search')</h2>
                        <p>

                            @if(!$result)
                                {{--  @lang('search.error')  --}}
                            @endif
                            @if(count($listPost) > 0)
                              @lang('search.result') = "{{$key}}" @lang('search.have') {{count($listPost)}} @lang('search.post')
                            @else
                                @lang('search.not')
                            @endif

                        </p>
                          
                </div>
                </div>
			</div>
			@php
				//dd($getFeatureService)
				
			@endphp
            <div class="row">
                 @if($listPost)
				@foreach($listPost as $listPost)
			
                <div class="col-md-4 single-item custom-img-search">
                    <div class="item">
                        <div class="thumb">
                            <a href="{!! url('$listPost->slug') !!}"><img width="100%" src="{!! url('images/upload/post/'.$listPost->image) !!}"  alt="Thumb"></a>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="{!! url('$listPost->slug') !!}">{!! $listPost->title !!}</a>
                            </h4>
                         
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- End Blog Area -->

@endsection

@section('footer')
@parent
@include('layouts.footer')
@endsection

@section('scripts')
@endsection