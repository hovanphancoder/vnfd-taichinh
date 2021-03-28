<?php
// dd($viewItem->toArray());
$galleries = json_decode($viewItem->galleries);
$catalogs = json_decode($viewItem->catalogs);
//$lang = (session('locale') == 'en')?'en':'vn';
if ($_SERVER['HTTP_HOST'] == "localhost")
    $pathtinymce = "/nhatui/public/admin_assets/filemanager/";
else {
    $pathtinymce = "https://nhatuidecor.com/admin_assets/filemanager/";
}
function categoryProductTree($product_id, $parent_id = 0, $submark = '') {
    $cate = App\ProductType::productParentCategory($parent_id);
    // $product = App\Products::getProduct($product_id, ['*']);
    $product = App\Products::with('product_type_relationships')
    		->where('products.id',$product_id)
    		->first()
    		->toArray();
    ?>
    <?php
    if ($cate) {
        foreach ($cate as $keyCate => $cateproduct) {
        	// echo $cateproduct->id;
            ?>
            <input value="{!! $cateproduct->id !!}" name="id_type[]" type="checkbox" id="{!! $cateproduct->slug !!}" 
            <?php
            foreach($product['product_type_relationships'] as $relation){
            	$result = array_search($cateproduct->id, $relation);
            	if($result){
            		echo "checked";
            	}
            }
            ?>/>
            <label class="inline control-label" for="{!! $cateproduct->slug !!}">{!! $submark . $cateproduct->name !!}</label><br>
            <?php
            categoryProductTree($product_id, $cateproduct->id, $submark . '---- ');
        }
    }
}
// dd($viewItem->toArray());
//echo "<pre>";
//print_r($listProductType);
//echo "</pre>";
//exit;
?>
@extends('admin.dashboard')
@section('title', 'Edit product')
@section('assets')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{!! url('admin_assets/css/select2.css') !!}">
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
        external_filemanager_path: "<?php echo $pathtinymce ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{!!asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')!!}"}
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
        external_filemanager_path: "<?php echo $pathtinymce ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{!!asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')!!}"}
    });
    
    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#language-2-description', height: 200,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table",
        menubar: false,
        relative_urls: false,
        nowrap: false,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        /*external_filemanager_path: "/~jpwebseo/projects/vtgroup/public/admin_assets/filemanager/",*/
        external_filemanager_path: "<?php echo $pathtinymce ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "{!!asset('admin_assets/tinymce/js/tinymce/plugins/responsivefilemanager/filemanager/plugin.min.js')!!}"}
    });

    tinymce.init({

        editor_selector: "mceEditor",
        selector: '#language-1-description', height: 200,
        plugins: ["advlist autolink link image lists charmap preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking", "table contextmenu directionality emoticons paste textcolor responsivefilemanager fullscreen"],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table",
        menubar: false,
        relative_urls: false,
        nowrap: false,
        content_css: "{!!asset('admin_assets/css/editor-style.css')!!}",

        /*external_filemanager_path:"{!!url('admin_assets/filemanager/'.'/')!!}",*/
        /*external_filemanager_path: "/~jpwebseo/projects/vtgroup/public/admin_assets/filemanager/",*/
        external_filemanager_path: "<?php echo $pathtinymce ?>",
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
                                <h3>Edit Page</h3>
                                <a target="blank" href="#">Xem nhanh</a>
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
                	<div class="form-wrap">
                    <form action="{!!action('Admin\ProductController@edit', $id)!!}" method="post" enctype="multipart/form-data" id="editPostForm">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="old_image" value="{!!$viewItem->image!!}" >
                        <div class="row">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#general" role="tab" data-toggle="tab" aria-expanded="false">General</a>
								</li>
								<li class=""><a href="#tab-option" role="tab" data-toggle="tab" aria-expanded="false">Option</a></li>
								<!--<li class=""><a href="#tab-catalogs" role="tab" data-toggle="tab" aria-expanded="false">Catalogs</a></li>
								<li class=""><a href="#tab-accessories" role="tab" data-toggle="tab" aria-expanded="false">Accessories</a></li>-->
							 </ul>
							 <div id="seipkkon_tab_content" class="tab-content">
								<div id="general" class="tab-pane fade active in">
								   <div class="col-md-9">
										<div class="create-page-left">
											<ul class="nav nav-tabs" role="tablist">
											  <?php $count=1;?>
												<li class="active"><a href="#general-child" role="tab" data-toggle="tab" aria-expanded="false">General</a>
												@if(config('app.locales'))
												@foreach(config('app.locales') as $lang)
												  <li class=""><a href="#tab_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
												@endforeach
												@endif
											</ul>
											<div class="tab-content">
									  <br/> 
									    <div class="tab-pane active" id="general-child">
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<p>
															<label>Price</label>
															<input type="number" placeholder="Enter Price" name="unit_price" value="{{$viewItem->unit_price}}" required>
														</p>
													</div>
													<div class="col-md-6">
														<p>
															<label>Discount</label>
															<input type="number" placeholder="Enter Discount as Percentage" name="promotion_price" value="{{$viewItem->promotion_price}}">
														</p>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<p>
															<label>SKU</label>
															<input type="text" placeholder="Enter SKU" name="sku" value="{{$viewItem->sku}}">
														</p>
													</div>
													<div class="col-md-6">
														<p>
															<label>Unit</label>
															<select class="form-control" id="select" name="unit">
																@foreach($unit as $item)
																<option @if($item["id"] == $viewItem->unit)selected @endif value="{{$item['id']}}">{{$item['unit_vi']}}</option>
																@endforeach
															</select>
														</p>
													</div>
												</div>
											</div>
											<!--<div class="form-group">
												<div class="row">
													<div class="col-md-6">
														<p>
															<label>Expiration date</label>
															<input type="text" name="date_price" placeholder="d-m-Y" class='datepicker' value="{{$viewItem->date_price}}" id="expiration_date">
														</p>
													</div>
													
												</div>
											</div>-->
										</div>
										<?php $count=1;?>
										@if(config('app.locales'))
									    @foreach(config('app.locales') as $key=>$lang)
										<div class="tab-pane" id="tab_{{$lang}}">
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Name</label>
												<input type="text" name="language-{{$key}}-name" placeholder="Enter Name" value='@if(isset($viewProduct[$key-1])){!!$viewProduct[$key-1]["name"]!!}@endif' required>
											</div>

											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Slug</label>
												<input type="text" name="language-{{$key}}-slug" placeholder="Enter Product Slug" value="@if(isset($viewProduct[$key-1])){!!$viewProduct[$key-1]['slug']!!}@endif">
											</div>
											<div class="form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label class="control-label" for="message">Description</label>
												<textarea name="language-{{$key}}-description" class="form-control" id="language-{{$key}}-description" placeholder="Description">@if(isset($viewProduct[$key-1])){!! $viewProduct[$key-1]['description'] !!}@endif</textarea>
											</div>

											<div class="page-editor-box form-group">
												<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Content</label>
												<textarea name="language-{{$key}}-content" id="mytextarea_{{$key}}">
													@if(isset($viewProduct[$key-1]))
														{!!$viewProduct[$key-1]['content']!!}
													@endif
												</textarea>
											</div>
											<div class="form-group">
		                                       <label class="control-label">Sản Phẩm Theo Bộ</label>
		                                       <select name="language-{{$key}}-combo[]" style="width: 100%" class="form-control select2" multiple="multiple" data-placeholder="Chọn Nhiều Sản Phẩm">
		                                       	<?php
		                                       	$arr_combo = explode(',',$viewProduct[$key-1]['combo']);
		                                       	// $combo = $viewProduct[$key-1]['combo'];
		                                       	// echo "<pre>";
		                                       	// print_r($combo);
		                                       	?>
		                                       	@if($listProduct)
		                                       		@foreach($listProduct as $keyProduct => $product)
			                                       		@if($product['language_id'] == $key)
			                                       			<option value="{!! $product['product_id'] !!}" <?php echo (in_array($product['product_id'],$arr_combo))?'selected':'';?>>{!! $product['name'] !!}</option>
			                                       		@endif
			                                        @endforeach
		                                        @endif
		                                       </select>
		                                    </div>
		                                    <div class="form-group">
		                                       <label class="control-label">Sản phẩm tặng kèm</label>
		                                       <select name="language-{{$key}}-product-gif[]" style="width: 100%" class="form-control select2" multiple="multiple" data-placeholder="Chọn Nhiều Sản Phẩm">
		                                       	<?php
		                                       	$arr_gif = explode(',',$viewProduct[$key-1]['product_gif']);
		                                       	// $combo = $viewProduct[$key-1]['combo'];
		                                       	// echo "<pre>";
		                                       	// print_r($combo);
                                                if(!$arr_gif){
                                                    $arr_gif[] = $viewProduct[$key-1]['product_gif'];
                                                }
		                                       	?>
		                                       	@if($listProduct)
		                                       		@foreach($listProduct as $keyProduct => $product)
			                                       		@if($product['language_id'] == $key)
			                                       			<option value="{!! $product['product_id'] !!}" <?php echo (in_array($product['product_id'],$arr_gif))?'selected':'';?>>{!! $product['name'] !!}</option>
			                                       		@endif
			                                        @endforeach
		                                        @endif
		                                       </select>
		                                    </div>
										</div>
										@endforeach
										@endif
									</div>
											
											

										</div>
										

									</div>
									<div class="col-md-3">
										<div class="create-page-right">
		                                    <div class="panel panel-info">
		                                       <div class="panel-heading">Status</div>
		                                       <div class="panel-body">
		                                          <div class="form-example">
				                                    	<div class="form-wrap">
					                                        <div class="form-gender form-status">
					                                            <div class="form-group form-radio">
					                                               <input id="publish" name="product_status" type="radio" value="1" <?php echo ($viewItem->product_status == 1) ? "checked" : "" ?>>
					                                               <label for="publish" class="inline control-label">Publish</label>
					                                            </div>
					                                            <div class="form-group form-radio">
					                                               <input id="private" name="product_status" type="radio" value="0" <?php echo ($viewItem->product_status == 0) ? "checked" : "" ?>>
					                                               <label for="private" class="inline control-label">Private</label>
					                                            </div>
					                                        </div>
					                                    </div>
													</div>
		                                       	</div>
		                                    </div>
		                                    <div class="panel panel-info">
		                                       <div class="panel-heading">Category</div>
		                                       <div class="panel-body">
		                                          <div class="form-example custom_scroll_y">
		                                    	<div class="form-wrap">
													<div class="form-group form-checkbox form-status">
														<?php
														// dd($viewItem->product_type_relationships);
														?>
														<input value="0" name="id_type[]" type="checkbox" id="id_type"<?php 
														foreach($viewItem->product_type_relationships as $relation_none){
															if($relation_none->type_products_id == 0)
																echo "checked";
														}
														?> {!! ($viewItem->id == 0)?'checked':'' !!}/>
														<label class="inline control-label" for="id_type">Chưa xác định</label><br>
														<?php echo categoryProductTree($viewItem->id); ?>
													</div>
												</div>
											</div>
		                                       </div>
		                                    </div>
		                                    
											<!--<div class="form-group">
												<label class="control-label" for="select">Group</label>
												<select class="form-control" id="select_group" name="id_group">
													<option value="0">Chưa Phân Loại</option>
													@foreach($categories as $producttype)
													<option <?php echo ($producttype['id'] == $viewItem->id_group) ? "selected" : "" ?> data-level="{!!$producttype['level']!!}"  value="{!!$producttype['id']!!}">{!!$producttype['name']!!}</option>
													
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label class="control-label" for="select">Trademark</label>
												<select class="form-control" id="select_trade" name="id_trademark">
													<option value="0">Không thương hiệu</option>
													@foreach($listTrademark as $count => $producttype)
													<option value="{!!$producttype['id']!!}" <?php echo ($producttype['id'] == $viewItem->id_trademark) ? "selected" : "" ?>>{!!$producttype['name']!!}</option>
													@endforeach
												</select>
											</div>-->
											<div class="form-group form-checkbox">
												<input name="neew" type="checkbox" id="new" <?php echo ($viewItem->neew == 1) ? "checked" : "" ?>/>
												<label class="inline control-label" for="new">New</label>
												<br>
												<input name="feature" type="checkbox" id="feature" <?php echo ($viewItem->feature == 1) ? "checked" : "" ?>/>
												<label class="inline control-label" for="feature">Feature</label>
												<br>
												<input name="hot" type="checkbox" id="hot" <?php echo ($viewItem->hot == 1) ? "checked" : "" ?>/>
												<label class="inline control-label" for="hot">Hot</label>
											</div>
											<div class="form-group form-checkbox">
												
											</div>
											<div class="page-img-upload">
												<label>Feature image</label><br>
												<img src="{!!url('images/upload/product/'.$viewItem->image)!!}" alt="{!!$viewItem->name!!}">
												<div class="product-upload btn btn-info">
													<i class="fa fa-upload"></i>
													Upload Image
													<input type="file" class="custom-file-input form-control" id="customFile" name="image">
													<input type="hidden" name="path" value="">
												</div>
											</div>
											<div class="widget_card_page fileupload-buttonbar margin-top-15">
                                        <label>Gallery image</label><br>
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
                                                             src="{!! url('/images/upload/product/'. $galleries[$i])  !!}">
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
								<div id="tab-option" class="tab-pane fade">
								  
									<div class="col-sm-2">
									  <ul class="nav nav-pills nav-stacked" id="option">
										<?php $option_row = 0; ?>
										<?php if(isset($product_options)){ foreach ($product_options as $product_option) { ?>
										<li><a href="#tab-option<?php echo $option_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="jQuery('a[href=\'#tab-option<?php echo $option_row; ?>\']').parent().remove(); jQuery('#tab-option<?php echo $option_row; ?>').remove(); $('#option a:first').tab('show');"></i> <?php echo $product_option['name']; ?></a></li>
										<?php $option_row++; ?>
										<?php } } ?>
										<li>
										  <input type="text" name="option" value="" placeholder="" id="input-option" class="form-control" />
										</li>
									  </ul>
									</div>
									<div class="col-sm-10">
									  <div class="tab-content">
										<?php $option_row = 0; ?>
										<?php $option_value_row = 0; ?>
										<?php if(isset($product_options)){ foreach ($product_options as $product_option) { ?>
										<div class="tab-pane" id="tab-option<?php echo $option_row; ?>">
										  <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_id]" value="<?php echo $product_option['product_option_id']; ?>" />
										  <input type="hidden" name="product_option[<?php echo $option_row; ?>][name]" value="<?php echo $product_option['name']; ?>" />
										  <input type="hidden" name="product_option[<?php echo $option_row; ?>][option_id]" value="<?php echo $product_option['option_id']; ?>" />
										  <input type="hidden" name="product_option[<?php echo $option_row; ?>][type]" value="<?php echo $product_option['type']; ?>" />
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-required<?php echo $option_row; ?>">required</label>
											<div class="col-sm-10">
											  <select name="product_option[<?php echo $option_row; ?>][required]" id="input-required<?php echo $option_row; ?>" class="form-control">
												<?php if ($product_option['required']) { ?>
												<option value="1" selected="selected">Yes</option>
												<option value="0">No</option>
												<?php } else { ?>
												<option value="1">Yes</option>
												<option value="0" selected="selected">No</option>
												<?php } ?>
											  </select>
											</div>
										  </div>
										  <?php if ($product_option['type'] == 'text') { ?>
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-10">
											  <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="Option value" id="input-value<?php echo $option_row; ?>" class="form-control" />
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'textarea') { ?>
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-10">
											  <textarea name="product_option[<?php echo $option_row; ?>][value]" rows="5" placeholder="Option value" id="input-value<?php echo $option_row; ?>" class="form-control"><?php echo $product_option['value']; ?></textarea>
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'file') { ?>
										  <div class="form-group" style="display: none;">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-10">
											  <input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="Option value" id="input-value<?php echo $option_row; ?>" class="form-control" />
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'date') { ?>
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-3">
											  <div class="input-group date">
												<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="Option value" data-date-format="YYYY-MM-DD" id="input-value<?php echo $option_row; ?>" class="form-control" />
												<span class="input-group-btn">
												<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
												</span></div>
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'time') { ?>
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-10">
											  <div class="input-group time">
												<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="Option value" data-date-format="HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
												<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</span></div>
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'datetime') { ?>
										  <div class="form-group">
											<label class="col-sm-2 control-label" for="input-value<?php echo $option_row; ?>">Option value</label>
											<div class="col-sm-10">
											  <div class="input-group datetime">
												<input type="text" name="product_option[<?php echo $option_row; ?>][value]" value="<?php echo $product_option['value']; ?>" placeholder="Option value" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $option_row; ?>" class="form-control" />
												<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
												</span></div>
											</div>
										  </div>
										  <?php } ?>
										  <?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
										  <div class="table-responsive">
											<table id="option-value<?php echo $option_row; ?>" class="table table-striped table-bordered table-hover">
											  <thead>
												<tr>
												  <td class="text-left">Sku</td>
												  <td class="text-left">Option value</td>
												  <td class="text-right">Quantity</td>
												  <td class="text-left">Subtract</td>
												  <td class="text-right">price</td>
												  <td class="text-right">Points</td>
												  <td class="text-right">weight</td>
												  <td></td>
												</tr>
											  </thead>
											  <tbody>
												<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
												<tr id="option-value-row<?php echo $option_value_row; ?>">
												  <td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][sku]" value="<?php echo $product_option_value['sku']; ?>" placeholder="Sku" class="form-control" /></td>
												  <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][option_value_id]" class="form-control" style="min-width:125px">
													  <?php if (isset($option_values[$product_option['option_id']])) { ?>
													  <?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
													  <?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
													  <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['name']; ?></option>
													  <?php } else { ?>
													  <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
													  <?php } ?>
													  <?php } ?>
													  <?php } ?>
													</select>
													<input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][product_option_value_id]" value="<?php echo $product_option_value['product_option_value_id']; ?>" /></td>
												  <td class="text-right"><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" placeholder="Quantity" class="form-control" /></td>
												  <td class="text-left"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" class="form-control" style="min-width:90px">
													  <?php if ($product_option_value['subtract']) { ?>
													  <option value="1" selected="selected">Yes</option>
													  <option value="0">No</option>
													  <?php } else { ?>
													  <option value="1">Yes</option>
													  <option value="0" selected="selected">No</option>
													  <?php } ?>
													</select></td>
												  <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price_prefix]" class="form-control">
													  <?php if ($product_option_value['price_prefix'] == '+') { ?>
													  <option value="+" selected="selected">+</option>
													  <?php } else { ?>
													  <option value="+">+</option>
													  <?php } ?>
													  <?php if ($product_option_value['price_prefix'] == '-') { ?>
													  <option value="-" selected="selected">-</option>
													  <?php } else { ?>
													  <option value="-">-</option>
													  <?php } ?>
													</select>
													<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" placeholder="Price" class="form-control" /></td>
												  <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points_prefix]" class="form-control">
													  <?php if ($product_option_value['points_prefix'] == '+') { ?>
													  <option value="+" selected="selected">+</option>
													  <?php } else { ?>
													  <option value="+">+</option>
													  <?php } ?>
													  <?php if ($product_option_value['points_prefix'] == '-') { ?>
													  <option value="-" selected="selected">-</option>
													  <?php } else { ?>
													  <option value="-">-</option>
													  <?php } ?>
													</select>
													<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][points]" value="<?php echo $product_option_value['points']; ?>" placeholder="Points" class="form-control" /></td>
												  <td class="text-right"><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight_prefix]" class="form-control">
													  <?php if ($product_option_value['weight_prefix'] == '+') { ?>
													  <option value="+" selected="selected">+</option>
													  <?php } else { ?>
													  <option value="+">+</option>
													  <?php } ?>
													  <?php if ($product_option_value['weight_prefix'] == '-') { ?>
													  <option value="-" selected="selected">-</option>
													  <?php } else { ?>
													  <option value="-">-</option>
													  <?php } ?>
													</select>
													<input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][weight]" value="<?php echo $product_option_value['weight']; ?>" placeholder="Weight" class="form-control" /></td>
												  <td class="text-left"><button type="button" onclick="jQuery(this).tooltip('destroy');jQuery('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
												</tr>
												<?php $option_value_row++; ?>
												<?php } ?>
											  </tbody>
											  <tfoot>
												<tr>
												  <td colspan="6"></td>
												  <td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $option_row; ?>');" data-toggle="tooltip" title="option value add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
												</tr>
											  </tfoot>
											</table>
										  </div>
										  <select id="option-values<?php echo $option_row; ?>" style="display: none;">
											<?php if (isset($option_values[$product_option['option_id']])) { ?>
											<?php foreach ($option_values[$product_option['option_id']] as $option_value) { ?>
											<option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?></option>
											<?php } ?>
											<?php } ?>
										  </select>
										  <?php } ?>
										</div>
										<?php $option_row++; ?>
										<?php } } ?>
									  </div>
									</div>
								  
								</div>
								<div id="tab-catalogs" class="tab-pane fade">
									<div style="margin:0 auto;width:60%;" class="widget_card_page fileupload-buttonbar margin-top-15">
										
										<label>Catalogs file</label><br>
										<span class="btn btn-success product-upload">
											<i class="fa fa-plus"></i>
											<span>Upload file</span>
											<input type="file" name="catalogs[]" id="uploadMultiplecatalogs" multiple>
										</span>
										<p>You can select multiple files at once</p>
										<input type="hidden" name="new_catalogs" id="newcatalogs">
										<table role="presentation" class="table table-striped">
											<tbody class="d-flex files">
												@if (isset($catalogs) && count($catalogs) > 0)

												@for ($i = 0; $i < count($catalogs); $i++)
												<tr class="preview">
													<td class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
														<a width="70" height="70" class="preview-catalogs gallery-{!!$i+1!!}" alt="{!! $catalogs[$i] !!}"
															 href="{!! url('/images/upload/post/'. $catalogs[$i])  !!}">{!! $catalogs[$i]  !!}</a>
													</td>
													<td class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
														<a href="javascript:void(0)"
														   class="btn btn-danger delete-catalogs"><i
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
                            <p>
                                <button type="submit" id="submitEditPost" class="btn btn-success" ><i class="fa fa-check"></i>Update</button>
                                <a class="btn btn-default" href="{!!url('admin/product/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
                            </p>
                        </div>
                    </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Pages Table Row -->

    </div>
</div>
<div class="modal fade mdConfirmDelete access" id="mdModelDelete" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="edit-modal-label">Edit accessories</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
        <div id="add_accessories_frm" class="form-horizontal" novalidate="novalidate">
		  <input type="hidden" name="_token" value="{!!csrf_token()!!}">
		  <input type="hidden" name="id_accessories" id="id_accessories_pop" value="">
		  <input type="hidden" name="id_product" id="id_product_pop" value="{{$viewItem->id}}">
          <div class="card text-white bg-dark mb-0">
            <div class="card-header">
              <h2 class="m-0"></h2>
            </div>
            <div class="card-body">
              
              <div class="create-page-left">
					  <ul class="nav nav-tabs" role="tablist">
					  <?php $count=1;?>
					  @if(config('app.locales'))
						@foreach(config('app.locales') as $lang)
						  <li class="{{($count++==1)?'active':''}}"><a href="#pop_{{$lang}}" role="tab" data-toggle="tab">{{trans('general.lang_'.$lang)}}</a></li>
						@endforeach
						@endif
					  </ul>
					  <div class="tab-content">
					  <?php $count=1;?>
					  @if(config('app.locales'))
						@foreach(config('app.locales') as $key=>$lang)
						<div class="{{($count++==1)?'active':''}} tab-pane" id="pop_{{$lang}}">
							<div class="form-group">
								<div class="col-md-8">
									<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>Description</label>
									<input type="text" class="des-{{$key}}" name="language-{{$key}}-description" placeholder="Enter description" value='' required>
								</div>
								<div class="col-md-4">
									<img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"><label>P/N</label>
									<input type="text" class="pn-{{$key}}" name="language-{{$key}}-pn" placeholder="Enter P/N" value=''>
								</div>
							</div>
						</div>
						@endforeach
						@endif
					  </div>
					 
				</div>
              
            </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" onclick="checkAll()" class="btn btn-primary" >Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
    $.noConflict();
    jQuery(document).ready(function () {
//    var text_max = 99;
//    $('#textarea_feedback').html(text_max + ' characters remaining');
//         var text_length1 = jQuery('#seotitle').val().length;
//         jQuery('#input_feedback1').html(text_length1 + " / 60 ký tự");
//         jQuery('#seotitle').keyup(function () {
//             var text_length1 = jQuery('#seotitle').val().length;
// //        var text_remaining = text_max - text_length;
// //    console.log(text_length);
//             jQuery('#input_feedback1').html(text_length1 + " / 60 ký tự");
//             if (text_length1 > 60) {
//                 jQuery('#input_feedback1').css('color', 'red')
//             } else {
//                 jQuery('#input_feedback1').css('color', '#242a33')
//             }
//         });

//         var text_length2 = jQuery('#seodescription').val().length;
//         jQuery('#textare_feedback').html(text_length2 + " / 180 ký tự");
//         jQuery('#seodescription').keyup(function () {
//             var text_length2 = jQuery('#seodescription').val().length;
// //        var text_remaining = text_max - text_length2;
// //    console.log(text_length2);
//             jQuery('#textare_feedback').html(text_length2 + " / 180 ký tự");
//             if (text_length2 > 180) {
//                 jQuery('#textare_feedback').css('color', 'red')
//             } else {
//                 jQuery('#textare_feedback').css('color', '#242a33')
//             }
//         });

    });
</script>
<script type="text/javascript" src="{!!url('admin_assets/plugins/bootstrap-datetimepicker.min.js')!!}"></script>
<script type="text/javascript"><!--
var option_row = <?php echo $option_row ?>;

jQuery('input[name=\'option\']').autocomplete({
	'source': function(request, response) {
		jQuery.ajax({
			url: '{!!url("admin/product/optionautocomplete")!!}', 
			data: {'filter_name':encodeURIComponent(request),'_token':'{!!csrf_token()!!}'},
			dataType: 'json',
			success: function(data) {console.log('json:'+data);
				console.log('data0:'+data[0]['category']);
				response(data);
				// response($.map(data, function(item) {console.log('mapppp:'+data);
					// return {
						// category: item['category'],
						// label: item['name'],
						// value: item['option_id'],
						// type: item['type'],
						// option_value: item['option_value']
					// }
				// }));
			}
		});
	},
	'select': function(item) {
		html  = '<div class="tab-pane" id="tab-option' + option_row + '">';
		html += '	<input type="hidden" name="product_option[' + option_row + '][product_option_id]" value="" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][name]" value="' + item['name'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][option_id]" value="' + item['id'] + '" />';
		html += '	<input type="hidden" name="product_option[' + option_row + '][type]" value="' + item['type'] + '" />';

		html += '	<div class="form-group">';
		html += '	  <label class="col-sm-2 control-label" for="input-required' + option_row + '">Required</label>';
		html += '	  <div class="col-sm-10 no-padding-right"><select name="product_option[' + option_row + '][required]" id="input-required' + option_row + '" class="form-control">';
		html += '	      <option value="1">Yes</option>';
		html += '	      <option value="0">No</option>';
		html += '	  </select></div>';
		html += '	</div>';

		if (item['type'] == 'text') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}

		if (item['type'] == 'textarea') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-10"><textarea name="product_option[' + option_row + '][value]" rows="5" placeholder="" id="input-value' + option_row + '" class="form-control"></textarea></div>';
			html += '	</div>';
		}

		if (item['type'] == 'file') {
			html += '	<div class="form-group" style="display: none;">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-10"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="" id="input-value' + option_row + '" class="form-control" /></div>';
			html += '	</div>';
		}

		if (item['type'] == 'date') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-3"><div class="input-group date"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="" data-date-format="YYYY-MM-DD" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'time') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-10"><div class="input-group time"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="" data-date-format="HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'datetime') {
			html += '	<div class="form-group">';
			html += '	  <label class="col-sm-2 control-label" for="input-value' + option_row + '"></label>';
			html += '	  <div class="col-sm-10"><div class="input-group datetime"><input type="text" name="product_option[' + option_row + '][value]" value="" placeholder="" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + option_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
			html += '	</div>';
		}

		if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {
			html += '<div class="table-responsive">';
			html += '  <table id="option-value' + option_row + '" class="table table-striped table-bordered table-hover">';
			html += '  	 <thead>';
			html += '      <tr>';
			html += '        <td class="text-left">Sku</td>';
			html += '        <td class="text-left">Option value</td>';
			html += '        <td class="text-right">Quantity</td>';
			html += '        <td class="text-left">Subtract Stock</td>';
			html += '        <td class="text-right">Price</td>';
			html += '        <td class="text-right">Points</td>';
			html += '        <td class="text-right">Weight</td>';
			html += '        <td></td>';
			html += '      </tr>';
			html += '  	 </thead>';
			html += '  	 <tbody>';
			html += '    </tbody>';
			html += '    <tfoot>';
			html += '      <tr>';
			html += '        <td colspan="6"></td>';
			html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + option_row + ');" data-toggle="tooltip" title="" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
			html += '      </tr>';
			html += '    </tfoot>';
			html += '  </table>';
			html += '</div>';

            html += '  <select id="option-values' + option_row + '" style="display: none;">';

            for (i = 0; i < item['option_value'].length; i++) {
				html += '  <option value="' + item['option_value'][i]['option_value_id'] + '">' + item['option_value'][i]['name'] + '</option>';
            }

            html += '  </select>';
			html += '</div>';
		}

		jQuery('#tab-option .tab-content').append(html);

		jQuery('#option > li:last-child').before('<li><a href="#tab-option' + option_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick=" jQuery(\'#option a:first\').tab(\'show\');jQuery(\'a[href=\\\'#tab-option' + option_row + '\\\']\').parent().remove(); jQuery(\'#tab-option' + option_row + '\').remove();"></i>' + item['name'] + '</li>');

		jQuery('#option a[href=\'#tab-option' + option_row + '\']').tab('show');
		
		jQuery('[data-toggle=\'tooltip\']').tooltip({
			container: 'body',
			html: true
		});

		jQuery('.date').datetimepicker({
			pickTime: false
		});

		jQuery('.time').datetimepicker({
			pickDate: false
		});

		jQuery('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});

		option_row++;
	}
});
//--></script>
  <script type="text/javascript"><!--
var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_row) {
	html  = '<tr id="option-value-row' + option_value_row + '">';
	html += '  <td class="text-left"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][sku]" value="" placeholder="Sku" class="form-control" style="width:120px" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][option_value_id]" class="form-control" style="min-width:125px">';
	html += jQuery('#option-values' + option_row).html();
	html += '  </select><input type="hidden" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][product_option_value_id]" value="" /></td>';
	html += '  <td class="text-left"><input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][quantity]" value="" placeholder="Quantity" class="form-control" style="width:90px" /></td>';
	html += '  <td class="text-left"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][subtract]" class="form-control" style="min-width:90px">';
	html += '    <option value="1">Yes</option>';
	html += '    <option value="0">No</option>';
	html += '  </select></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][points]" value="" placeholder="Points" class="form-control" /></td>';
	html += '  <td class="text-right"><select name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight_prefix]" class="form-control">';
	html += '    <option value="+">+</option>';
	html += '    <option value="-">-</option>';
	html += '  </select>';
	html += '  <input type="text" name="product_option[' + option_row + '][product_option_value][' + option_value_row + '][weight]" value="" placeholder="Weight" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="jQuery(this).tooltip(\'destroy\');jQuery(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" rel="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';

	jQuery('#option-value' + option_row + ' tbody').append(html);
	jQuery('[rel=tooltip]').tooltip();

	option_value_row++;
}
//--></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  jQuery( "#expiration_date" )
        .datepicker({
          changeMonth: true,
          changeYear: true,
		  dateFormat: "dd-mm-yy",
		  minDate: '+1d',
          numberOfMonths: 1
        });
	jQuery(document).ready(function () {
		jQuery('.select2').select2();
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
		jQuery('#select_cate').on('change', function(e) { 
			var level = jQuery(this).find('option:selected').attr('data-level'); 
			var id = jQuery(this).find('option:selected').val(); 
			var district = jQuery('#select_group');
			district.html('');
			if(level==4){
				jQuery.ajax({
					method: 'post',
					dataType: 'json',
					url: '{!!url("admin/product/getgroup")!!}', 
					data: {'id':id,'_token':'{!!csrf_token()!!}'}, 
				}).done(function(res) { console.log('sxs');
					for (var i in res) {
						district.append('<option value="'+res[i].id+ '">' + res[i].name + '</option>');
					   
						district.val(res[0].id); 
					}
					district.show();
				});
			}
		});
    })
	jQuery(document).ready(function () {
        jQuery('#uploadMultiplecatalogs').on('change', function () {
            var filesAmount = this.files.length;

            for (var i = 0; i < filesAmount; i++) {
                var html = '<tr class="preview">' +
                        '<td class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><a href="" width="70" height="70" class="preview-catalogs">'+this.files[i].name+'</a></td>' +
                        '<td  class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><a href="javascript:void(0)" class="btn btn-danger delete-catalogs"><i class="fa fa-trash"></i></a></td>';
                jQuery('#tab-catalogs .files').append(html);
                jQuery('#tab-catalogs .files .preview-catalogs').last().attr('href', URL.createObjectURL(this.files[i]));
            }
        });

        jQuery(document).on('click', 'a.delete-catalogs', function (e) {
            e.preventDefault();
            jQuery(this).closest('#tab-catalogs tr.preview').remove();
        });


        jQuery('#submitEditPost').on('click', function (e) {
            e.preventDefault();
            let newcatalogs = [];
            jQuery(".preview-catalogs").each(function (index) {
                if (jQuery(this).attr('alt') !== undefined) {
                    newcatalogs.push(jQuery(this).attr('alt'));
                }
            });
            jQuery('#newcatalogs').val(JSON.stringify(newcatalogs));
            jQuery('#editPostForm').submit();
        });
    })
	jQuery('#add_accessories').on('click', function(e) { 
        var description1 = jQuery('input[name=\'language-1-description\']').val(); 
        var description2 = jQuery('input[name=\'language-2-description\']').val(); 
		if(description1=='') alert('Please enter description field!');
        var pn1 = jQuery('input[name=\'language-1-pn\']').val(); 
        var pn2 = jQuery('input[name=\'language-2-pn\']').val(); 
		jQuery.ajax({
            method: 'post',
            dataType: 'json',
            url: '{!!url("admin/product/accessories")!!}', 
            data: {'id':{!!$viewItem->id!!},'language-1-description':description1,'language-2-description':description2,'language-1-pn':pn1,'language-2-pn':pn2,'_token':'{!!csrf_token()!!}'},
        }).done(function(res) {
            console.log(res);
			var html = '';
			jQuery('#accessories-list tbody tr').remove();
			j=1;
			for (var i in res) {
                
                html += '<tr><td>'+j+'</td><td>'+res[i].description+'</td><td>'+res[i].pn+'</td><td><a href="#mdModelDelete" data-id="'+res[i].id+'" class="page-table-info" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-primary" onclick="Delete('+res[i].id+',{!!$viewItem->id!!})" title="Delete"><i class="fa fa-trash"></i></a></td></tr>'; 
				j++;
            }
			jQuery('#accessories-list tbody').append(html);
			return true;
        }).fail(function (data) {
			  console.log( "Ajax failed: " + data['responseText'] );
			  return false;
		});
        
    });
	
	(function( $ ) {

	'use strict';

	
	$('.mdConfirmDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var id = button.attr('data-id');	  	  
		
		if(id){
			 jQuery('#add_accessories_frm').find('#id_accessories_pop').val(id);
			
			jQuery.ajax({
				method: 'post',
				dataType: 'json',
				url: '{!!url("admin/product/getaccessories")!!}', 
				data: {'id_accessories':id,'_token':'{!!csrf_token()!!}'},
			}).done(function(res) {
				console.log(res);
				var j=1;
				for (var i in res) {
					jQuery('#add_accessories_frm').find('.des-'+j).val(res[i].description);
					jQuery('#add_accessories_frm').find('.pn-'+j).val(res[i].pn);
					
					j++;
				}
				return true;
			}).fail(function (data) {
				  console.log( "Ajax failed: " + data['responseText'] );
				  return false;
			});
		}
	});
	
	
 
}).apply( this, [ jQuery ]);
function checkAll(){
		var id = jQuery('#id_accessories_pop').val();
		var idproduct = jQuery('#id_product_pop').val();
		var des1 = jQuery('#add_accessories_frm .des-1').val();
		var des2 = jQuery('#add_accessories_frm .des-2').val();
		var pn1 = jQuery('#add_accessories_frm .pn-1').val();
		var pn2 = jQuery('#add_accessories_frm .pn-2').val();
		if(id != '' && des1 != ''){
			jQuery.ajax({
				method: 'post',
				dataType: 'json',
				url: '{!!url("admin/product/editaccessories")!!}', 
				data: {'idproduct':idproduct,'id':id,'des1':des1,'des2':des2,'pn1':pn1,'pn2':pn2,'_token':'{!!csrf_token()!!}'},
			}).done(function(res) {
				console.log('save:'+res);
				var html = '';
				jQuery('#accessories-list tbody tr').remove();
				var j=1;
				for (var i in res) {
					
					html += '<tr><td>'+j+'</td><td>'+res[i].description+'</td><td>'+res[i].pn+'</td><td><a href="#mdModelDelete" data-id="'+res[i].id+'" class="page-table-info" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-primary" onclick="Delete('+res[i].id+','+idproduct+')" title="Delete"><i class="fa fa-trash"></i></a></td></tr>'; 
					j++;
				}
				jQuery('#accessories-list tbody').append(html);
				// jQuery('#mdModelDelete').hide();
				// jQuery('#mdModelDelete').removeClass('in');
				// jQuery('.modal-backdrop').removeClass('in');
				jQuery('.access .modal-header .close').click();
				
				return true;
			}).fail(function (data) {
				  console.log( "Ajax failed: " + data['responseText'] );
				  return false;
			});
		}else alert('Please enter description field!');
	}
	function Delete(id,idproduct){
		
		if(id != '' && idproduct != ''){
			jQuery.ajax({
				method: 'post',
				dataType: 'json',
				url: '{!!url("admin/product/deleteaccessories")!!}', 
				data: {'idproduct':idproduct,'id':id,'_token':'{!!csrf_token()!!}'},
			}).done(function(res) {
				console.log('save:'+res);
				var html = '';
				jQuery('#accessories-list tbody tr').remove();
				var j=1;
				for (var i in res) {
					
					html += '<tr><td>'+j+'</td><td>'+res[i].description+'</td><td>'+res[i].pn+'</td><td><a href="#mdModelDelete" data-id="'+res[i].id+'" class="page-table-info" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-primary" onclick="Delete('+res[i].id+','+idproduct+')" title="Delete"><i class="fa fa-trash"></i></a></td></tr>'; 
					j++;
				}
				jQuery('#accessories-list tbody').append(html);
				return true;
			}).fail(function (data) {
				  console.log( "Ajax failed: " + data['responseText'] );
				  return false;
			});
		}else alert('Please enter description field!');
	}
</script>

<script src="{!! url('admin_assets/js/select2.full.js') !!}"></script>
<script src="{!! url('admin_assets/js/seipkon.js') !!}"></script>

@endsection