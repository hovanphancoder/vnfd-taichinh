<?php
// dd($bannerslide);
?>
<!-- Start Banner 
============================================= -->
<div class="banner-area">
    <div id="bootcarousel" class="carousel text-center slide carousel-fade animate_text" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner text-light carousel-zoom">
        @php
            //dd($bannerslide);
        @endphp
            @if($bannerslide)
                @foreach($bannerslide as $keyBanner => $bannertop)
                <div class="item{!! ($keyBanner == 0)?' active':'' !!}">
                    <div class="slider-thumb bg-cover" style="background-image: url({!! url('images/upload/bannerslides/'.$bannertop->image) !!});"></div>
                    <div class="box-table shadow dark">
                        <div class="box-cell">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="content">
                                       {!! $bannertop->description !!}
                                            <a data-animation="animated slideInUp" class="btn btn-theme effect btn-md" href="{!! url($bannertop->link) !!}">@lang('home.detail')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <!-- End Wrapper for slides -->
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#bootcarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#bootcarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<!-- End Banner -->