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
                                <h3>All Category Post</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Post</li>
                                    <li>all Category</li>
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
				<a href="{!!url('admin/post/listcategorypost')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
				<a href="{!!url('admin/post/addcategorypost')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
				
			</div>
		</section>	
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
                                    <th width="8%">Created Date</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function categoryTree($parent_id = 0, $submark = '') {
                                    $query = App\Categorypost::getListCategoryParent($parent_id);
                                    if ($query) {
                                        foreach ($query as $count => $catepost) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count + 1; ?></td>
                                                <td><a href="{!!url('admin/post/viewcategorypost/'.$catepost->id)!!}" class="page-table-success"><?php echo $submark.$catepost->title ?></a></td>
                                                <td><?php echo (session('locale') == 'en') ? $catepost->description : $catepost->description ?></td>
                                                <td><?php echo $catepost->created_at ?></td>
                                                <td>
                                                    <a href="{!!url('admin/post/viewcategorypost/'.$catepost->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete(<?php echo $catepost->id?>)"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            categoryTree($catepost->id, $submark . '---- ');
                                        }
                                    }
                                }
                                echo categoryTree();
                                ?>
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
    window.location.assign("{!!url('admin/post/destroycatepost')!!}" + "/" + id);
    } else {
    txt = "You pressed Cancel!";
    }
    }
</script>
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
@endsection