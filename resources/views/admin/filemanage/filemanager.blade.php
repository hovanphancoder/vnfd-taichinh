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
                                <h3>All File</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>File</li>
                                    <li>all File</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
        <div class="row">
            <div class="col-md-12">
                <iframe width="100%" height="650px" frameborder="0" src="{!!url('admin_assets/filemanager/dialog.php?ype=2&sort_by=date&descending=1')!!}">
                </iframe>
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