<?php
//echo "<pre>";
//print_r($detailmenu);
//echo "</pre>";
//exit;
// dd($listid_catemenu);
?>
@extends('admin.dashboard')
@section('title', 'Page Title')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <h3>Lĩnh Vực Hoạt Động</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Menu</li>
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
                    <form action="{!!action('Admin\MenuController@doAddMenu')!!}" method="post">
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
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Title</label>
                                                <input type="text" name="language-{{$key}}-title" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Link</label>
                                                <input type="text" name="language-{{$key}}-link" placeholder="" value="">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="create-page-right">
                                    <div class="form-group">
                                <img class="marrig5" src="{!!url('admin_assets/img/vn.png')!!}">
                                <label class="control-label" for="id_catemenu">Category</label>
                                <select class="form-control" id="id_catemenu" name="id_catemenu" onchange="getParentMenu(this.value)">
                                    <option value="0">Chọn Category</option>
                                    @foreach($listid_catemenu as $id_catemenu)
                                    <option value="{!!$id_catemenu->id!!}">{!!$id_catemenu->title_vn!!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                        <img class="marrig5" src="{!!url('admin_assets/img/vn.png')!!}">
                                        <label class="control-label" for="parent">Parent</label>
                                        <select class="form-control" id="parent_id" name="parent_id">
                                            <option value="0">Chọn Loại Cha</option>
                                        </select>
                                        <div class="alert"></div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Publish</button>
                                <a class="btn btn-default" href="{!!url('admin/menu/catemenu/1')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
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

    var j = jQuery;
    function getParentMenu(id){
        j("#parent_id").find("option").remove();
        var data = { 
                id_catemenu: j('#id_catemenu').val()
        };
        // console.log(data['id_catemenu']);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
        j.ajax({
            url: "{!! url('admin/menu/detailmenu/') !!}" + '/' + id,
            type: 'POST',
            contentType: "application/json; charset=utf-8",
            // convert data to object
            data: JSON.stringify(data),
            success: function (data) {
                    j('#parent_id').append('<option value="0">Chọn Parent</option>');
                if(data.parentMenu){
                    j.each(data.parentMenu, function (i, v) {
                        j('#parent_id').append('<option value="'+ v['id'] +'">'+v['title']+'</option>');
                    });
                }
                console.log(data);
            },
            fail: function (data) {
                j('.alert').html(data)
            }
        });
    }

</script>
@stop