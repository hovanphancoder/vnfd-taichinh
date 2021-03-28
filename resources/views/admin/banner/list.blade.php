<?php
//echo "<pre>";
//print_r($listbanner);
//echo "</pre>";
//exit;
?>
@extends('admin.master')
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
                                <h3>All Banner</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Post</li>
                                    <li>all Post</li>
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
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th width="36%">Title</th>
                                    <th width="12%">Type</th>
                                    <th width="10%">Image</th>
                                    <th width="10%">Create Date</th>
                                    <th width="10%">Update Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listbanner as $count => $banner)
                                <tr>
                                    <td>{!!$count+1!!}</td>
                                    <td><a href="{!!url('admin/banner/view/'.$banner->id)!!}" class="page-table-success">{!! $banner->title !!}</a></td>
                                    <td>
                                        <?php
                                        switch($banner->id_cate):
                                            case (1):
                                                echo "Banner Top";
                                                break;
                                            case (2):
                                                echo "Banner Center";
                                                break;
											case (3):
                                                echo "Banner Bottom";
                                                break;
                                            case (4):
                                                echo "Banner Thiết Kế & Thi Công";
                                                break;
                                            case (5):
                                                echo "Banner Nội Thất";
                                                break;
                                            case (6):
                                                echo "Banner Dịch Vụ";
                                                break;
                                            case (7):
                                                echo "Banner Loại Sản Phẩm";
                                                break;
                                            default:
                                                echo "Chưa Phân Loại";
                                        endswitch;
                                        ?>
                                    </td>
                                    <td><img src="{!! url('images/upload/bannerslides/'.$banner->image) !!}" width="150px" /></td>
                                    <td>{!!date('d/m/Y H:i:s', strtotime($banner->created_at))!!}</td>
                                    <td>{!!date('d/m/Y H:i:s', strtotime($banner->updated_at))!!}</td>
                                    <td>
                                        <a href="{!!url('admin/banner/view/'.$banner->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-primary" title="Delete" onclick="myDelete({!!$banner->id!!})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
    function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
            window.location.assign("{!!url('admin/banner/destroy')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
@endsection