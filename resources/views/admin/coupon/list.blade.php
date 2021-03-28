<?php
use App\Products;
use App\ProductType;
?>
@extends('admin.master')
@section('title', 'Coupon list')
@section('assets')
@endsection
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
                                <h3>All voucher code</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>All code</li>
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

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="3%">Code</th>
                                    <th width="3%">Value</th>
                                    <th width="2%">Quantity</th>
                                    <th width="5%">Type unit</th>
                                    <th width="auto">Type discount</th>
                                    <th width="10%">Create Date</th>
                                    <th width="10%">Update Date</th>
                                    <th width="7%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $count => $item)
                                <tr>
                                    <td>{!! $count + 1 !!}</td>
                                    <td><a href="{!!url('admin/coupon/view/'.$item->id)!!}" class="page-table-success">{!!$item->code!!}</a></td>
                                    <td>{!! number_format($item->value) !!}</td>
                                    <td>{!!$item->quantity!!}</td>
                                    <td>{!!$item->type_unit!!}</td>
                                    <td>
                                        <?php
                                        // print_r($item->type_discount);exit;
                                        if($item->type_discount != 'null'){
                                            // dd($item->type_discount);
                                            $type_discount = json_decode($item->type_discount);
                                                if(!empty($type_discount->c)){
                                                    // print_r($type_discount[1]);exit;
                                            // dd($type_discount->c);
                                                    $list_item = ProductType::whereIn('id', $type_discount->c)->select('name')->get()->toArray();
                                                    $type_coupon = "Danh mục";
                                                    // dd($product);
                                                        // echo 'Sản phẩm: <span class="coupon_item">'.$product['name'].'</span>';
                                                }elseif(!empty($type_discount->p)){
                                                    $list_item = Products::whereIn('id', $type_discount->p)->select('name')->get()->toArray();
                                                    $type_coupon = "Sản phẩm";
                                                    // echo 'Danh mục: <span class="coupon_item">'.$category['name'].'</span>';
                                                }else{
                                                    $list_item = "";
                                                    $type_coupon = "";
                                                }
                                                
                                            // $type_discount = explode("_", $item->type_discount);
                                            // dd($type_discount["p"]);
                                            // if($type_discount){
                                            //     print_r($type_discount["p"]);
                                            // }else{
                                            //     $category = ProductType::whereIn('id', $type_discount->c);
                                            //     foreach($category as $category_item){
                                            //         echo $category_item->name.',';
                                            //     }
                                                // if($category){
                                                //     echo '<strong>Danh mục</strong>: '.$category->name;
                                                // }else{
                                                //     echo 'Danh mục sản phẩm đã bị xóa';
                                                // }
                                            // }
                                                if(!empty($list_item)){
                                                    foreach($list_item as $key_coupon => $item_coupon){
                                                        if($key_coupon == 0){
                                                            echo $type_coupon.": ";
                                                        }
                                                        echo '<span class="coupon_item">'.$item_coupon['name'].'</span>';
                                                    }
                                                }
                                        }else{
                                            echo 'Chưa phân loại';
                                        }
                                        ?>
                                    </td>
                                    <td>{!!$item->created_at!!}</td>
                                    <td>{!!$item->updated_at!!}</td>
                                    <td>
                                        <a href="{!!url('admin/coupon/view/'.$item->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-primary" title="Delete" onclick="myDelete({!!$item->id!!})"><i class="fa fa-trash"></i></a>
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

<!-- Sweet Alerts JS -->

<script>
    function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
            window.location.assign("{!!url('admin/coupon/delete/')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
@endsection