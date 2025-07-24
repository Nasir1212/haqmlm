@extends('layouts.Back.app') 
@section('content')
<div class="main-container">
    <!-- Page header start -->
    <div class="page-header">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Notification Template</li>
        </ol>
        <!-- Breadcrumb end -->
    </div>
    <!-- Page header end -->
     <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
              @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    
<div class=" table-responsive ">
<table class="table custom-table table-bordered table-striped m-0">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Type</th>
            <th>Body</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notificationTemps as $temp)
        <tr>
            <td>{{ $temp->subject }}</td>
            <td>{{ $temp->type }}</td>
            <td>{{ $temp->body }}</td>
            <td>
                <a href="{{ route('notification-temps.edit', $temp->id) }}" class="btn btn-primary"> <i class="fas fa-edit"></i> </a>
              
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
</div>

@endsection