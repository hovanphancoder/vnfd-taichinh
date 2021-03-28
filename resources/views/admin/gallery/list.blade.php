<?php
//echo "<pre>";
//print_r($listgallery);
//echo "</pre>";
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
                                <h3>All Gallery</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Gallery</li>
                                    <li>All gallery</li>
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
                                    <th width="5%">No</th>
                                    <th width="30%">Title</th>
                                    <th width="20%">Description</th>
                                    <th width="10%">Image</th>
                                    <th width="10%">Publish Date</th>
                                    <th width="10%">Update Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listgallery as $count => $gallery)
                                <tr>
                                    <td>{!!$count+1!!}</td>
                                    <td><a href="{!!url('admin/gallery/view/'.$gallery->id)!!}" class="page-table-success">{!!(Session('locale')=="en")?$gallery->title_en:$gallery->title!!}</a></td>
                                    <td>{!!$gallery->description!!}</td>
                                    <td><img src="{!!url('images/upload/gallery/'.$gallery->image)!!}"></td>
                                    <td>{!!date('d/m/Y H:i:s', strtotime($gallery->created_at))!!}</td>
                                    <td>{!!date('d/m/Y H:i:s', strtotime($gallery->updated_at))!!}</td>
                                    <td>
                                        <a href="{!!url('admin/gallery/view/'.$gallery->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$gallery->id!!})"><i class="fa fa-trash"></i></a>
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
    window.location.assign("{!!url('admin/gallery/delete')!!}" + "/" + id);
    } else {
    txt = "You pressed Cancel!";
    }
    }
</script>
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
@endsection