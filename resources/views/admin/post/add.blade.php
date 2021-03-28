<?php
function categoryTree($parent_id = 0, $submark = '') {
    $query = App\Categorypost::getListCategoryParent($parent_id);
    if ($query) {
        foreach ($query as $catepost) {
            ?>
            <option value="{!!$catepost->id!!}"><?php echo $submark.$catepost->title; ?></option>
            <?php
            categoryTree($catepost->id, $submark . '---- ');
        }
    }
}
?>
@extends('admin.dashboard')
@section('title', 'Add Post')
@section('assets')
<script src="{!!url('admin_assets/tinymce/js/tinymce/tinymce.min.js')!!}"></script>
<script>
    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#mytextarea_1', height: 500,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak", "code searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        toolbar2: "fontsizeselect | forecolor backcolor | responsivefilemanager | link unlink anchor | image media | fullscreen preview code",
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        image_advtab: true,
        relative_urls: false,
        nowrap: false,
        filemanager_sort_by: "date",
        filemanager_descending: 1,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        external_filemanager_path: "<?php echo url(pathFilemanger()); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{{asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')}}"}
    });

    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#mytextarea_2', height: 500,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        toolbar2: "fontsizeselect | forecolor backcolor | responsivefilemanager | link unlink anchor | image media | fullscreen preview code",
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        image_advtab: true,
        relative_urls: false,
        nowrap: false,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        /*external_filemanager_path: "/~jpwebseo/projects/vtgroup/public/admin_assets/filemanager/",*/
        external_filemanager_path: "<?php echo url(pathFilemanger()); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{{asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')}}"}
    });


</script>
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
                                <h3>Add Post</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="#">home</a></li>
                                    <li>post</li>
                                    <li>Add post</li>
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
                    <form action="{!!action('Admin\PostController@doAdd')!!}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
							<input type="hidden" name="track_id" value="<?php echo generateBarcodeNumber(); ?>">
                            <div class="col-md-9">
                                <div class="create-page-left">
									<ul class="nav nav-tabs" role="tablist">
									  <?php $count=1;?>
										@if(config('app.locales'))
										@foreach(config('app.locales') as $key => $lang)
										  <li class="{!! ($key==1)?'active':'' !!}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
										@endforeach
										@endif
                                        <li class=""><a href="#general-child" role="tab" data-toggle="tab" aria-expanded="false">General</a>
									  </ul>
									<div class="tab-content">
                                        <?php $count=1;?>
                                      @if(config('app.locales'))
                                        @foreach(config('app.locales') as $key=>$lang)
                                        <div class="tab-pane {!! ($key==1)?'active':'' !!}" id="tab_{{$lang}}">
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Title</label>
                                                <input type="text" name="language-{{$key}}-title" placeholder="Enter Post Title" value='' @if($lang=='vi')required @endif>
                                            </div>
                                            
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Slug</label>
                                                <input type="text" name="language-{{$key}}-slug" placeholder="Enter Post Slug" value=''>
                                            </div>
                                            
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
                                                <textarea name="language-{{$key}}-description" class="form-control" id="message" placeholder="Description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Nội dung</label>
                                                <textarea maxlength="255" name="language-{{$key}}-content" id="mytextarea_{{$key}}"></textarea>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
										<div class="tab-pane" id="general-child">
											<div class="page-box">
												<div class="button-page-box">
													<div class="button-page-box-heading">
														<h4>SEO Supporting</h4>
					   <!--                                 <p>
														   Turn a button into a dropdown toggle with some basic markup changes.
														</p>-->
													</div>
													<div class="button-page-box-content">
														<div class="row">
															<div class="col-md-12">
																<div class="create-page-left">
																	<div class="form-group">
																		<label>Title</label>
																		<input id="seotitle" type="text" name="seotitle" placeholder="SEO Title" value='' >
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="form-group">
																		<label>Keyword</label>
																		<input type="text" name="seokeyword" placeholder="SEO Keyword" value='' >
																	</div>
																	<div class="form-group">
																		<label class="control-label" for="seodescription">Description</label>
																		<textarea name="seodescription" class="form-control" id="seodescription" placeholder="SEO Description"></textarea>
																		<p id="textare_feedback"></p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									  
									  </div>
                                    

                                </div>

                                
                            </div>

                            <div class="col-md-3">
                                <div class="create-page-right">
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="select">Category</label>
                                        <select class="form-control" id="select" name="category">
											<option value="0">Chưa phân loại</option>
                                            <?php
                                            echo categoryTree();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-checkbox">
                                        <input name="feature" type="checkbox" id="chk_1"/>
                                        <label class="inline control-label" for="chk_1">Feature</label>
                                    </div>
									
                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <img src="{!!url('images/upload/post/defaultimage.jpg')!!}" alt="Breadcromb">
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                        </div>
                                    </div>
                                    <div class="widget_card_page fileupload-buttonbar margin-top-15">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Gallery image</label><br>
                                        <span class="btn btn-success product-upload">
                                            <i class="fa fa-plus"></i>
                                            <span>Upload Gallery</span>
                                            <input type="file" name="galleries[]" id="uploadMultiple" multiple>
                                        </span>
                                        <table role="presentation" class="table table-striped">
                                            <tbody class="d-flex files">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Publish</button>
                                <a class="btn btn-default" href="{!!url('admin/post/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
	
    jQuery('#datepicker').daterangepicker({
        singleDatePicker: true,
		locale: {
			format: 'DD-MM-YYYY'
		}
//        autoUpdateInput: false,
    });

    jQuery(document).ready(function () {
        jQuery('#uploadMultiple').on('change', function () {
            var filesAmount = this.files.length;

            for (var i = 0; i < filesAmount; i++) {
                var html = '<tr class="preview">' +
                        '<td class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><img width="70" height="70" class="preview-image"></td>' +
                        '<td  class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><a href="javascript:void(0)" class="btn btn-danger delete-image"><i class="fa fa-trash"></i></a></td>';
                jQuery('.files').append(html);
                jQuery('.files img.preview-image').last().attr('src', URL.createObjectURL(this.files[i]));
            }
        });

        jQuery(document).on('click', 'a.delete-image', function (e) {
            e.preventDefault();
            jQuery(this).closest('tr.preview').remove();
        });


        jQuery('#submitEditPost').on('click', function (e) {
            e.preventDefault();
            let newGalleries = [];
            jQuery("img.preview-image").each(function (index) {
                if (jQuery(this).attr('alt') !== undefined) {
                    newGalleries.push(jQuery(this).attr('alt'));
//                console.log(jQuery(this).attr('alt'));
                }
            });
            jQuery('#newGalleries').val(JSON.stringify(newGalleries));
//        console.log(jQuery('#newGalleries').val());
//        return false;
            jQuery('#editPostForm').submit();
        });
    })
</script>
@endsection
