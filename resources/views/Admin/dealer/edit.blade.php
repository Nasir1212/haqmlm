@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Dealers&nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
        <form action="{{ route('update_dealer')}}" method="POST">
            @csrf
            <div class="row g-3">
          
            <div class="col-md-6 col-12">
                <label for="name" class="form-label">Name</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="name" name="name" value="{{ $dealer->name }}" placeholder="Name">
                </div>
            </div>
              <div class="col-md-6 col-12">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="phone" name="phone" value="{{ $dealer->phone }}" placeholder="Phone">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="email" name="email" value="{{ $dealer->email }}" placeholder="Email">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="username"  name="username" value="{{ $dealer->user->username }}" placeholder="Username">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="ref_username" class="form-label">Ref  Username</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="ref_username" name="ref_username" value="{{ $dealer->ref->username }}" placeholder="Ref_username">
                </div>
            </div>
          
          
           <div class="col-md-12 col-12">
                <label for="location_type" class="form-label">Address</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="address" name="address" value="{{ $dealer->full_address }}">
                </div>
            </div>
        </div>
       
<div class="row g-3">
    <div class="col-12">
        <label for="status" class="form-label">Publication Status</label>
        <div class="input-group">
            <select class="form-select form-select-md form-control" id="status" name="status" >
                <option @selected($dealer->status == 'Draft') value="Draft">Draft</option>
                <option @selected($dealer->status == 'Active') value="Active">Active</option>
                <option @selected($dealer->status == 'Disable') value="Disable">Disable</option>
             
            </select>
        </div>
    </div>
   
  <input type="hidden" name="parent_id" id="parent_id" value="">
  <input type="hidden" name="dealer_id" id="dealer_id" value="{{ $dealer->id }}">
    <div class="col-12 mt-2">
        <button type="submit" class="btn btn-light px-5">Update</button>
    </div>
</div>


        </form>

    
    </div>
@endsection
@push('script')
	<script>
$('#location_change').on('change', function() {
    if ($(this).val() === 'yes') {
        $('#lpt').show();
    } else {
        $('#lpt').hide();
    }
});



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

