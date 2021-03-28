@extends('admin.dashboard')
@section('title', 'Page Title')
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
                                <h3>Import Customer Excel File</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="#">home</a></li>
                                    <li>customer</li>
                                    <li>Import Customer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        @if($errors->has())
        @foreach ($errors->all() as $error)
        <div style="color: red">{{ $error }}</div>
        @endforeach
        @endif
		@if(Session::has('status'))

		<div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">

			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			{!!Session::get('status')!!}
		</div>

		@endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\CustomerController@doImport')!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-12">
                                <div class="create-page-left">                                    
                                    <div class="form-group">
                                        <div class="add-product-image-upload">

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="create-page-left">
                                                        <div class="form-group">
                                                            <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Tệp Excel</label>
                                                            <input type="file" name="file" class="form-control">
                                                        </div>


                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
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