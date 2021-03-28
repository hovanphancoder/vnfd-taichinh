@extends('admin.dashboard')
@section('title', 'Page Option')
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
                                <h3>{{$title}}</h3>
                                
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Option</li>
                                    <li>{{$title}}</li>
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
                    <form action="{{$action}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group required">
									<label class="col-sm-2 control-label">Option Name</label>
									<div class="col-sm-10">
										@if(config('app.locales'))
									    @foreach(config('app.locales') as $key=>$lang)
										  <span><img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"></span>
										  <input type="text" name="language-{{$key}}-name" value="<?php echo isset($name[$key]) ? $name[$key]['name'] : ''; ?>" placeholder="Option Name" class="form-control" required />
										@endforeach
										@endif
										
									</div>
								  </div>
								  <div class="form-group">
									<label class="col-sm-2 control-label" for="input-type">Type</label>
									<div class="col-sm-10">
									  <select name="type" id="input-type" class="form-control">
										<optgroup label="Choose">
											<option value="select" <?php if ($type == 'select') echo 'selected';  ?>>Select</option>
											<option value="radio" <?php if ($type == 'radio') echo 'selected';  ?>>Radio</option>
											<!--<option value="checkbox" <?php if ($type == 'checkbox') echo 'selected';  ?>>Checkbox</option>-->
										</optgroup>
										<!--<optgroup label="Input">
											<option value="text" <?php if ($type == 'text') echo 'selected';  ?>>Text</option>
											<option value="textarea" <?php if ($type == 'textarea') echo 'selected';  ?>>Textarea</option>
										</optgroup>
										<optgroup label="File">
											<option value="file" <?php if ($type == 'file') echo 'selected';  ?>>File</option>
										</optgroup>
										<optgroup label="Date">
											<option value="date" <?php if ($type == 'date') echo 'selected';  ?>>Date</option>
											<option value="time" <?php if ($type == 'time') echo 'selected';  ?>>Time</option>
											<option value="datetime" <?php if ($type == 'datetime') echo 'selected';  ?>>Date & time</option>
										</optgroup>-->
									  </select>
									</div>
								  </div>
								  
								  <table id="option-value" class="table table-striped table-bordered table-hover">
									<thead>
									  <tr>
										<td class="text-left required">Option value name</td>
										<td class="text-left">Image</td>
										<td></td>
									  </tr>
									</thead>
									<tbody>
									  <?php $option_value_row = 0; ?>
									  <?php if($option_values){ foreach ($option_values as $option_value) { ?>
									  <tr id="option-value-row<?php echo $option_value_row; ?>">
										<td class="text-left"><input type="hidden" name="option_value[<?php echo $option_value_row; ?>][option_value_id]" value="<?php echo $option_value['option_value_id']; ?>" />
										  
										  <div class="">
											@if(config('app.locales'))
											@foreach(config('app.locales') as $key=>$lang)
											  <span><img class="marrig5" src="{!!url('admin_assets/img/'.$key.'.png')!!}"></span>
											  <input type="text" name="option_value[<?php echo $option_value_row; ?>][option_value_language][{{$key}}][name]" value="<?php echo isset($option_value['option_value_language'][$key]) ? $option_value['option_value_language'][$key]['name'] : ''; ?>" placeholder="Option Name" class="form-control" required />
											@endforeach
											@endif
											
										  </div>
										  
										  </td>
										<td class="text-left"><a href="" id="thumb-image<?php echo $option_value_row; ?>" data-toggle="image" class="img-thumbnail"><img src="@if($option_value['image']!='') {!!url('images/upload/product/'.$option_value['image'])!!} @else {!!url('images/upload/product/default.png')!!} @endif" alt="" title="" data-placeholder="image " width="100"/></a>
										<div class="product-upload btn btn-info">
                                            <i class="fa fa-upload"></i>Upload Image<input type="file" class="custom-file-input form-control" name="option_value[<?php echo $option_value_row; ?>][image]">
                                        </div>
										  <input type="hidden" name="option_value[<?php echo $option_value_row; ?>][imageold]" value="<?php echo $option_value['image']; ?>" id="input-image<?php echo $option_value_row; ?>" /></td>
										
										<td class="text-left"><button type="button" onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();" data-toggle="tooltip" title="button-remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
									  </tr>
									  <?php $option_value_row++; ?>
									  <?php } } ?>
									</tbody>
									<tfoot>
									  <tr>
										<td colspan="2"></td>
										<td class="text-left"><button type="button" onclick="addOptionValue();" data-toggle="tooltip" title="option add" class="btn-newbie btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
									  </tr>
									</tfoot>
								  </table>
                            </div>
                        </div>
                        <div class="form-layout-submit">
                            <p>
                                <button type="submit" class="btn btn-success" ><i class="fa fa-check"></i>{{$btnsave}}</button>
                                <a class="btn btn-default" href="{!!url('admin/product/option')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>
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
<script type="text/javascript"><!--
$('select[name=\'type\']').on('change', function() {
	if (this.value == 'select' || this.value == 'radio' || this.value == 'checkbox' || this.value == 'image') {
		$('#option-value').show();
	} else {
		$('#option-value').hide();
	}
});

$('select[name=\'type\']').trigger('change');

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue() {
	html  = '<tr id="option-value-row' + option_value_row + '">';	
    html += '  <td class="text-left"><input type="hidden" name="option_value[' + option_value_row + '][id]" value="" />';
	<?php if(config('app.locales')){ foreach (config('app.locales') as $key=>$language) { ?>
	html += '    <div class="">';
	html += '      <img class="marrig5" src="{!!url("admin_assets/img/$key.png")!!}"><input type="text" name="option_value[' + option_value_row + '][option_value_language][<?php echo $key ?>][name]" value="" placeholder="Option Value Name" class="form-control" />';
    html += '    </div>';
	<?php }} ?>
	html += '  </td>';
    html += '  <td class="text-left"><a href="" id="thumb-image' + option_value_row + '" data-toggle="image" class="img-thumbnail"><img src="{!!url("images/upload/product/default.png")!!}" alt="" title="" data-placeholder="" /></a><div class="product-upload btn btn-info"><i class="fa fa-upload"></i>Upload Image<input type="file" class="custom-file-input form-control" name="option_value[' + option_value_row + '][image]"></div><input type="hidden" name="option_value[' + option_value_row + '][imageold]" value="0" id="input-image' + option_value_row + '" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#option-value-row' + option_value_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#option-value tbody').append(html);
	
	option_value_row++;
}
//--></script>
@endsection