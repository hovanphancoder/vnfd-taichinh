@extends('admin.dashboard')
@section('title', 'All Orders')
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
                                <h3>All Order</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Order</li>
                                    <li>All Order</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
		<section class="content-header">
            <div class="content-header-left">
    			<div>
    				<a href="{!!url('admin/order/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
    				<a href="{!!url('admin/order/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
    				
    			</div>
            </div>
        @if (Session::has('status'))
            <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                {!! Session::get('status') !!}
            </div>
        @endif
		<div class="content-header-right">
			<div style="text-align: right">
				<div class="seipkon-breadcromb-right-no">
					<form action="{!!action('Admin\OrderController@index')!!}" method="POST">
					<input type="hidden" name="_token" value="{!!csrf_token()!!}">
					<ul>
						<li><input class="form-control" placeholder="Customer Name" id="text-field" type="text" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif">
						</li>
						<li>
							<select class="form-control" id="select" name="payment_method">
								<option value="" >Phương thức thanh toán</option>
								<option @if($payment_method == 'Chuyển Khoản') selected @endif value="Chuyển Khoản" >Chuyển Khoản</option>
								<option @if($payment_method == 'Tiền Mặt') selected @endif value="Tiền Mặt" >Tiền Mặt</option>
							</select>
						</li>
						<li>
							<select name="price" class="form-control">
								<option value="">Sắp xếp</option>
								<option @if($price == 'desc') selected @endif value="desc">Giá giảm dần</option>
								<option @if($price == 'asc') selected @endif value="asc">Giá tăng dần</option>
							</select>
						</li>
						<li>
							<button type="submit" class="btn btn-default">Search</button>
						</li>
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
                                    <th width="2%">No</th>
                                    <th width="7%">Mà đơn hàng</th>
                                    <th width="15%">Tên khách hàng</th>
                                    <th width="10%">Điện thoại</th>
                                    <th width="5%">Tạm tính</th>
                                    <th width="5%">Giảm giá</th>
                                    <th width="5%">Tổng Cộng</th>
                                    <th width="10%">Phương Thức Thanh Toán</th>
                                    <th width="10%">Trạng Thái</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders)
                                @foreach($orders as $count => $item)
                                <tr>
                                    <td>{!!$count + 1!!}</td>
                                    <td>{!! $item->order_number !!}</td>
                                    <td><a href="{!!url('admin/order/view/'.$item['order_id'].'?client_id='.$item['cus_id'])!!}" class="page-table-success">{!!$item['name']!!}</a></td>
                                    <td>{!! $item->phone !!}</td>
                                    <td>{!! number_format($item['total_price']) !!} đ</td>
                                    <td>
                                        <?php
                                        if($item['discount_percent'] > 0 && $item['discount_percent'] <= 100){
                                            $discount_percent = ($item['discount_percent'] * $item['total_price']) / 100;
                                        }else{
                                            $discount_percent = $item['discount_percent'];
                                        }
                                        echo number_format($discount_percent).' đ';
                                        ?>
                                    </td>
                                    <td>{!! number_format($item['total_price'] - $item['discount_percent']) !!} đ</td>
                                    <td>{!! $item['payment_method'] !!}</td>
                                    <td>{!! $item['status'] !!}</td>
                                    <td>{!! $item['order_date']!!}</td>
                                    <td class="dropdown order-page">
                                        <a href="{!!url('admin/order/view/'.$item['order_id'].'?client_id='.$item['cus_id'])!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="{!! url('admin/order/delete/'.$item['order_id']) !!}" class="page-table-info" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
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
<script>
    function myDelete(id) {
    var r = confirm("Are you delete!?");
    if (r == true) {
    window.location.assign("{!!url('admin/page/delete')!!}" + "/" + id);
    } else {
    txt = "You pressed Cancel!";
    }
    }
</script>
<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>
@endsection