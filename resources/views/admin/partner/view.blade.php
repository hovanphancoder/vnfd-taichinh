<?php
// dd($viewPartner);
?>
@extends('admin.dashboard')
@section('title', 'Page Title')
@section('assets')
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Breadcromb Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="breadcromb-area">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-left">
                                <h3>Edit partner</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li>Partner</li>
                                    <li>Edit partner</li>
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
                    <form action="{!!action('Admin\PartnerController@edit', $viewPartner->id)!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" placeholder="Title" value="{!! $viewPartner->title !!}" >
                                    </div>
                                    <div class="form-group">
                                        <label>Position</label>
                                        <input type="text" name="position" placeholder="Position" value="{!! $viewPartner->position !!}" >
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea class="form-control" name="message">{!! $viewPartner->message !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input type="text" name="order" placeholder="Title" value="{!! $viewPartner->orderby !!}" >
                                    </div>
                                    <div class="form-group">
                                        <div class="add-product-image-upload">
                                            <label>Image</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-upload-image">
                                                        <img src="{!!url('images/upload/partner/'.$viewPartner->image)!!}" alt="" width="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-upload-action">
                                                        <div class="product-upload btn btn-info">
                                                            <p>
                                                                <i class="fa fa-upload"></i>
                                                                Upload Another Image
                                                            </p>
                                                            <input type="file" name="image" value="{!!$viewPartner->image!!}">
                                                            <input type="hidden" name="url" value="{!!$viewPartner->image!!}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('387/admin/partner/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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