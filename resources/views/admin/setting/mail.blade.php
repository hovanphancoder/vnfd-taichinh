<?php
$setmail = json_decode($mail->config);
// echo "<pre>";
// print_r($mail);
// echo "</pre>";
// exit;
?>
@extends('admin.dashboard')
@section('title', 'Page Title')
@section('assets')

@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        @if($errors->has())
        @foreach ($errors->all() as $error)
        <div style="color: red">{{ $error }}</div>
        @endforeach
        @endif
        <!-- Breadcromb Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="breadcromb-area">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-left">
                                <h3>Setting Mail</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>setting</li>
                                    <li>Mail</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\SettingController@setMail')!!}" method="post">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Enter name" value="{!!$setmail->name!!}" >
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" placeholder="Enter title" value="{!!$setmail->title!!}" >
                                    </div>
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" name="from" placeholder="Enter from" value="{!!$setmail->from!!}" >
                                    </div>
                                    <div class="form-group">
                                        <label>Cc</label>
                                        <input type="text" name="cc" placeholder="Enter cc" value="{!!$setmail->cc!!}" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/dashboard')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- End Pages Table Row -->

    </div>
</div>

<!-- Footer Area Start -->
<footer class="seipkon-footer-area">
    @include('admin/layouts/footer')
</footer>
<!-- End Footer Area -->
@endsection