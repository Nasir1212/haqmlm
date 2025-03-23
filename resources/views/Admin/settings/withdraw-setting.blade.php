@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Withdraw Condition Setup</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('withdraw_setting_update')}}" method="post">
						@csrf
						<div class="card-body">
							<div class="row gutters">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="withdraw_switch">Withdraw Switch On/Off</label>
										<select  name="withdraw_switch" class="form-control" id="withdraw_switch">
                                            @if ($WithdrawSettingData->withdraw_switch == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="minimum_limit">Minimum Limit</label>
										<input type="text" class="form-control" id="minimum_limit" name="minimum_limit" value="{{ $WithdrawSettingData->withdraw_minimum_limit }}">
									</div>
								</div>
								
							
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="maximum_limit">Maximum Limit</label>
										<input type="text" class="form-control" name="maximum_limit" id="maximum_limit" value="{{ $WithdrawSettingData->withdraw_maximum_limit }}">
									</div>
								</div>
								
							
									
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="message">Front Msg</label>
										<input type="text" class="form-control" name="message" id="message" value="{{ $WithdrawSettingData->message }}">
									</div>
								</div>
								
							
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="sunday">Sunday On/Off</label>
										<select  name="sunday" class="form-control" id="sunday">
                                            @if ($WithdrawSettingData->sun_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="monday">Monday On/Off</label>
										<select  name="monday" class="form-control" id="monday">
                                            @if ($WithdrawSettingData->mon_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="tueday">Tue_day On/Off</label>
										<select  name="tueday" class="form-control" id="tueday">
                                            @if ($WithdrawSettingData->tue_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="wedday">Wedday On/Off</label>
										<select  name="wedday" class="form-control" id="wedday">
                                            @if ($WithdrawSettingData->wed_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="thuday">Thuday On/Off</label>
										<select  name="thuday" class="form-control" id="thuday">
                                            @if ($WithdrawSettingData->thu_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="friday">Friday On/Off</label>
										<select  name="friday" class="form-control" id="friday">
                                            @if ($WithdrawSettingData->fri_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="satday">Satday On/Off</label>
										<select  name="satday" class="form-control" id="satday">
                                            @if ($WithdrawSettingData->sat_day == 1)
                                            <option value="1">On</option>
											<option value="0">Off</option>
                                            @else
                                            <option value="0">Off</option>
                                            <option value="1">On</option>
                                            @endif
										</select>
									</div>
								</div>


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