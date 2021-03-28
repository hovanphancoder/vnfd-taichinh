<?php
//echo "<pre>";
//print_r($listmenu);
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
                                <h3>Menus {!!$getcatemenu->title_vn!!}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li><a href="{!!url('admin/menu/list')!!}">Menu</a></li>
                                    <li>{!!$getcatemenu->title_vn!!}</li>
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
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function categoryTree($parent_id = 0, $submark = '') {
                                    $id_cate = Request::segment(4);
                                    $query = App\Menu::getParentMenuAdmin($id_cate, $parent_id);
                                    //dd($query);
                                    if ($query) {
                                        foreach ($query as $count => $catepost) {
                                            ?>
                                            <tr>
                                                <td><?php echo $count + 1; ?></td>
                                                <td><a href="{!!url('admin/menu/detailmenu/'.$catepost->id)!!}" class="page-table-success"><?php echo $submark.$catepost->title ?></a></td>
                                                <td><?php echo $catepost->catename ?></td>
                                                <td><?php echo $catepost->created_at ?></td>
                                                <td>
                                                    <a href="{!!url('admin/menu/detailmenu/'.$catepost->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
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
        window.location.assign("{!!url('admin/menu/delete')!!}" + "/" + id);
    } else {
        txt = "You pressed Cancel!";
    }
}
</script>
@endsection