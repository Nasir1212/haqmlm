@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Member Balance Transfer  Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
			<div class="row gutters">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	
					<div class="card">
						<div class="card-body">
							<form action="{{ route('balance_transfer_action')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="form-group">
									<label class="w-100 font-weight-bold mb-1" for="amount">Amount<span class="text-danger">*</span></label>
									<input type="text" class="form-control " placeholder="Amount" id="amount" name="amount">
								</div>
								<div class="form-group">
									<label for="username" class="w-100 font-weight-bold mb-1">Username<span class="text-danger">*</span> &nbsp; Check name -- &nbsp;&nbsp; <span id="ac_name"></span></label>
									<input type="text" class="form-control " placeholder="Username" id="username" name="username">

									<div class="user-box">

									</div>
									<div class="realtime_msg"></div>

								</div>
								<div class="form-group">
									<label for="transfer_type" class="w-100 font-weight-bold mb-1">Transfer Type<span class="text-danger">*</span></label>
									<select name="transfer_type" id="transfer_type" class="form-control">
									    <option value="point_balance">
											Point 
										</option>
										<option value="main_balance">
											 Balance
										</option>
									
									</select>
								</div>
								<div class="form-group">
									<label for="trx_pin" class="w-100 font-weight-bold mb-1">Trx Password<span class="text-danger">*</span></label>
									<input type="password" class="form-control " placeholder="Trx Password" id="trx_pin" name="trx_pin">
								</div>
								<button type="submit" class="btn btn-success">Submit</button>
							</form>
						</div>
					</div>
	
				</div>
			</div>
    </div>
@endsection
@push('css')
    <style>
        ul#users {
    border: 1px solid black;
    
}

ul#users .user {
    
    padding: 5px 10px;
}
ul#users .user:hover {
    background:#fff;
    color:#000;
 
}
    </style>
@endpush
@push('script')
    <script>
		
'use strict';

	(function($){
		$(document).on('click', 'ul#users .user', function () {
    $('#username').val($(this).data('us_name'));
    $('#ac_name').html($(this).data('name'));
    $('.user-box').html('');
});
 		

        $('#username').on('keyup',function() {
            var username = $('#username').val();
              
              if(username == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Username !</h4>";
                    $('.realtime_msg').html(msg);
              }else{
                $('.realtime_msg').html('');
              $.ajax({
                  url: '{{ route('user__check') }}',
                  method: 'POST',
				  dataType: 'json',
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { username: username }, // Replace with your data
                  success: function(response) {
                  
                      var msg = response;
                 
                      $('.user-box').html(msg);
                
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });

	})(jQuery)

         
    </script>
@endpush
