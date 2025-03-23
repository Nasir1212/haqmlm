@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Role Creator</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('role_store')}}" method="post">
                            @csrf
                        
                                <input type="text" name="name" class="form-control mb-3" placeholder="Role name">
                                <input type="checkbox" name="permissions[]"  value="role_manage"> Role manage
                                <input type="checkbox" name="permissions[]"  value="gateway_manage"> Gateway manage
                                <input type="checkbox" name="permissions[]"  value="pay_account_manage"> pay_account_manage
                                <input type="checkbox" name="permissions[]"  value="user_tree"> User Tree
                                <input type="checkbox" name="permissions[]"  value="user_manage"> User_manage
                                <input type="checkbox" name="permissions[]"  value="deposit_manage"> Deposit_manage
                                <input type="checkbox" name="permissions[]"  value="withdraw_manage"> Withdraw_manage
                                <input type="checkbox" name="permissions[]"  value="product_manage"> Product_manage
                                <input type="checkbox" name="permissions[]"  value="purchase_manage"> Purchase_manage
								<input type="checkbox" name="permissions[]"  value="order_manage"> Order_manage
                                <input type="checkbox" name="permissions[]"  value="settings"> settings

                                <button type="submit" class="btn btn-success d-block mt-2" >Create</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
    </div>


@endsection