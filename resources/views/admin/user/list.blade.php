@extends('admin.dashboard')

@section('title', 'List user')

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

                                <h3>All User</h3>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="seipkon-breadcromb-right">

                                <ul>

                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>

                                    <li>User</li>

                                    <li>All user</li>

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
				<a href="{!!url('admin/user/list')!!}" class="btn btn-default  btn-flat"><span class="glyphicon glyphicon-refresh"></span></a>
				<a href="{!!url('admin/user/add')!!}" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-plus-sign"></span> Add New</a>
				
			</div>
		</section>
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
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="4%">Status</th>
                                    <th width="5%">Group</th>
                                    <th width="10%">Publish Date</th>
                                    <th width="10%">Update Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($users as $count => $user)
                                <tr>
                                    <td>{!!$count + 1!!}</td>
                                    <td><a href="{!!url('admin/user/view/'.$user->id)!!}" class="page-table-success">{!!$user->name!!}</a></td>
                                    <td>{!!$user->email!!}</td>
                                    <td>{!!$user->status!!}</td>
                                    <td>
                                        <?php
                                        if ($user->group_id == 1)
                                            echo "Admin";
                                        elseif($user->group_id == 2)
                                            echo "Editor";
                                        else
                                            echo "Unnkow";
                                        ?>
                                    </td>
                                    <td>{!!$user->created_at!!}</td>
                                    <td>{!!$user->updated_at!!}</td>
                                    <td>
                                        <a href="{!!url('admin/user/view/'.$user->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-primary" title="Delete" onclick="myDelete({!!$user->id!!})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

    function myDelete(id) {

        var r = confirm("Are you delete!?");

        if (r == true) {

            window.location.assign("{!!url('admin/user/delete')!!}" + "/" + id);

        } else {

            txt = "You pressed Cancel!";

        }

    }

</script>

<script src="{!!url('admin_assets/plugins/sweet-alerts/js/sweetalert.min.js')!!}"></script>



@endsection