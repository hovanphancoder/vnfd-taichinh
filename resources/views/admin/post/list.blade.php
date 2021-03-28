@extends('admin.dashboard')

@section('title', 'All Posts')

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

                                <h3>All Post</h3>

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

        <!-- Start Filter -->
        @include('admin.layouts.filter')
        <!-- End Filter -->

        <!-- Pages Table Row Start -->

        <div class="row">

            <div class="col-md-12">

                <div class="page-box">

                    <div class="table-responsive">

                        <form action="" method="post">

                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">

                        <table id="page-list" class="table table-bordered">

                            <thead>

                                <tr>

                                    <th width="3%">No</th>

                                    <th width="33%">Title</th>

                                    <th width="15%">Category</th>

                                    <th width="5%">Feature</th>

                                    <th width="5%">Order</th>

                                    <th width="10%">Publish Date</th>

                                    <th width="10%">Update Date</th>

                                    <th width="7%">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($listpost as $count => $post)

                                

                                <?php

                                        $id_cate = '';

//                                        echo Request::get('id_cate');

                                        if(Request::get('id_cate') != 0){

                                            $id_cate = '?id_cate='.Request::get('id_cate');

                                        }

//                                        echo $id_cate;

//                                        exit;

                                        

//                                        exit;

//                                        if(isset(Request::get('id_cate'))){

//                                            $id_cate = '?id_cate='.Request::get('id_cate');

//                                        }else{

//                                            $id_cate = '';

//                                        }

                                        ?>

                                <tr>

                                    <td>{!!$count+1!!}</td>

                                    <td><a href="{!!url('admin/post/view/'.$post->id.$id_cate)!!}" class="page-table-success">{!!$post->title!!}</a></td>

                                    <td>{!!$post->namecate!!}</td>

                                    <td>{!!($post->feature == 1)?'Feature':''!!}</td>

                                    <td>

                                        <input disabled="" style="width: 100%; text-align:center" type='text' name='orderby' value="{!!$post->orderby!!}">

                                        

                                    </td>

                                    <td>{!!date('d/m/Y H:i:s', strtotime($post->created_at))!!}</td>

                                    <td>{!!date('d/m/Y H:i:s', strtotime($post->updated_at))!!}</td>

                                    <td>

                                        

                                        <a href="{!!url('admin/post/view/'.$post->id.$id_cate)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>

                                        <a target="blank" href="{!!url('/'.$post->slug)!!}" class="page-table-view" data-toggle="tooltip" title="View"><i style="font-size: 18px;color: #f220d685;" class="fa fa-eye"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$post->id!!})"><i class="fa fa-trash"></i></a>

                                        <!--<button style="border: none; background-color: #FFF;" type="submit"><i class="fa fa-save"></i></button>-->

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                                            

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <!-- Pagination -->

        <div class="row">

            <div class="col-md-12">

                <div class="page-box">

                    <div class="pagination-example">

                        <nav aria-label="Page navigation" class="navi">

                            <?php 

                            echo $listpost->appends(['id_cate' => Request::input('id_cate')])->links();

                            ?>

                        </nav>

                    </div>

                </div>

            </div>

        </div>

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

        window.location.assign("{!!url('admin/post/delete')!!}" + "/" + id);

        } else {

            txt = "You pressed Cancel!";

        }

    }

    

    jQuery(document).ready(function(){

        jQuery("#order").change(function(){

          alert("The text has been changed.");

        });

      });

</script>

<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>

@endsection