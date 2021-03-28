<?php
// dd($item);
?>
@extends('admin.dashboard')
@section('title', 'Edit Page')
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
                                <h3>Edit Video</h3>
                                <a target="blank" href="">Xem nhanh</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>page</li>
                                    <li>Edit page</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
        
        @if(Session::has('result'))
                <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {!!Session::get('result')!!}
        </div>
        @endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\VideoController@edit',$item->id)!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
									<ul class="nav nav-tabs" role="tablist">
									  <?php $count=1;?>
										@foreach(config('app.locales') as $keyLang => $lang)
										  <li class="{!! ($keyLang == 1)?'active':'' !!}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
										@endforeach
									</ul>
                                   <div class="tab-content">
										<?php $count=1;?>
									    @foreach(config('app.locales') as $key=>$lang)
										<div class="tab-pane {!! ($key == 1)?'active':'' !!}" id="tab_{{$lang}}">
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Name</label>
												<input type="text" name="language-{{$key}}-name" placeholder="Enter Name" value="{!! $viewVideo[$key-1]['name'] !!}">
											</div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="embed">Path</label>
                                                <input type="text" name="language-{{$key}}-path" placeholder="Enter path" value="{!! $viewVideo[$key-1]['path'] !!}">
                                            </div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="embed">Embed</label>
                                                <input type="text" name="language-{{$key}}-embed" placeholder="Enter embed" value="{!! $viewVideo[$key-1]['embed'] !!}">
                                            </div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!! url('admin_assets/img/'.$key.'.png') !!}"><label class="control-label" for="description">Description</label>
                                                <textarea name="language-{{$key}}-description" class="form-control" id="description" placeholder="Description">{!! $viewVideo[$key-1]['description'] !!}</textarea>
                                            </div>
										</div>
										@endforeach
									</div>

                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="create-page-right">
                                    <div class="form-group"></div>
									<div class="form-group"></div>
                                    <div class="form-group form-checkbox"></div>

                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <img src="{!!url('images/upload/video/'.$item->image)!!}" alt="Breadcromb">
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
											<input type="hidden" name="path" value="{!!$item->image!!}">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/video/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
@endsection