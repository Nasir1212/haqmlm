@extends('layouts.Back.app')
@section('content')
<style>
	.badgelg{
		font-size: 20px;
	}

</style>
	<div class="main-container">

		<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
				Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->

		<!-- Row start -->


	
		<div class="row gutters">
		
			<div class="col-12">
				ID Activation Form recent Point ({{ $gsd->point }})
				<form action="{{ route('point_submit_for_account_active')}}" method="post">
					@csrf
					<input type="number" name="point" class="form-control" placeholder="point">
					<label for="password">Trx Password</label>
					<input type="password" name="trx_pin" id="password" placeholder="trx_password" class="form-control">
					<button type="submit" class="btn btn-light">Submit</button>
				</form>
			</div>
		
		</div>
	

	</div>
@endsection
   
@push('script')
<script>

</script>
@endpush