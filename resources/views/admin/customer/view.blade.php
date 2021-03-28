<?php
// dd($viewcustomer);
?>
@extends('admin.dashboard')
@section('title', 'Edit customer')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
                                <h3>Edit Customer</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="index-2.html">home</a></li>
                                    <li>customer</li>
                                    <li>Edit Customer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        @if(Session::has('errors'))        
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            @foreach (Session::get('errors') as $error)       
                {!! $error.'<br>' !!}
            @endforeach
            </div>     
        @endif    
        @if (Session::has('result'))
            <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                {!! Session::get('result') !!}
            </div>
        @endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\CustomerController@edit', $viewcustomer->id)!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="customer_code" placeholder="ID" value="{!! $viewcustomer->customer_code?$viewcustomer->customer_code:goGenID() !!}" >
                            <div class="add-product-image-upload">
                                <div class="col-md-9">
                                    <div class="create-page-left">                                    
                                        <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input class="form-control" type="text" name="name" placeholder="Name" value="{!!$viewcustomer->name!!}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input class="form-control" type="text" name="phone" placeholder="Mobile" value="{!!$viewcustomer->phone!!}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email *</label>
                                                        <input class="form-control" type="text" name="email" placeholder="email" value="{!!$viewcustomer->email!!}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input class="form-control" type="text" name="address" placeholder="Address" value="{!!$viewcustomer->address!!}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <select name="province" id="province" onclick="getDistrict()" class="form-control city" >
                                                            <option value="">Tỉnh/Thành</option>
                                                            @if(isset($province))
                                                            @foreach($province as $item)
                                                                <option value="{!! $item->id !!}" data-id="{!! $item->id !!}" {!! ($item->id == $viewcustomer->city)?'selected':'' !!}>
                                                                    {!! $item->name !!}
                                                                </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>District</label>
                                                        <select name="district" id="district" class="form-control city" >
                                                            <option value="">Tỉnh/Thành</option>
                                                            @if(isset($district))
                                                            @foreach($district as $district_item)
                                                                <option value="{!! $district_item->id !!}" data-id="{!! $district_item->id !!}" {!! ($district_item->id == $viewcustomer->district)?'selected':'' !!}>{!! $district_item->name !!}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Company</label>
                                                        <input class="form-control" type="text" name="company" placeholder="Company" value="{!! $viewcustomer->company !!}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>MST</label>
                                                        <input class="form-control" type="text" name="mst" placeholder="MST" value="{!!$viewcustomer->mst!!}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contact name</label>
                                                        <input class="form-control" type="text" name="contact" placeholder="Contact name" value="{!!$viewcustomer->contact!!}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Position</label>
                                                        <input class="form-control" type="text" name="position" placeholder="Position" value="{!!$viewcustomer->position!!}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-wrap">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tel</label>
                                                        <input class="form-control" type="text" name="tel" placeholder="Tel" value="{!!$viewcustomer->tel!!}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fax</label>
                                                        <input class="form-control" type="text" name="fax" placeholder="Fax" value="{!!$viewcustomer->fax!!}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="message">Comment</label>
                                                    <textarea name="notes" class="form-control" id="notes" placeholder="Description">{!!$viewcustomer->notes!!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="create-page-right">
                                        <div class="page-img-upload">
                                            <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                            <img src="{!!url('images/upload/customer/'.$viewcustomer->image)!!}" alt="Image">
                                            <div class="product-upload btn btn-info">
                                                <i class="fa fa-upload"></i>
                                                Upload Image
                                                <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                                <input type="hidden" class="custom-file-input form-control" id="currentfile" name="currentfile" value="{!!$viewcustomer->image!!}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/customer/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- End Pages Table Row -->

    </div>
</div>

<!-- Footer Area Start -->
<footer class="seipkon-footer-area">
    @include('admin/layouts/footer')
</footer>
<!-- End Footer Area -->
@endsection
@section('assetjs')
<script type="text/javascript">
  function getDistrict(){
    // console.log('dasdas');
        $("#district").find("option").remove();
        var data = {
            province_id: $('#province').val()
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{!! url('admin/customer/quan-huyen') !!}",
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            // convert data to object
            data: JSON.stringify(data),
            success: function (data) {
                console.log(data);
                if(data.listDistrict){
                    $('#district').append('<option value="">Chọn Quận / Huyện</option>');
                    $.each(data.listDistrict, function (i, v) {
                        $('#district').append('<option value="'+ v['id'] +'">'+v['name']+'</option>');
                    });
                }
            },
            fail: function (data) {
                $('.alert').html(data);
            }
        });
    }
</script>
@endsection