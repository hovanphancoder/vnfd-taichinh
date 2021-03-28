@extends('admin.dashboard')

@section('title', 'Page Title')

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

                                <h3>All Page</h3>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="seipkon-breadcromb-right">

                                <ul>

                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>

                                    <li>Page</li>

                                    <li>All Page</li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- End Breadcromb Row -->
		<section class="content-header">
			<div style="text-align: right">
				<a href="{!!url('admin/page/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
				<a href="{!!url('admin/page/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
				
			</div>
		</section>
        <!-- Pages Table Row Start -->

        <div class="row">

            <div class="col-md-12">

                <div class="page-box">

                    <div class="table-responsive">

                        <table id="page-list" class="table table-bordered">

                            <thead>

                                <tr>

                                    <th width="5%">No</th>

                                    <th width="40%">Title</th>

                                    <th width="20%">Description</th>

                                    <th width="10%">Publish Date</th>

                                    <th width="10%">Update Date</th>

                                    <th width="10%">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($listpage as $count => $page)

                                <tr>

                                    <td>{!!$count+1!!}</td>

                                    <td><a href="{!!url('admin/page/view/'.$page->id)!!}" class="page-table-success">{!! $page->title !!}</a></td>

                                    <td>{!! $page->description !!}</td>

                                   <td>{!!date('d/m/Y H:i:s', strtotime($page->created_at))!!}</td>
                                   <td>{!!date('d/m/Y H:i:s', strtotime($page->updated_at))!!}</td>

                                    <td>

                                         <a href="{!!url('admin/page/view/'.$page->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>

                                         <a target="blank" href="{!!url('/'.$page->slug)!!}" class="page-table-view" data-toggle="tooltip" title="View"><i style="font-size: 18px;color: #f220d685;" class="fa fa-eye"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$page->id!!})"><i class="fa fa-trash"></i></a>



                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

		 <!-- Pagination -->

        @include('admin.pagination.default', ['paginator' => empty($id_cate)?$listpage->setPath('list'):$listpage->setPath($id_cate)])

        <!-- End Pagination -->

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

    window.location.assign("{!!url('admin/page/delete')!!}" + "/" + id);

    } else {

    txt = "You pressed Cancel!";

    }

    }

</script>

<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>



@endsection