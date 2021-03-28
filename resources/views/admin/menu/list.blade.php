<?php
//echo "<pre>";
//print_r($listcate);
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

                                <h3>All Menu</h3>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="seipkon-breadcromb-right">

                                <ul>

                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>

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

                    <div class="table-responsive">

                        <table id="page-list" class="table table-bordered">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Name</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($listcate as $count => $cate)

                                <tr>

                                    <td>{!!$count+1!!}</td>

                                    <td><a href="{!!url('admin/menu/catemenu/'.$cate->id)!!}" class="page-table-success">{!!$cate->title_vn!!}</a></td>

                                    <td>

                                        <a href="#" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>

                                        <a class="btn btn-primary" title="Delete" onclick="myDelete({!!$cate->id!!})"><i class="fa fa-trash"></i></a>

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

            window.location.assign("{!!url('admin/menu/deletecatemenu')!!}" + "/" + id);

        } else {

            txt = "You pressed Cancel!";

        }

    }

</script>

@endsection