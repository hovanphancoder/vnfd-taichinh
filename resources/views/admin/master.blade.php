<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="">
        <!-- Title -->
        <title>@yield('title')</title>
        @section('meta')
        @show
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="{!!url('admin_assets/img/logo.png')!!}">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/css/animate.min.css')!!}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/css/bootstrap.min.css')!!}">
        <!-- Font awesome CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/font-awesome/font-awesome.min.css')!!}">
        <!-- Themify Icon CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/themify-icons/themify-icons.css')!!}">
        <!-- Perfect Scrollbar CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css')!!}">
        <!-- Jvector CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/jvector/css/jquery-jvectormap.css')!!}">
        <!-- Daterange CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/daterangepicker/css/daterangepicker.css')!!}">
        <!-- Bootstrap-select CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/bootstrap-select/css/bootstrap-select.min.css')!!}">
        <!-- Summernote CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/summernote/css/summernote.css')!!}">
        <!-- Main CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/css/seipkon.css')!!}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/css/responsive.css')!!}">
        <!-- Sweet Alerts CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/plugins/sweet-alerts/css/sweetalert.css')!!}">
        <!-- Customize CSS -->
        <link rel="stylesheet" href="{!!url('admin_assets/css/styles.css')!!}">
        @yield('assets')

    </head>
    <body>

        <!-- Wrapper Start -->
        <div class="wrapper">
            <!-- Main Header Start -->
            <header class="main-header">

                <!-- Logo Start -->
                <!--                <div class="seipkon-logo">
                                    <a href="#">
                                        <img src="{!!url('admin_assets/img/logo.png')!!}" alt="logo">
                                    </a>
                                </div>-->
                <!-- Logo End -->

                <!-- Header Top Start -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="header-top-section">
                            <div class="pull-left">

                                <!-- Collapse Menu Btn Start -->
                                <button type="button" id="sidebarCollapse" class=" navbar-btn">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <!-- Collapse Menu Btn End -->
                                <!-- Collapse Menu Btn Start -->
                                <a target="_blank" href="{!! url('/') !!}" id="sidebarHome" class="type navbar-btn">
                                    <i class="fa fa-home"></i>
                                </a>
                                <!-- Collapse Menu Btn End -->

                            </div>
                            <div class="header-top-right-section pull-right">
                                <ul class="nav nav-pills nav-top navbar-right">

                                    
                                    <!--<li>
                                        <a class="dropdown-toggle profile-toggle" href="#" data-toggle="dropdown">
                                            <div class="profile-avatar-txt">
                                                <p>
                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><?php echo (session('locale') == 'en')?'English':'Vietnamese'; ?>
                                                </p>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                        </a>
                                        <div class="profile-box dropdown-menu animated bounceIn">
                                            <ul>
                                                <!--<li><a href="{!!url('language/en')!!}">English</a></li>--
                                                <li><a href="{!!url('language/vn')!!}">Vietnamese</a></li>
                                            </ul>
                                        </div>
                                    </li>-->
                                    <!-- Full Screen Btn Start -->
                                    <li>
                                        <a href="#"  id="fullscreen-button">
                                            <i class="fa fa-arrows-alt"></i>
                                        </a>
                                    </li>
                                    <!-- Full Screen Btn End -->
                                    <!-- Profile Toggle Start -->
                                    <li class="dropdown">
                                        <a class="dropdown-toggle profile-toggle" href="#" data-toggle="dropdown">
                                            <img src="{!!url('images/upload/users/'.Auth::user()->image)!!}" class="profile-avator" alt="admin profile" />
                                            <div class="profile-avatar-txt">
                                                <p>Admin</p>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                        </a>
                                        <div class="profile-box dropdown-menu animated bounceIn">
                                            <ul>
                                                <!--<li><a href="#"><i class="fa fa-user"></i> view profile</a></li>-->
                                                <li><a href="{!!url('admin/user/profile')!!}"><i class="fa fa-pencil-square-o"></i> Edit profile</a></li>
<!--                                                <li><a href="#"><i class="fa fa-flash"></i> Activity Log</a></li>
                                                <li><a href="#"><i class="fa fa-wrench"></i> Setting</a></li>-->
                                                <li><a href="{!!url('admin/logout')!!}"><i class="fa fa-power-off"></i> sign out</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- Profile Toggle End -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- Header Top End -->

            </header>
            <!-- Main Header End -->

            <!-- Sidebar Start -->
            <div class="page-content">
                <aside class="seipkon-main-sidebar">
                    <nav id="sidebar">
                        <div class="sidebar-profile clearfix">
                            @include("admin/layouts/sidebar")                            
                        </div>

                        <div class="menu-section">
                            <h3>General</h3>
                            @include("admin/layouts/menus")
                        </div>
                    </nav>
                </aside>

            </div>
            <!-- End Sidebar -->

            <!-- Right Side Content Start -->
            <section id="content" class="seipkon-content-wrapper">
                @yield('content')
            </section>
            <!-- End Right Side Content -->

        </div>
        <!-- End Wrapper -->


        <!-- jQuery -->
        <script src="{!!url('admin_assets/js/jquery-3.1.0.min.js')!!}"></script>
        <!-- Bootstrap JS -->
        <script src="{!!url('admin_assets/plugins/bootstrap/bootstrap.min.js')!!}"></script>
        <!-- Bootstrap-select JS -->
        <script src="{!!url('admin_assets/plugins/bootstrap-select/js/bootstrap-select.min.js')!!}"></script>
        <!-- Daterange JS -->
        <script src="{!!url('admin_assets/plugins/daterangepicker/js/moment.min.js')!!}"></script>
        <script src="{!!url('admin_assets/plugins/daterangepicker/js/daterangepicker.js')!!}"></script>
        <!-- Jvector JS -->
        <script src="{!!url('admin_assets/plugins/jvector/js/jquery-jvectormap-1.2.2.min.js')!!}"></script>
        <script src="{!!url('admin_assets/plugins/jvector/js/jquery-jvectormap-world-mill-en.js')!!}"></script>
        <script src="{!!url('admin_assets/plugins/jvector/js/jvector-init.js')!!}"></script>
        <!-- Raphael JS -->
        <script src="{!!url('admin_assets/plugins/raphael/js/raphael.min.js')!!}"></script>
        <!-- Morris JS -->
        <script src="{!!url('admin_assets/plugins/morris/js/morris.min.js')!!}"></script>
        <!-- Sparkline JS -->
        <script src="{!!url('admin_assets/plugins/sparkline/js/jquery.sparkline.js')!!}"></script>
        <!-- Chart JS -->
        <script src="{!!url('admin_assets/plugins/charts/js/Chart.js')!!}"></script>
        <!-- Datatables -->
        <script src="{!!url('admin_assets/plugins/datatables/js/jquery.dataTables.min.js')!!}"></script>
        <!-- Perfect Scrollbar JS -->
        <script src="{!!url('admin_assets/plugins/perfect-scrollbar/jquery-perfect-scrollbar.min.js')!!}"></script>
        <!-- Vue JS -->
        <script src="{!!url('admin_assets/plugins/vue/vue.min.js')!!}"></script>
        <!-- Summernote JS -->
        <script src="{!!url('admin_assets/plugins/summernote/js/summernote.js')!!}"></script>
        <script src="{!!url('admin_assets/plugins/summernote/js/custom-summernote.js')!!}"></script>
        
        <!-- Custom JS -->
        <script src="{!!url('admin_assets/js/seipkon.js')!!}"></script>
		@yield('assetjs')
    </body>


</html>