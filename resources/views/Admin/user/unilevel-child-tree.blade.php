@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->


		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body text-center">
					    <div>
					      <button type="button" onclick="goBack()" class="btn-danger btn mb-2">Go Back</button>
					    
					    <a href="{{ route('user_unilevel_gen_tree',['id'=> $gsd->username])}}" class="btn btn-info mb-2">Main Id</a>
					    </div>
				
				<?php $if_active = isset($_GET['gen'])?$_GET['gen']:0; ?>
				
                    <a href="{{ $curl }}?gen=1" class="{{ ($if_active == 0 || $if_active == 1) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">First Generation</a>
                    
                    <a href="{{ $curl }}?gen=2" class="{{ ($if_active == 2) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Second Generation</a>
                    <a href="{{ $curl }}?gen=3" class="{{ ($if_active == 3) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Three Generation</a>
                     <a href="{{ $curl }}?gen=4" class="{{ ($if_active == 4) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Four Generation</a>
                    <a href="{{ $curl }}?gen=5" class="{{ ($if_active == 5) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Five Generation</a>
                    <a href="{{ $curl }}?gen=6" class="{{ ($if_active == 6) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Six Generation</a>
                     <a href="{{ $curl }}?gen=7" class="{{ ($if_active == 7) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Seven Generation</a>
                     <a href="{{ $curl }}?gen=8" class="{{ ($if_active == 8) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Eight Generation</a>
                    <a href="{{ $curl }}?gen=9" class="{{ ($if_active == 9) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Nine Generation</a>
                     <a href="{{ $curl }}?gen=10" class="{{ ($if_active == 10) ? 'btn btn-danger mb-2' : 'btn btn-dark mb-2' }}">Ten Generation</a>
                    
                        <hr>
                        
                       <h3> Total Member = {{ count($gdata)}}</h3>
                       <?php $free = 0; ?>
                        <hr>
                        <div class="row">
                              <div class="col-12 order-1">
                             @foreach ($gdata as $data)
                            @if($data[2] == 0)
                                <a href="{{ route('user_unilevel_gen_tree',['id'=> $data[1]])}}" class="btn  btn-success  mb-2">{{ $data[1]}}</a>
                            @else 
                            <?php $free++; ?>
                            <a href="{{ route('user_unilevel_gen_tree',['id'=> $data[1]])}}" class="btn  btn-danger  mb-2">{{ $data[1]}}</a>
                            @endif
                        @endforeach
                        </div>
                       <div class="col-12 order-0">
                              <h3> Free Member = {{ $free }} ----- Paid Member = {{ count($gdata) - $free }}</h3>
                       </div>
                        </div>
                      
                     
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('script')
<script>
    function goBack() {
        window.history.back();
    }
</script>
@endpush