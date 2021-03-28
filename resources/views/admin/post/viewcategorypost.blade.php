<?php
function categoryPostTree($current_id, $parent_id = 0, $submark = '') {
    $query = App\Categorypost::getListCategoryParent($parent_id);
    if ($query) {
        foreach ($query as $count => $catepost) {
            ?>
             <option value="{!! $catepost->id !!}" <?php echo ($catepost->id == $current_id) ? "selected" : "" ?> >{!! $submark.$catepost->title !!}</option>
            <?php
            categoryPostTree($current_id, $catepost->id, $submark . '---- ');
        }
    }
}
?>
@extends('admin.dashboard')
@section('title', 'Edit Category Post')
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
                                <h3>Edit Category</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Post</li>
                                    <li>Edit Category</li>
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
                    <form action="{!!action('Admin\PostController@editCategoryPost',$id)!!}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
									<ul class="nav nav-tabs" role="tablist">
									  <?php $count=1;?>
									  @if(config('app.locales'))
										@foreach(config('app.locales') as $lang)
										  <li class="{{($count++==1)?'active':''}}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
										@endforeach
										@endif
									  </ul>
									  <div class="tab-content">
									  <?php $count=1;?>
									  @if(config('app.locales'))
									    @foreach(config('app.locales') as $key=>$lang)
										<div class="{{($count++==1)?'active':''}} tab-pane" id="tab_{{$lang}}">
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Title</label>
												<input type="text" name="language-{{$key}}-title" placeholder="Enter Category Title" value="@if(isset($viewCategoryPost[$key-1])){!!$viewCategoryPost[$key-1]['title']!!}@endif">
											</div>
											
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Slug</label>
												<input type="text" name="language-{{$key}}-slug" placeholder="Enter Category Slug" value="@if(isset($viewCategoryPost[$key-1])){!!$viewCategoryPost[$key-1]['slug']!!}@endif">
											</div>
											
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
												<textarea name="language-{{$key}}-description" class="form-control" id="message" placeholder="Description">@if(isset($viewCategoryPost[$key-1])){!!$viewCategoryPost[$key-1]['description']!!}@endif</textarea>
											</div>
										</div>
										@endforeach
										@endif
									  </div>
                                    
                                    


                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="select">Category</label>
                                    <select class="form-control" id="select" name="parent_id">
                                        <option value="0">Chưa Phân Loại</option>
                                            
                                            <?php
                                            echo categoryPostTree($viewCategoryPost1['parent_id']);
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                        <div class="add-product-image-upload">
                                            <label>Image</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-upload-image">
                                                        <img src="{!!url('images/upload/post/'.$viewCategoryPost1['image'])!!}" alt="" width="300px" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-upload-action">
                                                        <div class="product-upload btn btn-info">
                                                            <p>
                                                                <i class="fa fa-upload"></i>
                                                                Upload Another Image
                                                            </p>
                                                            <input type="file" name="image" value="">
                                                            <input type="hidden" name="url" value="{!!$viewCategoryPost1['image']!!}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/post/listcategorypost')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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