@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Dealer&nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button><a href="{{ route('dealers') }}" class="btn btn-success">Dealers</a></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
        <form action="{{ route('store_dealer')}}" method="POST">
            @csrf
            <div class="row g-3">
          
            <div class="col-md-6 col-12">
                <label for="name" class="form-label">Shop name</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="name" name="name" placeholder="Name">
                </div>
            </div>
              <div class="col-md-6 col-12">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="phone" name="phone" value="Call for Manager " placeholder="Call for Manager">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Username">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="ref_username" class="form-label">Ref  Username</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="ref_username" name="ref_username" placeholder="Ref_username">
                </div>
            </div>
          
              <div class="col-md-6 col-12">
        <label for="status" class="form-label">Publication Status</label>
        <div class="input-group">
            <select class="form-select form-select-md form-control" id="status" name="status" >
                <option  value="Draft">Draft</option>
                <option value="Active">Active</option>
                <option value="Disable">Disable</option>
             
            </select>
        </div>
    </div>
            <div class="col-md-6 col-12">
                <label for="location_type" class="form-label">Address</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="address" name="address" placeholder="address">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="location_type" class="form-label">Country</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="country" name="country" placeholder="Country">
                </div>
            </div>
            
            <div class="col-12 mt-2">
        <button type="submit" class="btn btn-light px-5">Create</button>
    </div>
        </div>
       
        </form>

    
    </div>
@endsection
@push('script')
	<script>
		function userQueryMaker(a,r,mode){
			var applyer = "#"+a;
			var receiver = "#"+r;
			$(applyer).on('change',function() {
			var location = $(this).val();
            if('section' != a){
                $('#parent_id').val(location);
            }else{
                mode = true;
            }
            
			

        if(mode){

        }else{

                if(location == ''){
                    $(receiver).html('');
                    $(receiver).prepend("<option value=''>Select "+r+"</option>");
                }else{
                    $.ajax({
                        url: "{{ route('location_query') }}",
                        method: 'POST',
                        headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: { location: location }, // Replace with your data
                    success: function(response) {
                       
                            var options = '';
                            var cts = '';
                            $.each(response, function (indexInArray, valueOfElement) { 
                                options +="<option value='"+valueOfElement.id+"'>"+ valueOfElement.b_name+" ("+valueOfElement.e_name+") </option>";
                                cts = indexInArray;
                            });

                            $(receiver).html(options);
                            
                      
                                $(receiver).prepend("<option selected=''>Select "+r+"</option>");
                           
                                
                            },
                            error: function(error) {
                              
                                // Handle errors here
                        }
                    });

                }
                        
            }
        });
    }


		userQueryMaker("division","district",false);
		userQueryMaker("district","upzila",false);
		userQueryMaker("upzila","l_union",false);
       
      
	</script>
@endpush

