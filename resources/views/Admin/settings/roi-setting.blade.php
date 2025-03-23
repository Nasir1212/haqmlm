@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Roi Setup</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('roi_setting_update')}}" method="post">
						@csrf
						<div class="card-body">
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="roi_send_amount">Roi Amount</label>
										<input type="text" class="form-control" id="roi_send_amount" name="roi_send_amount" value="{{ $RoiSettingData->roi_send_amount }}">
									</div>
								</div>
								
									
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="roi_send_stop">Total Send</label>
										<input type="text" class="form-control" name="roi_send_stop" id="roi_send_stop" value="{{ $RoiSettingData->roi_send_stop }}">
									</div>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group border p-3">
										<label for="roi_send_date_switch"><h3>Date switch</h3> </label>
										<hr>
										@php
											$dayscode = ['Sun','Mon','Tue','Wed','Thu', 'Fri','Sat'];
											$daysname = ['Sunday','Monday','Tuesday','Wednesday','Thursday', 'Friday','Saturday'];
										@endphp

										@foreach ( $daysname as $key => $day)
										<div class="border p-2">
											<input type="checkbox" @if (in_array($dayscode[$key],  $roi_send_date_switch_list))
											checked
										@endif value="{{ $dayscode[$key] }}" class="inline-block" name="roi_send_date_switch[]"> <span class="inline-block">{{ $day }}</span>
										</div>
										
										@endforeach
										
									</div>
								</div>
							
								{{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="user_register_switch">User Register On/Off</label>
										<select name="user_register_switch" name="user_register_switch" class="form-control" id="user_register_switch">
											<option value="1">On</option>
											<option value="0">Off</option>
										</select>
									</div>
								</div> --}}
							</div>
							
							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="text-right">
										<button type="button"  class="btn btn-secondary">Cancel</button>
										<button type="submit"  class="btn btn-primary">Update</button>
									</div>
								</div>
							</div>
						</div>
				    </form>
				</div>
			</div>
		</div>
    </div>
@endsection