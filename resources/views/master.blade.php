<?php
// dd($getCategorypost);
use Jenssegers\Agent\Agent;
$agent = new Agent();
?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <!-- PAGE TITLE HERE -->
        <title>@yield('title')</title>
        <!-- ========== Meta Tags ========== -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="http://tcvn.tuvanthietkeweb.net/images/upload/1603095697-logo-vfg.jpg" type="image/x-icon">
		<link rel="apple-touch-icon" href="http://tcvn.tuvanthietkeweb.net/images/upload/1603095697-logo-vfg.jpg">
        @section('meta')
        @show
         <!-- ========== Start Stylesheet ========== -->
        <link href="{!! url('css/bootstrap.min.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/font-awesome.min.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/flaticon-set.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/magnific-popup.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/owl.carousel.min.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/owl.theme.default.min.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/animate.css') !!}" rel="stylesheet" />
        <link href="{!! url('css/bootsnav.css') !!}" rel="stylesheet" />
 
        <link href="{!! url('css/style.css') !!}" rel="stylesheet">
        <link href="{!! url('css/responsive.css') !!}" rel="stylesheet" />
               <link href="{!! url('css/custom.css') !!}" rel="stylesheet">
        <!-- ========== End Stylesheet ========== -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="{ url('js/html5/html5shiv.min.js') !!}"></script>
          <script src="{ url('js/html5/respond.min.js') !!}"></script>
        <![endif]-->

        <!-- ========== Google Fonts ========== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        <!-- ========== End Stylesheet ========== -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="{!! url('js/html5/html5shiv.min.js') !!}"></script>
          <script src="{!! url('js/html5/respond.min.js') !!}"></script>
        <![endif]-->

        <!-- ========== Google Fonts ========== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
        @section('css')
        @show
        @section('tracking')
        @show
    </head>

    <body>
        @section('header')@show
        @section('banner')@show
        @yield('content')
        @section('footer')@show
        <!-- jQuery Frameworks
        ============================================= -->
        <script src="{!! url('js/jquery-1.12.4.min.js') !!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="{!! url('js/equal-height.min.js') !!}"></script>
        <script src="{!! url('js/jquery.appear.js') !!}"></script>
        <script src="{!! url('js/jquery.easing.min.js') !!}"></script>
        <script src="{!! url('js/jquery.magnific-popup.min.js') !!}"></script>
        <script src="{!! url('js/modernizr.custom.js') !!}"></script>
        <script src="{!! url('js/owl.carousel.min.js') !!}"></script>
        <script src="{!! url('js/wow.min.js') !!}"></script>
        <script src="{!! url('js/progress-bar.min.js') !!}"></script>
        <script src="{!! url('js/isotope.pkgd.min.js') !!}"></script>
        <script src="{!! url('js/imagesloaded.pkgd.min.js') !!}"></script>
        <script src="{!! url('js/count-to.js') !!}"></script>
        <script src="{!! url('js/YTPlayer.min.js') !!}"></script>
        <script src="{!! url('js/bootsnav.js') !!}"></script>
        <script src="{!! url('js/main.js') !!}"></script>
        @section('script')@show

        <script>  
        $(document).ready(function() {
          $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
          });
        });
          var flag_search = true;
           var input = document.getElementById("keyword");
          function jRedirect(url){
              var keyword = $('#keyword').val();
              if(url == '')
                return;
              return window.location = url + '?keyword=' + keyword;
          }
            // disable enter press


            
            $('#sendemail').click(function(){
              var email=$('#email').val();
              $.ajax({
                    {{--  tye -> phuong thuc truyen du lieu  --}}
                type: "GET", 
                    {{--  url -> xu ly logic --}}
                url: "{!! route('loadajax.subcribe') !!}",
                    {{--  data du lieu gui di  --}}
                data:{
                  email:email
                },
                
                success : function(data){
          
                    if(data!=''){
                        console.log(data.result);
                        
                            if(typeof(data.result)=='string'){
                                $('#thongbao').html('<p style="text-align:left; color: #28a745 !important"><i style="  font-size: 20px;  padding: 10px;" class="fas fa-check-circle"></i>'+data.result+'</p>');    
                                $('#formLetter')[0].reset();  
                            }
                            if(typeof(data.result)=='object'){
                               
                                $.each(data.result,function(index,value){
                                    $('#thongbao').html('<p style="text-align:left; color: #FF2D1B !important"><i style=" padding: 10px;   font-size: 20px;" class="fas fa-exclamation-triangle"></i>'+value+'</p>');      
                                })
                            }
                    }
                }
              })
            });



</script>
        {{--  <div id="fb-root"></div>  --}}
        {{--  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=1585132541763914&autoLogAppEvents=1" nonce="JAlxtw3f"></script>  --}}
        </body>
</html>
