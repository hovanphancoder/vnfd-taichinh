
@extends('master')
@section('title',$getPage->title)

@section('meta')
    @include('layouts.meta')
@endsection

@section('header')
    @parent
    @include('layouts.header')
@endsection


@section('banner')
@parent
@include('layouts.bannertop')
@endsection

@section('content')
<!-- Start Our About
    ============================================= -->
    <div class="about-area inc-video default-padding">
        <div class="container">
            <div class="row">
                <!-- Start About -->
                <div class="about-content">
                    <div class="col-md-6 video-info">
                        <div class="thumb">
                            <img src="{!! url('img/about/4.jpg') !!}" alt="Thumb">
                            {{--  <a href="https://www.youtube.com/watch?v=owhuBrGIOsE" class="popup-youtube light video-play-button item-center">
                                <i class="fa fa-play"></i>
                            </a>  --}}
                        </div>
                    </div>
                    <div class="col-md-6 info">
                        <h4>
                            @lang('home.about_us')          
                        </h4>
                        <h2>{!! $getSectionAbout['title'] !!}</h2>
                        <p>{!! $getSectionAbout['description'] !!}</p>
                        <ul>
                            <li>
                                <div class="icon">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <div class="info">
                                    <span>Email</span> <a href="mailto:info@vnfg.com.vn">info@vnfg.com.vn</a>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info">
                                    <span>@lang('home.hotline'):</span> <a href="tel:0904207355">(+84) 904 207 355</a>
                                </div>
                            </li>
                        </ul>
                        <a href="{!! url($getSectionAbout['link']) !!}" class="btn btn-theme effect btn-md" data-animation="animated slideInUp">Chi tiết</a>
                    </div>
                </div>
                <!-- End About -->
            </div>
        </div>
    </div>
    <!-- End Our About -->
@php #dd(App::getLocale('locales')) @endphp
    <!-- Start Portfolio 
    ============================================= -->
    @if($getNewProject && $getNewProject->count()>0)
        <div class="portfolio-area default-padding-top section-height">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2>
                                    @lang('home.project')
                            </h2>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-full">
                <div class="row">
                    <div class="portfolio-items magnific-mix-gallery masonary portfolio-carousel owl-carousel owl-theme">
                    
                        @foreach($getNewProject as $newProject)
                        <div class="pf-item">
                            <div class="effect-left-swipe">
                                <img src="{!! url('images/upload/post/'.$newProject->image) !!}" alt="thumb">
                                <a href="{!! url('images/upload/post/'.$newProject->image) !!}" class="item popup-link"><i class="fa fa-plus"></i></a>
                                <div class="icons">
                                    <h4><a href="{!! url($newProject->slug) !!}">{!! $newProject->title !!}</a></h4>
                                </div>
                            </div>
                        </div>
                        @endforeach
                
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Portfolio -->

    <!-- Start Team Area
    ============================================= -->

    @if($getNhaDauTu && $getNhaDauTu->count()>0)

    <div class="team-area carousel-shadow default-padding section-height">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>
                             @lang('home.investors')          
                        </h2>
                     
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="team-items team-carousel owl-carousel owl-theme text-center team-standard">
                   
                        @foreach($getNhaDauTu as $nhaDauTu)
                        <div class="item">
                            <div class="thumb">
                                {{-- <a href="{!! url('$nhaDauTu->slug') !!}" --}}
                                <img src="{!! url('images/upload/post/'.$nhaDauTu->image) !!}" alt="{!! $nhaDauTu->title !!}">
                                 {{-- </a> --}}
                            </div>
                            <div class="info">
                                <h4> <a href="{!! url('/'.$nhaDauTu->slug) !!}">
                                    {!! $nhaDauTu->title !!}
                                  </a>
                                </h4>
                                <p>{!! str_limit($nhaDauTu->description, $limit = 140, $end = '...')  !!}</p>
                              
                            </div>
                        </div>
                        @endforeach
                    
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End Team Area -->

    <!-- Start Blog Area
    ============================================= -->
       @if($getNews )
    <div class="blog-area default-padding bottom-less section-height" >
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2> @lang('home.news')</h2>
                      
                    </div>
                </div>
            </div>
            <div class="row">
         @php
         @endphp
                @foreach($getNews as $news)
                <div class="col-md-4 single-item">
                    <div class="item">
                        <div class="thumb">
                            <a href="{!! url('/'.$news->slug) !!}">
                                <img src="{!! url('images/upload/post/'.$news->image) !!}"  alt="Thumb"></a>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="{!! url('/'.$news->slug) !!}">{!! $news->title !!}</a>
                            </h4>
                            <p>
                                {!! $news->description !!}
                            </p>
                            <div class="meta">
                                <ul>
                                    <li><i class="fas fa-calendar-alt"></i>{!! date("d/m/Y", strtotime($news->created_at)) !!}</li>
                                    
                                </ul>
                                <a href="{!! url('/'.$news->slug) !!}">
                                @lang('home.detail')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            
            </div>
        </div>
    </div>   
     @endif
    <!-- End Blog Area -->

    <!-- Start Clients Area
    ============================================= -->

    <!-- End Clients Area -->
@endsection

@section('footer')
@parent
@include('layouts.footer')
@endsection
@section('script')
@include('layouts.script')
@endsection