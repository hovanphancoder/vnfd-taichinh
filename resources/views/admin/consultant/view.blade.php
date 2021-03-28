@extends('admin.dashboard')
@section('title', 'Page Title')
@section('assets')
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">        
        @if($errors->has())        
        @foreach ($errors->all() as $error)       
        <div style="color: red">{{ $error }}</div>        
        @endforeach        
        @endif        
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
                                    <li>contact</li>                           
                                    <li>Edit contact</li>                        
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
                    <form action="{!!action('Admin\ContactController@update', $consultant->id)!!}" method="post">      
                        <div class="row">              
                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">                   
                            <div class="col-md-9">                  
                                <div class="create-page-left">               
                                    <div class="form-group">                              
                                        <label>Fullname</label>                             
                                        <input type="text" name="fullname" placeholder="Enter name" value="{!!$consultant->name!!}" disabled >        
                                    </div>                         
<!--                                    <div class="form-group">                         
                                        <label>Email</label>      
                                        <input type="email" name="email" placeholder="Enter email" value="{!!$consultant->email!!}" >           
                                    </div>                              -->
                                    <div class="form-group">                   
                                        <label>Phone</label>                           
                                        <input type="text" name="subject" placeholder="Enter email" value="{!!$consultant->phone!!}" disabled>           
                                    </div>                      
                                    <div class="form-group">                             
                                        <label class="control-label" for="message">Course</label>       
                                        <textarea class="form-control" id="message" name="message" placeholder="Enter message" disabled>{!!$consultant->page!!}</textarea>           
                                    </div>                      
                                </div>                         
                            </div>                  
                            <div class="col-md-3">       
                            </div>                    
                        </div>                     
                        <div class="form-layout-submit">        
                            <p>                            
                                <a class="btn btn-default" href="{!!url('admin/consultant/list')!!}" role="button"><i class="fa fa-chevron-left"></i> Back</a>         
                            </p>          
                        </div>           
                    </form>          
                </div>      
            </div>      
        </div>    
        <!-- End Pages Table Row -->   
    </div></div><!-- Footer Area Start -->
    <footer class="seipkon-footer-area"> 
        @include('admin/layouts/footer')
    </footer><!-- End Footer Area -->
    @endsection