<?php
//if ($request->method() == "POST") {
//    echo "<pre>";
//    print_r($listpost);
//    echo "</pre>";
////}
//exit;
?>
@extends('admin.dashboard')
@section('title', 'Page Title')
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
                                <h3>All Collection Post</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Post</li>
                                    <li>all Collection</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        <!-- Start Filter -->
        
        <!-- End Filter -->

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%">No</th>
                                    <th width="20%">Title</th>
                                    <th width="20%">Description</th>
                                    <th width="8%">Publish Date</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($getlistcollection as $count => $collection)
                                <tr>
                                    <td>{!!$count+1!!}</td>
                                    <td><a href="{!!url('admin/post/viewcollectionpost/'.$collection->id)!!}" class="page-table-success">{!!(session('locale') == 'en')?$collection->title_en:$collection->title_vn!!}</a></td>
                                    <td>{!!(session('locale') == 'en')?$collection->description_en:$collection->description_vn!!}</td>
                                    <td>{!!$collection->created_at!!}</td>
                                    <td>
                                        <a href="{!!url('admin/post/viewcollectionpost/'.$collection->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$collection->id!!})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <!-- End Pagination -->
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
    window.location.assign("{!!url('admin/post/destroycollectionpost')!!}" + "/" + id);
    } else {
    txt = "You pressed Cancel!";
    }
    }
</script>
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
@endsection