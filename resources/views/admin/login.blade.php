<!DOCTYPE html>

<html lang="en">



    <!-- Mirrored from themescare.com/demos/seipkon-admin-template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Jul 2018 11:10:18 GMT -->

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="description" content="" />

        <meta name="keywords" content="" />

        <meta name="author" content="">

        <!-- Title -->

        <title>JTECK</title>

        <!-- Favicon -->

        <!--<link rel="icon" type="image/png" sizes="32x32" href="{!!url('admin_assets/img/favicon/favicon-32x32.png')!!}">-->

        <!-- Animate CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/css/animate.min.css')!!}">

        <!-- Bootstrap CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/plugins/bootstrap/bootstrap.min.css')!!}">

        <!-- Font awesome CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/plugins/font-awesome/font-awesome.min.css')!!}">

        <!-- Themify Icon CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/plugins/themify-icons/themify-icons.css')!!}">

        <!-- Perfect Scrollbar CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css')!!}">

        <!-- Main CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/css/seipkon.css')!!}">

        <!-- Responsive CSS -->

        <link rel="stylesheet" href="{!!url('admin_assets/css/responsive.css')!!}">

    </head>

    <body class="body_white_bg">



        <!-- Start Page Loading -->

        <div id="loader-wrapper">

            <div id="loader"></div>

            <div class="loader-section section-left"></div>

            <div class="loader-section section-right"></div>

        </div>

        <!-- End Page Loading -->



        <!-- Login Page Header Area Start -->

        <div class="seipkon-login-page-header-area">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-4 col-sm-4">

                        <div class="login-page-logo">

                            <a href="index-2.html">

                                <img src="{!!url('admin_assets/img/logo.png')!!}" alt="Seipkon Logo" />

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Login Page Header Area End -->



        <!-- Login Form Start -->

        <div class="seipkon-login-form-area">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-4 col-md-offset-4">

                        <div class="login-form-box">

                            <h3>Sign In</h3>

                            @if(session('login'))

                            <div class="alert alert-info">{{session('login')}}</div>

                            @endif



                            <form action="{!!action('Admin\LoginController@doLogin')!!}" method="post" >

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">

                                    <input type="text" placeholder="Email" class="form-control" name="email" required >

                                </div>

                                <div class="form-group">

                                    <input type="password" placeholder="Password" class="form-control" name="password" required >

                                </div>

                                <div class="form-group form-checkbox">

                                    <input type="checkbox" id="chk_2">

                                    <!--<label class="inline control-label" for="chk_2">Remember me</label>-->

                                    <!--p class="lost-pass pull-right">

                                        <a href="{!!url('admin/remember')!!}">forget you password?</a>

                                    </p-->

                                </div>

                                <div class="form-group">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-layout-submit">

                                                <button type="submit" >Sign in</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Login Form End -->



        <!-- jQuery -->

        <script src="{!!url('admin_assets/js/jquery-3.1.0.min.js')!!}"></script>

        <!-- Bootstrap JS -->

        <script src="{!!url('admin_assets/plugins/bootstrap/bootstrap.min.js')!!}"></script>

        <!-- Perfect Scrollbar JS -->

        <script src="{!!url('admin_assets/plugins/perfect-scrollbar/jquery-perfect-scrollbar.min.js')!!}"></script>

        <!-- Custom JS -->

        <script src="{!!url('admin_assets/js/seipkon.js')!!}"></script>

    </body>



    <!-- Mirrored from themescare.com/demos/seipkon-admin-template/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Jul 2018 11:10:18 GMT -->

</html>