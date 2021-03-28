<?php
// dd($view);
$galleries = json_decode($view->galleries);
//echo "<pre>";
//print_r(json_decode($view->galleries));
//echo "</pre>";
//exit;
//$lang = (session('locale') == 'en')?'en':'vn';

?>
@extends('admin.dashboard')
@section('title', 'Edit Post')
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
                                <h3>Edit Post</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>post</li>
                                    <li>Edit post</li>
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
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="page-box">
                    <form action="{!!action('Admin\PostController@edit',$view->id)!!}" method="post" enctype="multipart/form-data" id="editPostForm">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-9">
                                <div class="create-page-left">
									<ul class="nav nav-tabs" role="tablist">
									  <?php $count=1;?>
                                      @if(config('app.locales'))
                                        @foreach(config('app.locales') as $key => $lang)
                                          <li class="{{ ($key == 1)?'active':'' }}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{!! trans('general.lang_'.$lang) !!}</a></li>
                                        @endforeach
                                        @endif
										<li class=""><a href="#general-child" role="tab" data-toggle="tab" aria-expanded="false">General</a></li>
									</ul>
									<div class="tab-content">
									  <br/> 
                                      <?php $count=1; //echo '<pre>';print_r($viewPost[1]);exit;?> 
                                        @if(config('app.locales'))
                                        @foreach(config('app.locales') as $key=>$lang)
                                        <?php
                                        // dd($viewPost[$key-1]);
                                        ?>
                                        <div class="tab-pane {{ ($key == 1)?'active':'' }}" id="tab_{{$lang}}">
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Title</label>
                                                <input type="text" name="language-{{$key}}-title" placeholder="Enter Name" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["title"]!!}@endif'> 
                                            </div>

                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Slug</label>
                                                <input type="text" name="language-{{$key}}-slug" placeholder="Enter Post Slug" value="@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]['slug']!!}@endif">
                                            </div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
                                                <textarea name="language-{{$key}}-description" class="form-control" id="message" placeholder="Description">@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]['description']!!}@endif</textarea>
                                            </div>

                                            <div class="page-editor-box form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Content</label>
                                                <textarea name="language-{{$key}}-content" id="mytextarea_{{$key}}">@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]['content']!!}@endif</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label class="control-label" for="firstnam55">Diện Tích :</label>
                                                        <input name="language-{{$key}}-dien_tich" class="form-control" placeholder="Mét Vuông" id="dien_tich" type="text" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["dien_tich"]!!}@endif'>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label class="control-label" for="lastnam56">Phòng Ngủ :</label>
                                                        <input name="language-{{$key}}-phong_ngu" class="form-control" placeholder="Số Lượng Phòng Ngủ" id="phong_ngu" type="text" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["phong_ngu"]!!}@endif'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <label class="control-label" for="firstnam55">Ban Công :</label>
                                                        <input name="language-{{$key}}-ban_cong" class="form-control" placeholder="Số Lượng Ban Công" id="ban_cong" type="text" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["ban_cong"]!!}@endif'>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <label class="control-label" for="lastnam56">Phòng Khách :</label>
                                                        <input name="language-{{$key}}-phong_khach" class="form-control" placeholder="Số Lượng Phòng Khách" id="phong_khach" type="text" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["phong_khach"]!!}@endif'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <label class="control-label" for="firstnam55">Ngân Sách :</label>
                                                        <input name="language-{{$key}}-ngan_sach" class="form-control" placeholder="Số Tiền" id="ngan_sach" type="text" value='@if(isset($viewPost[$key-1])){!!$viewPost[$key-1]["ngan_sach"]!!}@endif'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @endforeach
                                        @endif
									    <div class="tab-pane" id="general-child">
											<div class="page-box">
												<div class="button-page-box">
													<div class="button-page-box-heading">
														<h4>SEO Supporting</h4>
													</div>
													<div class="button-page-box-content">
														<div class="row">
															<div class="col-md-12">
																<div class="create-page-left">
																	<div class="form-group">
																		<label>Title</label>
																		<input id="seotitle" type="text" name="seotitle" placeholder="SEO Title" value='{!!$view->seotitle!!}' >
																		<p id="input_feedback1"></p>
																	</div>
																	<div class="form-group">
																		<label>Keyword</label>
																		<input type="text" name="seokeyword" placeholder="SEO Keyword" value='{!!$view->seokeyword!!}' >
																	</div>
																	<div class="form-group">
																		<label class="control-label" for="seodescription">Description</label>
																		<textarea name="seodescription" class="form-control" id="seodescription" placeholder="SEO Description">{!!$view->seodescription!!}</textarea>
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
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="work">Status</label>
                                        <div class="form-gender form-status">
                                            <div class="form-group form-radio">
                                               <input id="publish" name="post_status" type="radio" value="1" <?php echo ($view->post_status == 1)?'checked':''?>>
                                               <label for="publish" class="inline control-label">Publish</label>
                                            </div>
                                            <div class="form-group form-radio">/
                                               <input id="private" name="post_status" type="radio" value="0" <?php echo ($view->post_status == 0)?'checked':''?>>
                                               <label for="private" class="inline control-label">Private</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="select">Category</label>
                                        <select class="form-control" id="select" name="category">
                                            <?php

                                            function categoryTree($id_post, $parent_id = 0, $submark = '') {
                                                $cate = App\Categorypost::getListCategoryParent($parent_id);
                                                $post = App\Post::getCurrentCate($id_post);
                                                if ($cate) {
                                                    foreach ($cate as $catepost) {
                                                        ?>
                                                        <option <?php echo ($post->id_cate == $catepost->id) ? "selected" : "" ?> value="{!!$catepost->id!!}">
                                                            {!! $submark . $catepost->title !!}
                                                            </option>
                                                        <?php
                                                        categoryTree($id_post, $catepost->id, $submark . '---- ');
                                                    }
                                                }
                                            }

                                            echo categoryTree($view->id);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-checkbox">
                                        <input name="feature" type="checkbox" <?php echo ($view->feature == 1) ? "checked='checked'" : "" ?> id="chk_1"/>
                                        <label class="inline control-label" for="chk_1">Feature</label>
                                    </div>
                                    

                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <img src="{!!url('images/upload/post/'.$view->image)!!}" alt="Breadcromb">
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                            <input type="hidden" name="path" value="{!!$view->image!!}">
                                        </div>
                                    </div>
                                    <div class="widget_card_page fileupload-buttonbar margin-top-15">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Gallery image</label><br>
                                        <span class="btn btn-success product-upload">
                                            <i class="fa fa-plus"></i>
                                            <span>Upload Gallery</span>
                                            <input type="file" name="galleries[]" id="uploadMultiple" multiple>
                                        </span>
                                        <input type="hidden" name="new_galleries" id="newGalleries">
                                        <table role="presentation" class="table table-striped">
                                            <tbody class="d-flex files">
                                                @if (is_array($galleries) && count($galleries) > 0)

                                                @for ($i = 0; $i < count($galleries); $i++)
                                                <tr class="preview">
                                                    <td class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                                        <img width="70" height="70" class="preview-image gallery-{!!$i+1!!}" alt="{!! $galleries[$i] !!}"
                                                             src="{!! url('/images/upload/post/'. $galleries[$i])  !!}">
                                                    </td>
                                                    <td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                                        <a href="javascript:void(0)"
                                                           class="btn btn-danger delete-image"><i
                                                                class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endfor
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-layout-submit">
                            <?php
                            $id_cate = '';
                            if (Request::get('id_cate') != 0) {
                                $id_cate = '?id_cate=' . Request::get('id_cate');
                            }
                            ?>
                            <p>
                                <button type="submit" id="submitEditPost" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/post/list'.$id_cate)!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
<!-- Advance Component Form JS For Only This Page -->

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

        /* Start Xoa Hinh*/

    });
    jQuery('#datepicker').daterangepicker({
        singleDatePicker: true,
		locale: {
			format: 'DD-MM-YYYY'
		}
//        autoUpdateInput: false,
    });

//    jQuery.noConflict();

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
