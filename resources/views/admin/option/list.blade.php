<?php
//echo "<pre>";
//print_r($listProduct);
//echo "</pre>";
//exit;
?>
@extends('admin.dashboard')
@section('title', 'List option')
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
                                <h3>All Option</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Product</li>
                                    <li>List Product Option</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
		<section class="content-header">
			<div style="text-align: right">
				<a href="{!!url('admin/product/option')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
				<a href="{!!url('admin/product/option/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
				
			</div>
		</section>
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
                                    <th width="10%">No</th>
                                    <th >Option Name</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listOptions as $count => $item)
                                <tr>
                                    <td>{!!$count+1!!}</td>
                                    <td><a href="{!!url('admin/product/option/'.$item['id'])!!}" class="page-table-success">{!!$item['name']!!}</a></td>
                                    <td>
                                        <a href="{!!url('admin/product/option/'.$item['id'])!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$item['id']!!})"><i class="fa fa-trash"></i></a>
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
            window.location.assign("{!!url('admin/product/option/delete')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
@endsection