<?php
//$lang = (session('locale') == 'en')?'en':'vn';
//if($_SERVER['HTTP_HOST'] == "localhost")
//    $pathtinymce = "/vam/public/admin_assets/filemanager/";
//else{
//    $pathtinymce = "http://vam.tuvanthietkeweb.net/public/admin_assets/filemanager/";
//}
?>
@extends('admin.dashboard')
@section('title', 'Edit user')
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
                                <h3>Edit User</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>user</li>
                                    <li>Edit user</li>
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
                    <form action="{!!action('Admin\UserController@edit',$user->id)!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <input type="hidden" name="url" value="{!!$user->image!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Name</label>
                                        <input type="text" name="name" placeholder="Enter name" value='{!!$user->name!!}' >
                                    </div>

                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Email</label>
                                        <input type="text" name="email" placeholder="Enter email" value="{!!$user->email!!}" >
                                    </div>
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Password</label>
                                        <input type="password" name="password" placeholder="Enter password" value="" >
                                    </div>
									<div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Phone</label>
                                        <input type="text" name="phone" placeholder="Enter phone" value="{!!$user->phone!!}" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="select">Role</label>
                                        <select class="form-control" id="select" name="role">
                                            <option value="0" <?php echo ($user->group_id == 0)?"selected":""?>>Unknow</option>
                                            <option value="1" <?php echo ($user->group_id == 1)?"selected":""?>>Admin</option>
                                            <option value="2" <?php echo ($user->group_id == 2)?"selected":""?>>Editor</option>
                                        </select>
                                    </div>
                                <div class="create-page-right">
                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <img src="{!!url('images/upload/users/'.$user->image)!!}" alt="Breadcromb">
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                            <input type="hidden" name="path" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/user/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
@section('assetjs')
<script>
    $.noConflict();
    jQuery(document).ready(function () {


    });
</script>
@endsection