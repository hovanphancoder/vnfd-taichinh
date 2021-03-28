@extends('admin.dashboard')
@section('title', 'Add Banner')
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
                                <h3>Add Banner</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>banner</li>
                                    <li>Add banner</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->
		
		@if(Session::has('status'))
                <!--<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>-->
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            {!!Session::get('status')!!}
        </div>
        @endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\BannerController@create')!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <ul class="nav nav-tabs" role="tablist">
							  <?php $count=1;?>
							  @if(config('app.locales'))
								@foreach(config('app.locales') as $key => $lang)
								  <li class="{{($key==1)?'active':''}}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
								@endforeach
								@endif
							  </ul>
							<div class="tab-content">
						  <?php $count=1;?>
						  @if(config('app.locales'))
							@foreach(config('app.locales') as $key=>$lang) 
							<div class="{{($key==1)?'active':''}} tab-pane" id="tab_{{$lang}}">							
							<div class="col-md-9">
                                <div class="create-page-left">
									
										
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Title</label>
												<input type="text" name="language-{{$key}}-name" placeholder="Enter Page Title" value='' >
											</div>
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Label</label>
												<input type="text" name="language-{{$key}}-label" placeholder="Enter Page Title" value='' >
											</div>
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Link</label>
												<input type="text" name="language-{{$key}}-link" placeholder="Enter Product Slug" value='' >
											</div>
											
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
												<textarea name="language-{{$key}}-description" class="form-control" id="message" placeholder="Description"></textarea>
											</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="select">Category</label>
                                    <select class="form-control" id="select" name="language-{{$key}}-id_cate">
                                        <option value="0">Chưa Phân Loại</option>
                                        <option value="1">Banner Top</option>
                                        <option value="2">Banner Center</option>
                                        <option value="3">Banner Bottom</option>
                                        <option value="4">Banner Thiết Kế Thi Công</option>
                                        <option value="5">Banner Sản Phẩm Nội Thất</option>
                                        <option value="6">Banner Dịch Vụ</option>
                                        <option value="7">Banner Loại Sản Phẩm</option>
                                    </select>
                                </div>
                                <div class="form-group form-checkbox">
                                    <input name="language-{{$key}}-feature" type="checkbox" id="chk_1">
                                    <label class="inline control-label" for="chk_1">Feature</label>
                                </div>
                                <div class="form-group">
                                        <div class="add-product-image-upload">
                                            <label>Image slide</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-upload-action">
                                                        <div class="product-upload btn btn-info">
                                                            <p>
                                                                <i class="fa fa-upload"></i>
                                                                Upload Another Image
                                                            </p>
                                                            <input type="file" name="language-{{$key}}-image" value="">
                                                            <input type="hidden" name="language-{{$key}}-url" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
							</div>
						@endforeach
						@endif
						</div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-plus"></i>Add</button>
                                <a class="btn btn-default" href="{!!url('admin/banner/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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