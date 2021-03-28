<?php


//$lang = (session('locale') == 'en')?'en':'vn';
if ($_SERVER['HTTP_HOST'] == "localhost")
    $pathtinymce = "/public/admin_assets/filemanager/";
else {
    $pathtinymce = "http://mooncake.tuvanthietkeweb.net/public/admin_assets/filemanager/";
}
?>
@extends('admin.dashboard')
@section('title', 'Page Title')
@section('assets')
<script src="{!!url('admin_assets/tinymce/js/tinymce/tinymce.min.js')!!}"></script>
<script>
    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#mytextarea_vn', height: 500,
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
        external_filemanager_path: "<?php echo Helper::pathFilemanger()?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{{asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')}}"}
    });

    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#mytextarea_en', height: 500,
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
        external_filemanager_path: "<?php echo Helper::pathFilemanger()?>",
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
        <?php
		$status = Session::get('status');
		// echo '<pre>';
		// print_r($status->toArray());
		// exit;
		?>
        <div class="alert alert-success fade in alert-dismissible" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            @foreach($status->toArray() as $value)
            {!! $value[0] !!}
            @endforeach
        </div>
        @endif

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <form action="{!!action('Admin\TagController@add')!!}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                            <div class="col-md-4">
                                <div class="create-page-left">
                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Tên Tag</label>
                                        <input type="text" name="name" placeholder="Tag Name" value="" >
                                    </div>

                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Slug</label>
                                        <input type="text" name="slug" placeholder="Tag Slug" value="" >
                                    </div>

                                    <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="description">Mô tả</label>
                                        <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
                                    </div>
                                    <div class="page-img-upload">
                                        <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                        <div class="feature__image">
                                            <img src="{!! url('images/upload/defaultimage.jpg') !!}" alt="Breadcromb">
                                        </div>
                                        <div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>
                                            Upload Image
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="image">
                                        </div>
                                    </div>

                                    <div class="form-layout-submit">
			                            <p>
			                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Publish</button>
			                                <a class="btn btn-default" href="{!!url('387/admin/post/tag')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
			                            </p>
			                        </div>

                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="create-page-right">
                                    

                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="33%">Name</th>
                                    <th width="10%">Slug</th>
                                    <th width="10%">Description</th>
                                    <th width="10%">Publish Date</th>
                                    <th width="10%">Update Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach($listTag as $key => $tag)
                                <tr>
                                    <td>{!! $key + 1 !!}</td>
                                    <td><a href="{!! url('/387/admin/post/tag/'.$tag['id']) !!}" class="page-table-success">{!! $tag['name'] !!}</a></td>
                                    <td>{!! $tag['slug'] !!}</td>
                                    <td>{!! $tag['description'] !!}</td>
                                    <td>{!! $tag['created_at'] !!}</td>
                                    <td>{!! $tag['updated_at'] !!}</td>
                                    <td>
                                        
                                        <a href="" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!! $tag['id'] !!})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                                </div>
                            </div>


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
	function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
        window.location.assign("{!! url('387/admin/post/tag/delete') !!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
@endsection
