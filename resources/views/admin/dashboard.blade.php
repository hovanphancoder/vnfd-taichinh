@extends('admin.master')
@section('title','Dashboard')
@section('sidebar')
@endsection
@section('content')

<div class="container-fluid">



    <!-- Breadcromb Row Start -->

    <div class="row">

        <div class="col-md-12">

            <div class="breadcromb-area">

                <div class="row">

                    <div class="col-md-6  col-sm-6">

                        <div class="seipkon-breadcromb-left">

                            <h3>Dashboard</h3>

                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6">

                        <div class="seipkon-breadcromb-right">

                            <ul>

                                <li><a href="#">home</a></li>

                                <li>dashboard</li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- End Breadcromb Row -->

    @if(Session::has('status'))
                <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
    <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        {!!Session::get('status')!!}
    </div>
    @endif

    <!-- Widget Row Start -->

    <div class="row">

        <div class="col-md-3">

            <div id="clock" class="widget_card alert">

                <div class="widget_card_header">

                    <span class="widget_close" data-toggle="tooltip" title="Remove" data-dismiss="alert" aria-label="close">

                        <i class="fa fa-times"></i>

                    </span>

                </div>

                <div class="widget_card_body">

                    <p class="date">date</p>

                    <h3 class="time">{!!date("Y/m/d");!!}</h3>

                </div>

            </div>

        </div>

        <!-- End Col -->

        <div class="col-md-3">

            <div id="widget_visitor" class="widget_card alert">

                <div class="widget_card_header">

                    <span class="widget_close" data-toggle="tooltip" title="Remove" data-dismiss="alert" aria-label="close">

                        <i class="fa fa-times"></i>

                    </span>

                </div>

                <div class="widget_card_body">

                    <div class="widget_icon">

                        <i class="fa fa-eye"></i>

                    </div>

                    <div class="widget_text">

                        <h3 class="count">

                            <?php
                            if (!empty($contact)) {

                                $i = 0;

                                foreach ($contact as $count => $val) {

                                    if ($val == date("Y-m-d")) {

                                        $i++;
                                    }
                                }

                                echo $i;
                            } else
                                echo 0;
                            ?>

                        </h3>

                        <p>Total contact</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- End Widget Row -->



    <!-- Widget Row Start -->

    <div class="row">

        <div style="min-height: 600px;"></div>



    </div>

    <!-- End Widget Row -->

    <!-- Footer Area Start -->

    <footer class="seipkon-footer-area">

        @include('admin/layouts/footer')

    </footer>

    <!-- End Footer Area -->

</div>

@endsection

@section('assetjs')

<!-- Dashboard JS -->

<script src="{!!url('admin_assets/js/dashboard.js')!!}"></script>

@endsection



