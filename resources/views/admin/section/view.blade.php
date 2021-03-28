<?php
// dd($view);
$count = 1;
?>
@extends('admin.dashboard')
@section('title','Section')
@section('assets')
<script src="{!!url('admin_assets/tinymce/js/tinymce/tinymce.min.js')!!}"></script>
<script>
    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#language-1-description', height: 200,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak filemanager responsivefilemanager", "code searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        toolbar2: "fontsizeselect | forecolor backcolor | responsivefilemanager | filemanager | link unlink anchor | image media | fullscreen preview code",
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        image_advtab: true,
        relative_urls: false,
        nowrap: false,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        /*external_filemanager_path: "/~jpwebseo/projects/vtgroup/public/admin_assets/filemanager/",*/
        external_filemanager_path: "<?php echo url(pathFilemanger()); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{!!asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')!!}"}
    });

    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#language-2-description', height: 200,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak filemanager responsivefilemanager", "code searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        toolbar2: "fontsizeselect | forecolor backcolor | responsivefilemanager | filemanager | link unlink anchor | image media | fullscreen preview code",
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        image_advtab: true,
        relative_urls: false,
        nowrap: false,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        /*external_filemanager_path: "/~jpwebseo/projects/vtgroup/public/admin_assets/filemanager/",*/
        external_filemanager_path: "<?php echo url(pathFilemanger()); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{!!asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')!!}"}
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

                                <h3>Edit Section</h3>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="seipkon-breadcromb-right">

                                <ul>

                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>

                                    <li>section</li>

                                    <li>Edit section</li>

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
<form action="{!!action('Admin\SectionController@edit',$view[$count - 1]['section_id'])!!}" method="post" enctype="multipart/form-data">
                <div class="page-box">

                    

                        <div class="row">
                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                        <ul class="nav nav-tabs" role="tablist">
                        @if(config('app.locales'))
                            @foreach(config('app.locales') as $key => $lang)
                              <li class="{{($key==1)?'active':''}}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
                            @endforeach
                        @endif
                        </ul>
                        <div class="tab-content">
                        @if(config('app.locales'))
                            @foreach(config('app.locales') as $key=>$lang) 
                            <div class="{{($key==1)?'active':''}} tab-pane" id="tab_{{$lang}}"> 
                                <div class="col-md-9">
                                    <div class="create-page-left">
                                        <div class="form-group">
                                            <label>Position Page</label>
                                            <input type="text" name="language-{{$key}}-name" placeholder="Enter name" value="@if(isset($view[$key-1])){!!$view[$key-1]['name']!!}@endif" readonly="readonly">
                                        </div>

                                        <div class="form-group">
                                            <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Title</label>
                                            <input type="text" name="language-{{$key}}-title" placeholder="Enter Page Title" value="@if(isset($view[$key-1])){!!$view[$key-1]['title']!!}@endif" >
                                        </div>

                                        <div class="form-group">
                                            <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="message">Description</label>
                                            <textarea name="language-{{$key}}-description" class="form-control" id="language-{{$key}}-description" placeholder="Description">@if(isset($view[$key-1])){!!$view[$key-1]['description']!!}@endif</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Tùy Chỉnh</label>
                                            <textarea name="language-{{$key}}-setting" class="form-control" id="setting">@if(isset($view[$key-1])){!!$view[$key-1]['setting']!!}@endif</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" name="language-{{$key}}-link" placeholder="Enter link" value="@if(isset($view[$key-1])){!!$view[$key-1]['link']!!}@endif" >
                                        </div>

                                        <div class="form-group">
                                            <label>Video</label>
                                            <input type="text" name="language-{{$key}}-video" placeholder="Enter video" value="@if(isset($view[$key-1])){!!$view[$key-1]['video']!!}@endif" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <div class="add-product-image-upload">
                                                <label>Image</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="product-upload-image">
                                                            <?php if(isset($view[$key-1])) $img = $view[$key-1]['image']; else $img = '';?>
                                                            <img src="{!!url('images/upload/section/'.$img)!!}" alt="" width="300px" />
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
                                                                <input type="file" name="language-{{$key}}-image" value="">
                                                                <input type="hidden" name="language-{{$key}}-url" value="@if(isset($view[$key-1])){!!$view[$key-1]['image']!!}@endif">
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
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/section/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                </form>
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