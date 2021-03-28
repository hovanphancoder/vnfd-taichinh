@php
    //dd($metaPage)
@endphp
@extends('master')
@section('title',$getPage->title)

@section('meta')

   @include('layouts.meta')
   <meta name="csrf-token" content="{!! csrf_token() !!}" />
@endsection

{{-- @section('header_contact')
@include('layouts.header_contact')
@endsection --}}

@section('header')
@parent
@include('layouts.header')
@endsection

@section('css')
@endsection

@section('content')

<!-- Start Google Maps 
============================================= -->
<div class="maps-area">
    <div class="container-full">
        <div class="row">
            <div class="google-maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2307958889814!2d106.71901151435631!3d10.793627461828454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a8e159ceb7%3A0x3ad2c39f5b90e666!2zMjA4IE5ndXnhu4VuIEjhu691IEPhuqNuaCwgUGjGsOG7nW5nIDIyLCBCw6xuaCBUaOG6oW5oLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1610422387441!5m2!1svi!2s" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>            </div>
        </div>
    </div>
</div>
<!-- End Google Maps -->
<!-- Start Contact Area
============================================= -->
<div class="contact-area default-padding">
    <div class="container">
        <div class="row">
            <div class="contact-items bg-contain">
                <div class="col-md-4 address">
                    <div class="address-items">
                        <ul class="info">
                            <li>
                                <h4>@lang('contact.adress'):</h4>
                                <div class="icon"><i class="fas fa-map-marked-alt"></i></div> 
                                <span>@lang('contact.adress_detail')</span>
                            </li>
                            <li>
                                <h4>@lang('contact.timework'):</h4>
                                <div class="icon"><i class="fas fa-clock"></i> </div>
                                <span>Thứ 2 - Thứ 6: 8h30 - 18h00<br>Thứ 7: 8h30 - 12:00</span>
                            </li>
                            <li>
                                <h4>@lang('contact.phone'):</h4>
                                <div class="icon"><i class="fas fa-phone"></i></div> 
                                <span><a href="tel:0904207355">(+84) 904 207 355</a></span>
                            </li>
                            <li>
                                <h4>Email</h4>
                                <div class="icon"><i class="fas fa-envelope-open"></i> </div>
                                <span><a href="mailto:info@vnfg.com.vn">info@vnfg.com.vn</a></span>
                            </li>
                         
                            <li>
                                <h4>Website</h4>
                                <div class="icon"><i class="fas fa-globe"></i> </div>
                                <span><a href="vnfg.com.vn">vnfg.com.vn</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 contact-form">
                    <div class="notify"></div>
                    <h2>@lang('contact.group')</h2>
                    <form action="" method="POST" id="contactform">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" id="name" name="name" placeholder="Ex: Nguyễn Văn Trường" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="email" name="email" placeholder="Ex: tan@tcvn.com" type="email">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="phone" name="phone" placeholder="Ex: 0906289587" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group comments">
                                    <textarea class="form-control" id="message" name="message" placeholder="Ex: Cần liên hệ hợp tác"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="button"  id='send_contact'>@lang('contact.send') <i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Contact Area -->
@endsection

@section('footer')
@parent
@include('layouts.footer')
@endsection

@section('script')
   <script type="text/javascript">
  
        $("#send_contact").click(function () {
          
            var name=$('#name').val();
            var email=$('#email').val();
            var phone=$('#phone').val();
            var message=$('#message').val();
            $('.notify').text('');
            {{-- e.preventDefault(); --}}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{!!action('ContactController@create')!!}",
                method: 'post',
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    message: message
                },
                success: function (data) {
                    console.log(data.result);
                    $('.notify').addClass('style');
                    $("#contactform").trigger('reset');
                    if ($.type(data.result) === "object") {
                        $.each(data.result, function (i, v) {
                            $('.notify').append('<p><i class="fa fa-exclamation"></i> ' + v + '</p>');
                            console.log(v);
                        });
                        if (data.name != '') {
                            $('#name').val(data.name);
                        }
                        if (data.phone != '') {
                            $('#phone').val(data.phone);
                        }
                        if (data.email != '') {
                            $('#email').val(data.email);
                        }
                        if (data.message != '') {
                            $('#message').val(data.message);
                        }
                    } else {



                        $('.notify').html(data.result);
                    }

        //                    console.log($.type(data.result));
                   console.log(data.result);
                },
                fail: function (data) {
                    $('.notify').html(data.fail);
                }
            });
        });
   
</script>
@endsection