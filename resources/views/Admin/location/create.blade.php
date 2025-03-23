@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Location&nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
        <form action="{{ route('location_store')}}" method="POST">
            @csrf
            <div class="row g-3">
            <div class="col-md-3 col-12">
                <label for="bn_name" class="form-label">Bangla Name</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="bn_name" name="bn_name" placeholder="Bangla Name">
                </div>
            </div>
            <div class="col-md-3 col-12">
                <label for="eng_name" class="form-label">English Name</label>
                <div class="input-group">
                    <input type="text" class="form-control border-start-0" id="eng_name" name="eng_name" placeholder="English Name">
                </div>
            </div>
           
           
            <div class="col-md-6 col-12">
                <label for="location_type" class="form-label">Location Type</label>
                <div class="input-group">
                    <select class="form-select form-select-md form-control" id="location_type" name="location_type">
                        <option selected="">Select Location Type</option>
                        <option value="division">Division</option>
                        <option value="district">District</option>
                        <option value="upzila">Upzila</option>
                        <option value="l_union">Union</option>
                
                       
                    </select>
                </div>
            </div>
        </div>
        <h3 class="my-3">Location Area</h3>
        <hr>
        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label for="division" class="form-label">Division</label>
                <div class="input-group">
                    <select class="form-select form-select-md form-control" id="division" name="division" aria-label=".form-select-lg example">
                        <option selected="">Select  Division</option>
                        @foreach ($divisions as $division)
                        <option value="{{$division->id}}">{{$division->b_name." ( ".$division->e_name." )"}}</option>
                        @endforeach
                      
                    </select>
                </div>
            </div>
    
            <div class="col-md-6 col-12">
                <label for="district" class="form-label">District</label>
                <div class="input-group">
                    <select class="form-select form-select-md form-control" id="district" name="district" aria-label=".form-select-lg example">
                        <option selected="">Select District</option>
                        
                    </select>
                </div>
            </div>
           
          
            <div class="col-md-6 col-12">
                <label for="upzila" class="form-label">Upzila</label>
                <div class="input-group">
                    <select class="form-select form-select-md form-control" id="upzila" name="upzila" aria-label=".form-select-lg example">
                        <option selected="">Select Upzila</option>
                     
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <label for="l_union" class="form-label">Union</label>
                <div class="input-group">
                    <select class="form-select form-select-md form-control" id="l_union" name="l_union" aria-label=".form-select-lg union">
                        <option selected="">Select Union</option>
                     
                    </select>
                </div>
            </div>
           
          <input type="hidden" name="parent_id" id="parent_id" value="">
            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-light px-5">Register</button>
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

