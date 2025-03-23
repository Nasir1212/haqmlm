@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Role Edit</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('role_update')}}" method="post">
                            @csrf
                        
                                <input type="text" name="name" class="form-control mb-3" value="{{ $role_name }}">
								<input type="hidden" name="r_id" value="{{ $role_id }}">

                                <input type="checkbox" name="permissions[]" @if (in_array('role_manage',$r_modules))
									checked
								@endif   value="role_manage"> Role manage
                                <input type="checkbox" name="permissions[]" @if (in_array('gateway_manage',$r_modules))
								checked
							@endif value="gateway_manage"> Gateway manage
                                <input type="checkbox" name="permissions[]" @if (in_array('user_tree',$r_modules))
								checked
							@endif  value="user_tree"> User Tree
                                <input type="checkbox" name="permissions[]" @if (in_array('user_manage',$r_modules))
								checked
							@endif value="user_manage"> User_manage
                                <input type="checkbox" name="permissions[]" @if (in_array('deposit_manage',$r_modules))
								checked
							@endif value="deposit_manage"> Deposit_manage
								<input type="checkbox" name="permissions[]" @if (in_array('product_manage',$r_modules))
								checked
							@endif value="product_manage"> Product_manage
                                <input type="checkbox" name="permissions[]" @if (in_array('withdraw_manage',$r_modules))
								checked
							@endif value="withdraw_manage"> Withdraw_manage
								<input type="checkbox" name="permissions[]" @if (in_array('purchase_manage',$r_modules))
								checked
							@endif value="purchase_manage"> Purchase_manage
								<input type="checkbox" name="permissions[]" @if (in_array('order_manage',$r_modules))
								checked
							@endif value="order_manage"> Order_manage
                                <input type="checkbox" name="permissions[]" @if (in_array('settings',$r_modules))
								checked
							@endif value="settings"> settings

                                <button type="submit" class="btn btn-success d-block mt-2" >Update</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection