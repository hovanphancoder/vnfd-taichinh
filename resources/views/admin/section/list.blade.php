<?php



//echo "<pre>";



//print_r($sectionservices);



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



                                <h3>Section Services</h3>



                            </div>



                        </div>



                        <div class="col-md-6 col-sm-6">



                            <div class="seipkon-breadcromb-right">



                                <ul>



                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>



                                    <li>Section</li>



                                    <li>Section Services</li>



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



                                    <th>No.</th>

                                    <th>ID.</th>



                                    <th>Title</th>



                                    <th>Description</th>



                                    <th>Page</th>



                                    <th>Action</th>



                                </tr>



                            </thead>



                            <tbody>



                                @foreach($sectionlist as $count => $section)



                                <tr>



                                    <td>{!!$count+1!!}</td>

                                    <td>{{ $section->id }}</td>

                                    <td><a href="{!!url('admin/section/view/'.$section->id)!!}" class="page-table-success">{!!(Session('locale')=="en")?$section->title_en:$section->title!!}</a></td>



                                    <td>{!!(Session('locale')=="en")?$section->description_en:$section->description!!}</td>



                                    <td>{!!$section->name!!}</td>



                                    <td>



                                        <a href="{!!url('admin/section/view/'.$section->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>



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







@endsection

