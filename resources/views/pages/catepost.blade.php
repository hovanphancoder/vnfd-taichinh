<?php
//dd($getPage);
?>
@extends('master')
@section('title',$getPage->title)

 {{-- @section('meta')
@include('layouts.meta')
@endsection  --}}

{{--  @section('header_contact')
@include('layouts.header_contact')
@endsection  --}}
@section('header')

@include('layouts.header')
@endsection
@section('css')
<style type="text/css">
.int_dark_about_section2 {
    /* background: url({!! url('images/upload/page/'.$getPage->image) !!}) no-repeat center left; */
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
    <div class="blog-area default-padding bottom-less section-height">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
            			<h2>{!! $categoryPost->title !!}</h2>
                        <p>
                            {!! $categoryPost->description !!}
                        </p>
                    </div>
                </div>
			</div>
			@php
				//dd($getFeatureService)
				
			@endphp
            <div class="row">
                @if($getFeatureService)
				@foreach($getFeatureService as $about)
					@php
			//			dd($about->title)
					@endphp
                <div class="col-md-4 single-item custom-img-about">
                    <div class="item">
                        <div class="thumb">
                            <a href="{!! url($about->slug) !!}"><img src="{!! url('images/upload/post/'.$about->image) !!}" alt="Thumb"></a>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="{!! url($about->slug) !!}">{!! $about->title !!}</a>
                            </h4>
                            <p> 
                                {!! str_limit($about->description, $limit = 80, $end = '...')  !!}
                            </p>
                            <div class="meta">
								<ul>
                                    <li><i class="fas fa-calendar-alt"></i>  {!! date("d/m/Y", strtotime($about->created_at)) !!}</li>
                                </ul>
                                <a href="{!! url($about->slug) !!}">@lang('about.detail')</a>
                            </div>
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