@extends('admin.master')
@section('title', 'Contact')
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
                                <h3>All Register Course</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="seipkon-breadcromb-right">
                                <ul>
                                    <li><a href="{!!url('admin/dashboard')!!}">home</a></li>
                                    <li>Register Course</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcromb Row -->

        <!-- Pages Table Row Start -->
        <div class="row">
            <div class="col-md-12">
                <div class="page-box">
                    <div class="table-responsive">
                        <table id="page-list" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="7%">Fullname</th>
                                    <!--<th width="7%">Email</th>-->
                                    <th width="7%">Phone</th>
                                    <!--<th width="10%">Message</th>-->
                                    <th width="15%">Course</th>
                                    <th width="5%">Create Date</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listconsultant as $count => $consultant)
                                <tr>
                                    <td>{!!$count+1!!}</td>
                                    <td><a href="{!!url('admin/consultant/view/'.$consultant->id)!!}" class="page-table-success">{!!$consultant->name!!}</a></td>
                                    <!--<td>{!!$consultant->email!!}</td>-->
                                    <td>{!!$consultant->phone!!}</td>
                                    <!--<td>{!!$consultant->message!!}</td>-->
                                    <td>{!!$consultant->page!!}</td>
                                    <td>{!!$consultant->created_at!!}</td>
                                    <td>
                                        <!--<a href="{!!url('admin/consultant/view/'.$consultant->id)!!}" class="page-table-info" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>-->
                                        <a class="btn btn-primary" title="Delete" onclick="myDelete({!!$consultant->id!!})"><i class="fa fa-trash"></i></a>
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

<!-- Sweet Alerts JS -->

<script>
    function myDelete(id) {
        var r = confirm("Are you delete!?");
        if (r == true) {
            window.location.assign("{!!url('admin/consultant/delete/')!!}" + "/" + id);
        } else {
            txt = "You pressed Cancel!";
        }
    }
</script>
@endsection