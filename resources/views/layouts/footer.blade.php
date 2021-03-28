<?php
$header = json_decode($header->config);
$footer_option = json_decode($footer->config);
$footer_social = json_decode($social->config);
//dd($quicklink);
?>
<!-- Start Footer 
============================================= -->
<footer class="bg-light">
    <!-- Start Footer Top -->
    <div class="footer-top bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 logo">
                    <a href="{!! url('/') !!}"><img src="{!! url('images/upload/'. $header->logo) !!}" alt="Logo"></a>
                </div>
                <div class="col-md-8 col-sm-8 form text-right">
                    
                    <form  id="formLetter">
                        <div class="input-group stylish-input-group">
                            <input type="email" placeholder="Enter your email" class="form-control" id="email" name="email">
                            <span class="input-group-addon">
                                <button type="button" id="sendemail" name="sendemail">
                                   @lang('general.sign-up')<i class="fa fa-paper-plane"></i>
                                </button>  
                            </span>
                        </div>
                        
                        <span  id="thongbao"></span>
               
                            
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <div class="container">
        <div class="row">
            <div class="f-items default-padding">

                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                    <div class="f-item">
                        <h4>
                            @lang('general.about-us')
                        </h4>
						<h5>@lang('general.content-about')</h5>
                        <div class="social">
                            <ul>
                                @if($footer_social)
                                    @php
                                      //  dd($footer_social)
                                    @endphp

                                    @foreach($footer_social as $social_key =>$socialItem)
                                          @php
                                        //dd($social_key)
                                    @endphp
                                        @if($social_key =='facebook')
											<li><a target="_blank" href="{!! url($socialItem) !!}"><i class="fab fa-facebook-f"></i></a></li>
										@endif	

										@if( $social_key =='twitter')
                                			<li><a target="_blank" href="{!! url($socialItem) !!}"><i class="fab fa-twitter"></i></a></li>
										@endif	
										@if( $social_key =='youtube')
                                			<li><a target="_blank" href="{!! url($socialItem) !!}"><i class="fab fa-youtube"></i></a></li>
										@endif	
										@if($social_key =='instagram')
                                			<li><a target="_blank" href="{!! url($socialItem) !!}"><i class="fab fa-instagram"></i></a></li>
										@endif	
                                    @endforeach

                                    	
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                        <div class="f-item link">
                            <h4>@lang('general.quicklink')</h4>
							<?php
                            $quicklink = App\Menu::join('menu_language','menu.id','=','menu_language.menu_id')
                   
                            ->where('id_catemenu', 2)
                            ->where('menu_language.language_id',get_id_locale(Session()->get('locale')))
                            ->get();
							//dd($quicklink);
							?>
                            <ul>
								@foreach($quicklink as $link)
                                <li>
                                    <a href="{!! url($link['link']) !!}">{!! $link['title'] !!}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                    <div class="f-item twitter-widget">
                        <h4>Facebook</h4>
                        <div class="twitter-item">
                            <div class="fb-page" data-href="https://www.facebook.com/JTECKCO/" data-tabs="" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/JTECKCO/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/JTECKCO/">JTECK - Thiết Kế Web</a></blockquote></div>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
            </div>
        </div>
    </div>
    <!-- Start Footer Bottom -->
    <div class="footer-bottom bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>@lang('general.copyright')</p>
                </div>
                {{-- <div class="col-md-6 text-right link">
                    <ul>
                        <li>
                          <a href="#">@lang('general.developer')</a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!-- End Footer -->