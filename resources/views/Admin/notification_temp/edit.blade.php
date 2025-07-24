@extends('layouts.Back.app') 
@section('content')
<div class="main-container">
    <!-- Page header start -->
    <div class="page-header">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Notification Template Edit</li>
        </ol>
        <!-- Breadcrumb end -->
    </div>
    <!-- Page header end -->
     <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
              
    
<div class=" table-responsive ">
<table class="table custom-table table-bordered table-striped m-0">
    
    <tbody>
    <form action="{{ route('notification-temps.update', $notificationTemp->id) }}" method="POST">

        <tr>
            <td> Subject </td>
            <td> 
                <input type="text" class="form-control " name="subject" value="{{ $notificationTemp->subject }}" id=""> 
@error('subject')
<small class="text-danger">{{ $message }}</small>
@enderror
            </td>      
        </tr>
        <tr>
            <td>  Type </td>
            <td>  <input type="text" class="form-control " readonly="true" value="{{ $notificationTemp->type }}" id=""> </td>
           
        </tr>
        <tr>
            <td>  Body </td>
            <td>  
                <textarea name="body"   class="form-control "  cols="30" rows="10">{{ $notificationTemp->body }}</textarea> 
            @error('body')
<small class="text-danger">{{ $message }}</small>
@enderror
            
            </td>
           
        </tr>
      

        <tr>
            <td colspan="4">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Update</button>
                
            </td>
        </tr>
      </form>
    </tbody>
</table>
</div>
</div>
     </div>
        </div>
    </div>
</div>
</div>

@endsection