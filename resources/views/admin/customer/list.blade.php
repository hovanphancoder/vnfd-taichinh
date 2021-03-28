<?php
// dd($customerlist);
use App\District;
use App\Province;
use App\Users;
?>
@extends('admin.dashboard')
@section('title', 'Customer list')
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
                                <h3>All Contact</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Contact</li>
                                    <li>all Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
        <section class="content-header">
            <div style="text-align: right; float: left;">
                <a href="{!!url('admin/customer/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
                <a href="{!!url('admin/customer/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
            </div>
            <div style="text-align: right; float: right;">
                <div class="seipkon-breadcromb-right-no">
                    <form action="#" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <ul>
                        <!-- <li><input class="form-control" placeholder="Name" id="text-field" type="text" name="keyword" value="">
                        </li> -->
                        <li>
                            <select name="customer_type" id="customer_type" class="form-control" onchange="return window.location.href = 'list?type='+ $(this).val(); ">
                                <option value="">Customer type</option>
                                <option value="1" {!! (Request::input('type') == 1)?'selected':'' !!}>Người mua hàng</option>
                                <option value="2" {!! (Request::input('type') == 2)?'selected':'' !!}>Người nhận hàng</option>
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
                        <!-- <li>
                            <button type="submit" class="btn btn-default">Search</button>
                        </li> -->
                        <li><a id="export" href="{!! route('customer.export', 'type='.Request::input('type')) !!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-th-list"></span> Export</a></li>
                    </ul>
                    </form>
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
                                    <th>No</th>
                                    <th>Code</th>
                                    <th width="10%">Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th width="8%">Member</th>
                                    <th width="7%">Type</th>
                                    <th>Address</th>
                                    <th>District</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customerlist as $count => $customer)
                                <tr>
                                    <td>{!!$count + 1!!}</td>
                                    <td>{!!$customer->customer_code!!}</td>
                                    <td><a href="{!!url('admin/customer/view/'.$customer->id)!!}" class="page-table-success">{!!$customer->name!!}</a></td>
                                    <td>{!!$customer->phone!!}</td>
                                    <td>{!!$customer->email!!}</td>
                                    <td>
                                        <?php
                                        $user = Users::getUserCustomer($customer->id);
                                        if($user){
                                            echo "Thành viên";
                                        }else{
                                            echo "Khách vãng lai";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo ($customer->customer_type == 1)?'Người mua':'Người nhận';
                                        ?>
                                    </td>
                                    <td>{!!$customer->address!!}</td>
                                    <td>
                                        <?php
                                        $district = District::find($customer->district);
                                        echo $district['name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $city = Province::find($customer->city);
                                        echo $city['name'];
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{!!url('admin/customer/view/'.$customer->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-primary" title="Delete" onclick="myDelete({!!$customer->id!!})"><i class="fa fa-trash"></i></a>
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

<script>
    function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
            window.location.assign("{!!url('admin/customer/delete/')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
@endsection