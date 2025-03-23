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
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('web_config_update')}}" method="post">
						@csrf
						<div class="card-body">
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="company_name">Company-Name</label>
										<input type="text" class="form-control" id="company_name" name="company_name" value="{{ $setting_data->company_name }}">
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="company_second_rpt">Company-Second title for Report</label>
										<input type="text" class="form-control" id="company_second_rpt" name="company_second_rpt" value="{{ $setting_data->company_second_rpt }}">
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="company_tagline">Company Tagline for Report</label>
										<input type="text" class="form-control" id="company_tagline" name="company_tagline" value="{{ $setting_data->company_tagline }}">
									</div>
								</div>
								
							
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="refer_com">Refer Comission Set Fix $</label>
										<input type="text" class="form-control" name="refer_com" id="refer_com" value="{{ $setting_data->refer_com }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="income_charge">All Income Charge</label>
										<input type="text" class="form-control" name="income_charge" id="income_charge" value="{{ $setting_data->income_charge }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="shipping_cost_in_dhaka">Shipping Cost In Chattagram</label>
										<input type="text" class="form-control" name="shipping_cost_in_dhaka" id="shipping_cost_in_dhaka" value="{{ $setting_data->shipping_cost_in_dhaka }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="shipping_cost_out_dhaka">Shipping Cost Out Chattagram</label>
										<input type="text" class="form-control" name="shipping_cost_out_dhaka" id="shipping_cost_out_dhaka" value="{{ $setting_data->shipping_cost_out_dhaka }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="matrix_gen_check">Matrix gen check</label>
										<input type="text" class="form-control" name="matrix_gen_check" id="matrix_gen_check" value="{{ $setting_data->matrix_gen_check }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="set_gen_member">Set gen member</label>
										<input type="text" class="form-control" name="set_gen_member" id="set_gen_member" value="{{ $setting_data->set_gen_member }}">
									</div>
								</div>
								
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="check_point">
											Check Point
										</label>
										<input type="text" class="form-control" name="check_point" id="check_point" value="{{ $setting_data->check_point }}">
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="boot_check_month">
											boot_check_month
										</label>
										<input type="text" class="form-control" name="boot_check_month" id="boot_check_month" value="{{ $setting_data->boot_check_month }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="company_address">Company Address</label>
										<input type="text" class="form-control" name="company_address" id="company_address" value="{{ $setting_data->company_address }}">
									</div>
								</div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="company_helpline">Company Helpline</label>
										<input type="text" class="form-control" name="company_helpline" id="company_helpline" value="{{ $setting_data->company_helpline }}">
									</div>
								</div>
								
							
									
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="admin_mail">Admin mail</label>
										<input type="text" class="form-control" name="admin_mail" id="admin_mail" value="{{ $setting_data->admin_mail }}">
									</div>
								</div>
								
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="whatsapp_n">Whatsapp number</label>
										<input type="text" class="form-control" name="whatsapp_n" id="whatsapp_n" value="{{ $setting_data->whatsapp_n }}">
									</div>
								</div>


								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<div class="p-1 border mb-1">
											<input type="checkbox" name="register_switch[]" @if ($setting_data->user_register_switch == 1)
											checked
											@endif  value="1"> User Register On/Off
										</div>
										<div class="p-1 border">
											<input type="checkbox" name="login_switch[]" @if ($setting_data->user_login_switch == 1)
											checked
											@endif  value="1"> User Login On/Off
										</div>
										
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