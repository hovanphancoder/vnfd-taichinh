<?php
//echo "<pre>";
//print_r($viewcategorypost);
//echo "</pre>";
//exit;
?>
@extends('admin.dashboard')
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
                                <h3>Edit Category</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Post</li>
                                    <li>Edit Collection</li>
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
        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\CollectionController@doAddCollectionPost')!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <img class="marrig5" src="http://localhost/vuongtron/public/admin_assets/img/{!!session('locale')!!}.png"><label>Title</label>
                                        <input type="text" name="title_{!!session('locale')!!}" placeholder="Enter Page Title" value="" >
                                    </div>
                                    <div class="form-group">
                                        <img class="marrig5" src="http://localhost/vuongtron/public/admin_assets/img/{!!session('locale')!!}.png"><label class="control-label" for="message">Description</label>
                                        <textarea name="description_{!!session('locale')!!}" class="form-control" id="message" placeholder="Description"></textarea>
                                    </div>



                                </div>
                            </div>

                            <div class="col-md-3">
                                
                            </div>

                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Publish</button>
                                <a class="btn btn-default" href="{!!url('admin/post/listcategorypost')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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