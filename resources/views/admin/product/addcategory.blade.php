<?php
function categoryProductTree($parent_id = 0, $submark = '') {
    $query = App\ProductType::getListCategoryParent($parent_id);
    if ($query) {
        foreach ($query as $count => $catepost) {
            ?>
             <option value="{!! $catepost->id !!}">{!! $submark.$catepost->name !!}</option>
            <?php
            categoryProductTree($catepost->id, $submark . '---- ');
        }
    }
}
?>
@extends('admin.dashboard')
@section('title', 'Add Product')
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
                                <h3>Edit Category Product</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Category</li>
                                    <li>Edit category</li>
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
                    <form action="{!!action('Admin\ProductController@doAddCategory')!!}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="row">
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
												<input type="text" name="language-{{$key}}-name" placeholder="Enter Page Title" value=''>
											</div>
											
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Slug</label>
												<input type="text" name="language-{{$key}}-slug" placeholder="Enter Product Slug" value=''>
											</div>
											
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
												<textarea name="language-{{$key}}-description" class="form-control" id="message" placeholder="Description"></textarea>
											</div>
										</div>
										@endforeach
										@endif
									  </div>
                                    
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="create-page-right">
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Parent</label>
                                        <select class="form-control" id="select" name="parent_id">
                                            <option value="0">Parent</option>
                                            <?php
                                            echo categoryProductTree();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-checkbox">
                                        <input name="feature" type="checkbox" id="feature">
                                        <label class="inline control-label" for="feature">Feature</label>
                                    </div>
                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <img src="{!!url('images/upload/product/defaultimage.jpg')!!}" alt="">
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
                                <a class="btn btn-default" href="{!!url('admin/product/category')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
<script>
    $.noConflict();
    jQuery(document).ready(function () {
//    var text_max = 99;
//    $('#textarea_feedback').html(text_max + ' characters remaining');
        var text_length1 = jQuery('#seotitle').val().length;
        jQuery('#input_feedback1').html(text_length1 + " / 60 ký tự");
        jQuery('#seotitle').keyup(function () {
            var text_length1 = jQuery('#seotitle').val().length;
//        var text_remaining = text_max - text_length;
//    console.log(text_length);
            jQuery('#input_feedback1').html(text_length1 + " / 60 ký tự");
            if (text_length1 > 60) {
                jQuery('#input_feedback1').css('color', 'red')
            } else {
                jQuery('#input_feedback1').css('color', '#242a33')
            }
        });

        var text_length2 = jQuery('#seodescription').val().length;
        jQuery('#textare_feedback').html(text_length2 + " / 180 ký tự");
        jQuery('#seodescription').keyup(function () {
            var text_length2 = jQuery('#seodescription').val().length;
//        var text_remaining = text_max - text_length2;
//    console.log(text_length2);
            jQuery('#textare_feedback').html(text_length2 + " / 180 ký tự");
            if (text_length2 > 180) {
                jQuery('#textare_feedback').css('color', 'red')
            } else {
                jQuery('#textare_feedback').css('color', '#242a33')
            }
        });

    });
</script>
@endsection