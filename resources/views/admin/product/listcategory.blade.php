<?php
//echo "<pre>";
//print_r($listProduct);
//echo "</pre>";
//exit;
?>

@extends('admin.dashboard')

@section('title', 'Category')

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

                                <h3>Product Category management </h3>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="seipkon-breadcromb-right">

                                <ul>

                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>

                                    <li>Product</li>

                                    <li>All Category</li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @if(Session::has('status'))
                <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {!!Session::get('status')!!}
        </div>
        @endif

        <!-- End Breadcromb Row -->
		<section class="content-header">
            <div class="content-header-left">
                <a href="{!!url('admin/product/categoryproduct/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
                <a id="move_trash" href="javascript:void(0)" class="btn btn-bordered-default"><i class="fa fa-trash" aria-hidden="true"></i> Move to trash</a>
        </div>
        <div class="content-header-right">
            <div style="text-align: right; float: right;">
                <div class="seipkon-breadcromb-right-no">
                    <form action="{!! action('Admin\ProductController@index') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <ul>
                        <li><a href="{!!url('admin/product/category')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a></li>
                    </ul>
                    </form>
                </div>
            </div>
        </div>
		</section>

        <!-- Pages Table Row Start -->

        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%"><input type="checkbox" id="listid"></th>
                                    <th width="2%">No</th>
                                    <th width="10%">Name</th>
                                    <th width="25%">Description</th>
                                    <th width="5%">Feature</th>
                                    <th width="7%">Publish Date</th>
                                    <th width="7%">Update Date</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function categoryProductTree($parent_id = 0, $submark = '') {
                                    $query = App\ProductType::getListCategoryParent($parent_id);
                                    // dd($query);
                                    $count = 0;
                                    if ($query) {
                                        foreach ($query as $count => $catepost) {
                                            $count++;
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="item" name="listid" value="{!! $catepost->id !!}"></td>
                                                <td><?php echo $count; ?></td>
                                                <td><a href="{!!url('admin/product/category/'.$catepost->id)!!}" class="page-table-success"><?php echo $submark.$catepost->name ?></a></td>

                                                <td>
                                                    <?php echo (session('locale') == 'en') ? $catepost->description_en : $catepost->description ?>
                                                </td>
                                                <td class="item_feature">
                                                    <?php
                                                        echo ($catepost->feature == 1)?'<i class="fa fa-check-square-o" aria-hidden="true"></i>':'';
                                                    ?>
                                                </td>
                                                <td><?php echo $catepost->created_at ?></td>
                                                <td><?php echo $catepost->updated_at ?></td>
                                                <td>
                                                    <a href="{!!url('admin/product/category/'.$catepost->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete(<?php echo $catepost->id?>)"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            categoryProductTree($catepost->id, $submark . '---- ');
                                        }
                                    }
                                }
                                echo categoryProductTree();
                                ?>
                            </tbody>
                        </table>
						
                    </div>
					<!-- Pagination -->
						<div class="row">
							<div class="col-md-12">
								<div class="page-box">
									<div class="pagination-example">
										<nav aria-label="Page navigation" class="navi">
											<?php 
											echo $listCategory->links();
											?>
										</nav>
									</div>
								</div>
							</div>
						</div>
						<!-- End Pagination -->
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
            window.location.assign("{!!url('admin/product/category/delete/')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
    $(document).ready(function(){
    // move to trash
        $('#move_trash').click(function(e){
            $('#move_trash').attr('disabled', true);
            var allVal = [];
            $('input[name="listid"]:checked').each(function(){
                allVal.push($(this).val());
            });
            if(allVal.length <= 0){
                 $('#move_trash').attr('disabled', false);
                return false;
            }
            // console.log(allVal);
            // e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{!! url('admin/product/category/delete/all') !!}",
                method: 'get',
                data: {
                    listid: allVal,
                    _token: "{!! csrf_token() !!}",
                },
                success: function (data) {
                    $(location).attr("href", "{!! url('admin/product/category') !!}");
                    $('#move_trash').attr('disabled', false);
                }
            });
        });
    });
</script>

<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>



@endsection