<?php
$social_link = json_decode($social->config);
$header = json_decode($header->config);
//$footer = json_decode($footer);
$currency = json_decode($currency->config);
// echo '<pre>';
// print_r($footer[0]->link);
// exit;
?>
@extends('admin.master')
@section('title','Dashboard')
@section('sidebar')
@endsection
@section('content')

<div class="container-fluid">

    <!-- Breadcromb Row Start -->

    <div class="row">
        <div class="col-md-12">
            <div class="breadcromb-area">
                <div class="row">
                    <div class="col-md-6  col-sm-6">
                        <div class="seipkon-breadcromb-left">
                            <h3>Front End</h3>
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="seipkon-breadcromb-right">
                            <ul>
                                <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                <li>front end</li>
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

    <!-- Widget Row Start -->

    <div class="row">
        <div class="col-md-12">
            <div class="page-box">
                <div class="row">
                    <div class="col-md-3">
                        <div class="add-employee-left">
                            <div class="total-group-employee">
                                <h3>Option</h3>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="tab" class="active">
                                        <a href="#header" aria-controls="Header" role="tab" data-toggle="tab">Header</a>
                                    </li>
                                    <li role="tab">
                                        <a href="#footer" aria-controls="Footer" role="tab" data-toggle="tab">Footer</a>
                                    </li>
                                    <li role="tab">
                                        <a href="#social" aria-controls="Social" role="tab" data-toggle="tab">Social</a>
                                    </li>
									<li role="tab">
                                        <a href="#currency" aria-controls="Currency" role="tab" data-toggle="tab">Currency</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="employee-right">
                            <div class="tab-content">

                                <!-- Table Tab Panel Start -->
                                <div role="tab" class="tab-pane fade in active" id="header">
                                    <div class="table-responsive" style="width: 100%; overflow: hidden;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="form_header" action="{!!action('Admin\SettingController@setHeader')!!}" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Logo</h3>
                                                                <p>Link that you want to change</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="page-img-upload">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label>Feature image</label><br>
                                                                    <img width="500px" src="{!!url('images/upload/'.$header->logo)!!}" alt="Breadcrumb">
                                                                    <div class="product-upload btn btn-info">
                                                                        <i class="fa fa-upload"></i>
                                                                        Upload Image
                                                                        <input type="file" class="custom-file-input form-control" id="customFile" name="logo">
                                                                        <input type="hidden" class="custom-file-input form-control" id="customFile" name="old_logo" value="{!!(!empty($header->logo))?$header->logo:''!!}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Supporting</h3>
                                                                <p>Confirm information</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="hotline">Hotline</label><br>
                                                                    <input class="form-control" placeholder="Hotline" id="hotline" type="text" name="hotline" value="{!!$header->hotline!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="email">Email</label><br>
                                                                    <input class="form-control" placeholder="Email" id="email" type="text" name="email" value="{!!$header->email!!}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-layout-submit">
                                                        <p>
                                                            <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
                                                            <!--<a class="btn btn-default" href="" role="button"><i class="fa fa-chevron-left"></i> Back</a>-->
                                                        </p>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Table Tab Panel End -->

                                <!-- Table Tab Panel Start -->
                                <div role="tab" class="tab-pane fade" id="footer">
                                    <div class="table-responsive" style="width: 100%; overflow: hidden;">
                                        <div class="row">
                                            <div class="col-md-12">
												
                                                <form id="form_header" action="{!!action('Admin\SettingController@setFooter')!!}" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                                    <ul class="nav nav-tabs" role="tablist">
													  <?php $count=1;?>
														@foreach(config('app.locales') as $lang)
														  <li class="{{($count++==1)?'active':''}}"><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
														@endforeach
													</ul>
													<div class="tab-content">
													<?php $count=1;?>
													@foreach(config('app.locales') as $key=>$lang)
													<?php  $foot = json_decode($footer[$key-1]->config);?>
													<div class="{{($count++==1)?'active':''}} tab-pane" id="tab_{{$lang}}">
													<div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Copyright</h3>
                                                                <p>Copyright that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="copyright">Text</label><br>
                                                                    <textarea class="form-control" id="copyright" placeholder="Copyright" name="language-{{$key}}-copyright">{!!$foot->copyright!!}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Phone</h3>
                                                                <p>Phone that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="phone">Phone</label><br>
                                                                    <input class="form-control" placeholder="Phone" id="phone" type="text" name="language-{{$key}}-phone" value="{!!$foot->phone!!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Address</h3>
                                                                <p>Address that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="address">Address</label><br>
                                                                    <input class="form-control" placeholder="Address" id="address" type="text" name="language-{{$key}}-address" value="{!!$foot->address!!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Development</h3>
                                                                <p>Development that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="development">Development</label><br>
                                                                    <input class="form-control" placeholder="Email" id="development" type="text" name="language-{{$key}}-development" value="{!!$foot->development!!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Link of development</h3>
                                                                <p>Link that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="link">Link</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link" type="text" name="language-{{$key}}-link" value="{!!$foot->link!!}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
													@endforeach
                                                    <div class="form-layout-submit">
                                                        <p>
                                                            <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
                                                        </p>
                                                    </div>
													</div>
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Table Tab Panel End -->

                                <div role="tab" class="tab-pane fade" id="social">
                                    <div class="table-responsive" style="width: 100%; overflow: hidden;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="form_social" action="{!!action('Admin\SettingController@setSocial')!!}" method="post">
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">

                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Social Link</h3>
                                                                <p>Link that you want to use</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_facebook">Facebook</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_facebook" type="text" name="link_facebook" value="{!!$social_link->facebook!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_youtube">Youtube</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_youtube" type="text" name="link_youtube" value="{!!$social_link->youtube!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_googleplus">Google Plus</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_googleplus" type="text" name="link_googleplus" value="{!!$social_link->googleplus!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_twitter">Twitter</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_twitter" type="text" name="link_twitter" value="{!!$social_link->twitter!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_linkedin">Linked In</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_linkedin" type="text" name="link_linkedin" value="{!!$social_link->linkedin!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_instagram">Skype</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_skype" type="text" name="link_skype" value="{!!$social_link->skype!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_instagram">Whatsapp</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_whatsapp" type="text" name="link_whatsapp" value="{!!$social_link->whatsapp!!}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <img class="marrig5" src="{!!url('admin_assets/img/'.session('locale').'.png')!!}"><label class="control-label" for="link_instagram">Instagram</label><br>
                                                                    <input class="form-control" placeholder="Link" id="link_instagram" type="text" name="link_instagram" value="{!!$social_link->instagram!!}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-layout-submit">
                                                        <p>
                                                            <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
                                                            <!--<a class="btn btn-default" href="" role="button"><i class="fa fa-chevron-left"></i> Back</a>-->
                                                        </p>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div role="tab" class="tab-pane fade" id="currency">
                                    <div class="table-responsive" style="width: 100%; overflow: hidden;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="form_social" action="{!!action('Admin\SettingController@setCurrency')!!}" method="post">
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">

                                                    <div class="page-box">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h3>Currency</h3>
                                                                <p>Exchange rate</p>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="Currency">1 USD =</label><br>
                                                                    <input class="form-control" placeholder="VND" id="usd" type="text" name="currency" value="{!!$currency->usd!!}">
                                                                </div>

                                                                
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-layout-submit">
                                                        <p>
                                                            <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>Save</button>
                                                        </p>
                                                    </div>
                                                </form>

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

    <!-- End Widget Row -->



    <!-- Widget Row Start -->

    <div class="row">

        <div style="min-height: 600px;"></div>



    </div>

    <!-- End Widget Row -->

    <!-- Footer Area Start -->

    <footer class="seipkon-footer-area">

        @include('admin/layouts/footer')

    </footer>

    <!-- End Footer Area -->

</div>

@endsection

@section('assetjs')

<!-- Dashboard JS -->

<script src="{!!url('admin_assets/js/dashboard.js')!!}"></script>

@endsection



