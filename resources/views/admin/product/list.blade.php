<?php
// dd($listProduct->toArray());
function categoryProductTree($parent_id = 0, $submark = '') {
    $cate = App\ProductType::productParentCategory($parent_id);
    // dd($product);
    if ($cate) {
        foreach ($cate as $cateproduct) {
            ?>
            <option value="{!! $cateproduct->id !!}" {!! (Request::input("id_type") == $cateproduct->id)?"selected":"" !!}>{!! $submark . $cateproduct->name !!}</option>
            <?php
            categoryProductTree($cateproduct->id, $submark . '---- ');
        }
    }
}
?>
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@extends('admin.dashboard')
@section('title', 'All Products')
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
                                <h3>All Product</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Product</li>
                                    <li>All Product</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
        @if (Session::has('status'))
            <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                {!! Session::get('status') !!}
            </div>
        @endif
        <section class="content-header">
    		<div class="content-header-left">
                <div class="">
                    <a href="{!!url('admin/product/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
                    <a id="move_trash" href="javascript:void(0)" class="btn btn-bordered-default"><i class="fa fa-trash" aria-hidden="true"></i> Move to trash</a>
                </div>
            </div>
            

		<div class="content-header-right">
			<div style="text-align: right; float: right;">
				<div class="seipkon-breadcromb-right-no">
					<form action="{!! action('Admin\ProductController@index') !!}" method="POST">
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<ul>
						<li><input class="form-control" placeholder="Name" id="text-field" type="text" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif">
						</li>
						<li>
							<select class="form-control" id="id_type" name="id_type">
								<option value="0">Chọn Phân Loại</option>
                                <?php
                                categoryProductTree();
                                ?>
							</select>
						</li>
						<!-- <li>
							<select class="form-control" id="select" name="id_trademark">
								<option value="">Chọn thương hiệu</option>
								@foreach($listTrademark as $count => $producttype)
								<option @if($producttype['id'] == $id_trademark) selected @endif value="{!!$producttype['id']!!}" >{!!$producttype['name']!!}</option>
								@endforeach
							</select>
						</li> -->
						<li>
							<select name="price" class="form-control">
								<option value="">Sắp xếp</option>
								<option @if($price == "desc") selected @endif value="desc">Giá giảm dần</option>
								<option @if($price == "asc") selected @endif value="asc">Giá tăng dần</option>
							</select>
						</li>
						<!--<li>
							<input name="neew" type="checkbox" id="chk_1"/>
                            <label class="inline control-label" for="chk_1">New</label>
						</li>
						<li>
							<input name="feature" type="checkbox" id="chk_2"/>
                            <label class="inline control-label" for="chk_2">Feature</label>
						</li>-->
						<li>
							<button type="submit" class="btn btn-default">Search</button>
						</li>
                        <li><a href="{!!url('admin/product/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a></li>
						<li><a id="export" href="javascript:void(0)" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-th-list"></span> Export</a></li>
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
                                    <th width="5%">No</th>
                                    <th width="18%">Name</th>
									<th width="10%">Price</th>
                                    <th width="10%">Promotion Price</th>
                                    <th width="15%">Category</th>
									<th width="5%">New</th>
									<th width="5%">Feature</th>
                                    <th width="10%">Update Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listProduct as $count => $item)
                                <tr>
                                    <td><input type="checkbox" class="item" name="listid" value="{!! $item['id'] !!}"></td>
                                    <td>{!! $count+1 !!}</td>
                                    <td><a href="{!!url('admin/product/view/'.$item['id'])!!}" class="page-table-success">{!! $item['name']!!}</a></td>
									<td>{!! number_format($item['unit_price']) !!}</td>
                                    <td><strong style="color: #F00">{!! number_format($item['promotion_price']) !!}</strong></td>
                                    <td>
                                        <?php
                                        $category_name = "";
                                        foreach($item['product_type_relationships'] as $key_relation => $relation){
                                            $category = App\ProductType::getCate($relation->type_products_id);
                                            if(is_object($category)){
                                                $category_name .= $category->name.', ';
                                            }else{
                                                $category_name = "Chưa xác định";
                                            }
                                        }
                                        echo rtrim($category_name,', ');
                                        ?>
                                    </td>
									<td>{!! ($item['neew'] == 1)?"New":"" !!}</td>
									<td>{!! ($item['feature'] == 1)?"Feature":"" !!}</td>
                                    <td>{!! $item['updated_at'] !!}</td>
                                    <td>
                                        <a href="{!!url('admin/product/view/'.$item['id'])!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a target="blank" href="{!! url($item['slug']) !!}" class="page-table-view" data-toggle="tooltip" title="View"><i style="font-size: 18px;color: #f220d685;" class="fa fa-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$item['id']!!})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
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
											echo $listProduct->links();
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
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
<script>

    function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
            window.location.assign("{!!url('admin/product/delete')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
    $(document).ready(function(){
        $("#export").click(function(){
			//alert('adsasda');
			var id_type = $('#id_type').val();
			console.log(window.location.protocol + '//' + window.location.hostname + "/admin/product/export/" + id_type);
            
            window.location.assign(window.location.protocol + '//' + window.location.hostname + "/nhatui/public/admin/product/export/" + id_type);
        });
        // process checkbox all
        $("#listid").click(function(){
            $('input.item:checkbox').not(this).prop('checked', this.checked);
        });

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
            // e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{!! url('admin/product/delete/all') !!}",
                method: 'get',
                data: {
                    listid: allVal,
                    _token: "{!! csrf_token() !!}",
                },
                success: function (data) {
                    $(location).attr("href", "{!! url('admin/product/list') !!}");
                    $('#move_trash').attr('disabled', false);
                }
            });
        });


    });
</script>
@endsection