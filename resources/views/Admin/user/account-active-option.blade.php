@extends('layouts.Back.app')
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

    .ccd .card {

height: 850px;
}
.ccd .user {
height: 90px;
width: 90px;
margin-left: auto;
margin-right: auto;
line-height: 88px;
position: relative;
border-radius: 50%;
border: none;
-webkit-appearance: initial!important;
top: 11px;
}
.ccd .user img {
width: 90px;
height: 90px;
border-radius: 50%;
/*object-fit: cover;*/
position: relative;
z-index: 99;
}
.ccd .user .user-name {
line-height: 3.5;
font-size: 16px;
font-weight: 500;
color: #777777;
}
.ccd .line {
width: 66%;
margin-left: auto;
margin-right: auto;
height: 90px;
display: inherit;
border: 2px dotted #bbb;
border-bottom: none;
position: relative;
display: flex;
align-items: flex-end;

}
.ccd .user::before {
position: absolute;
content: '';
top: -6px;
left: -6px;
width: 102px;
height: 102px;
border-radius: 50%;
background-color: #ffffff;
z-index: 2;
}


.ccd .fuser::before {

background-color: red;

}
.ccd .euser::before {

background-color: gray;

}
.ccd .puser::before {
background-color: green;
}

.ccd .line::before, .line::after {
position: absolute;
content: "";
font-family: "Line Awesome Free";
font-weight: 600;
font-size: 24px;
color: #bbb;
bottom: 0;
width: 30px;
text-align: center;

z-index: 1;
line-height: 20px;
height: 20px;
}
.ccd .llll:last-child  .line {
border: none;
}
.ccd p, li, span {
color: #5b6e88;
margin-bottom: 0;
}
.ccd .w-1 {
width: 100%;
}
.ccd .w-2 {
width: 33%;
}
.ccd .w-4 {
width: 11%;
}
.ccd .sngl {
width: 1px;
height: 97px;
margin: auto;
margin-top: 2px;
border-left: 2px dotted #fff;
}
.ccd .unl {
font-size: 20px;
font-weight: bold;
color: #e9e9e9;
}
.ccd .ap {
margin-top: 32px;
}
@media only screen and (max-width:767px){

.ccd .mccd{
width:1000px !important;
}
}
</style>
@endpush
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Users</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body pb-5">
						<div class="">
							<h4>{{ $page_title }} 
							</h4>
                            <hr>
                            <h5>Accountant name -- {{ $user->name }} --/-- Account username -- {{ $user->username }}</h5>
                     
                            <h5>Account Phone -- {{ $user->phone }} --/-- Account Email -- {{ $user->email }}</h5>
                            <hr>
                            <form action="{{ route('account_approve_action')}}" method="post" class="mb-3">
                                @csrf
                                <div class="row">
                                    <div class="col-5">
                                        <label for="placement">Placement</label>
                                        <input type="text" name="placement" placeholder="username" id="placement" class="form-control">
                                        <div class="user-box">

                                        </div>
                                        <div class="realtime_placement_msg"></div>
                                    </div>
                                    <div class="col-5">
                                        <label for="placement">Position</label>
                                        <select name="position" id="position" class="form-control">
                                            <option value="">Select position</option>
                                            <option value="Left">Left</option>
                                            <option value="Middle">Middle</option>
                                            <option value="Right">Right</option>
                                        </select>
                                        <div class="placement_pos_msg_box"></div>
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" name="username" value="{{ $user->username }}">
                                        <button type="submit" class="btn btn-success mt-4">Submit</button>
                                    </div>
                                </div>
                              <div class="row mt-3">
                                <div class="col-12">
                                    <h4>{{$last_user->user_name}}</h4>
                                </div>
                              </div>
                            </form>
						</div>
					</div>
					
				</div>
               
                <div class="ccd" style="display: none;">
                    <div class="card px-3 pt-4 mccd">
                        <div class="row text-center justify-content-center llll">
                            <!-- <div class="col"> -->
                            <div class="w-1" id="main_user">
                                <div class="puser user umd" >
                                    <img src="" alt="*" class="no-user border-success" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl ml-2" ></a>
                                </p>
                                <span class="line">
                                    <div class="sngl"></div>
                                </span>
                            </div>
                        </div>
                  
                        <div class="row text-center justify-content-center llll">
                            <!-- <div class="col"> -->
                            <div class="w-2" id="left_user">
                                <div class="puser user umd">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                                <span class="line">
                                    <div class="sngl"></div>
                                </span>
                            </div>
                  
                            <div class="w-2" id="middle_user">
                                <div class="puser user umd">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                                <span class="line">
                                    <div class="sngl"></div>
                                </span>
                            </div>
                  
                            <!-- <div class="col"> -->
                            <div class="w-2" id="right_user">
                                <div class="puser user umd">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                                <span class="line">
                                    <div class="sngl"></div>
                                </span>
                            </div>
                        </div>
                  
                        <div class="row text-center justify-content-center llll">
                            <div class="w-4" id="left_user_left">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="left_user_middle">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="left_user_right">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="middle_user_left">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="middle_user_middle">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="middle_user_right">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <!-- <div class="col"> -->
                  
                            <div class="w-4" id="right_user_left">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="right_user_middle">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="#" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                  
                            <div class="w-4" id="right_user_right">
                                <div class="puser user umd" style="height: 90px;">
                                    <img src="" alt="*" class="no-user" />
                                </div>
                                <p class="user-name ap">
                                    <a href="#" class="unl"></a>
                                </p>
                            </div>
                            <!-- <div class="col"> -->
                        </div>
                    </div>
                  </div>
                  
                  
			</div>
		</div>
    </div>
@endsection

@push('script')
    <script>
  $('#placement').keypress(function() {
            var placement_username = $('#placement').val();
              
              if(placement_username == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your placement Username !</h4>";
                    $('.realtime_placement_msg').html(msg);
              }else{
                
                $('.realtime_placement_msg').html('');
              $.ajax({
                  url: "{{ route('placement_user__check') }}",
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { placement_username: placement_username }, // Replace with your data
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

          $(document).on('click', 'ul#users .user', function () {
                $('#placement').val($(this).data('name'));
               
               $('.user-box').html('');
        });
      
          $('#position').on('change',function() {
         
            var placement = $('#placement').val();
              
              if(placement == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Referal Username !</h4>";
                    $('.placement_pos_msg_box').html(msg);
              }else{
                var pos = $('#position').val();
              $.ajax({
                  url: "{{ route('placement_join_check') }}",
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { placement_username: placement, position: pos }, // Replace with your data
                  success: function(response) {
                    
                      var msg = "<h4 style='color:green;padding:10px'>New Account Setup Under <strong>"+response[0];
                     msg += " Position "+response[1]+"</strong></h4>";
                      $('.placement_pos_msg_box').html(msg);



                var freeid_img = "{{ config('app.url','url')}}"+"storage/uploads/users/sq-logo.png";
                var durl = "{{ config('app.url','url')}}";
                $.ajax({
                  url: "{{ route('last_user_tree') }}",
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { username: response[0] }, // Replace with your data
                  success: function(response) {
                   
                    $('.ccd').css('display','block');

                    if(response.user == "fresh" || response.user == "Not Found"){
                        $('#main_user .ap a').html('Not Found');
                        $('#main_user .user img').attr('src','#');
                    }else{
                        $('#main_user .ap a').html(response.user.user_name);

                        if(response.user.user.user_pic_path != '' && response.user.user.user_pic_path != null){
                        var imgurl =  durl+response.user.user.user_pic_path+response.user.user.user_pic
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#main_user .user img').attr('src',imgurl);
                    }

                   // 1

                   if(response.left_user == "fresh" || response.left_user == "Not Found"){
                      $('#left_user .ap a').html("Not Found");
                      $('#left_user .user img').attr('src','#'); 
                    }else{
                        $('#left_user .ap a').html(response.left_user.user_name);
                        if(response.left_user.user.user_pic_path != '' && response.left_user.user.user_pic_path != null){
                        var imgurl =  durl+response.left_user.user.user_pic_path+response.left_user.user.user_pic
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#left_user .user img').attr('src',imgurl); 
                    }


                    if(response.middle_user == "fresh" || response.middle_user == "Not Found"){ 
                        $('#middle_user .ap a').html("Not Found");
                        $('#middle_user .user img').attr('src','#');
                    }else{
                        $('#middle_user .ap a').html(response.middle_user.user_name);
                    if(response.middle_user.user.user_pic_path != '' && response.middle_user.user.user_pic_path != null){
                       var imgurl =  durl+response.middle_user.user.user_pic_path+response.middle_user.user.user_pic;
                    }else{
                        var imgurl = freeid_img;
                    }
                    $('#middle_user .user img').attr('src',imgurl);
                    }
                    


                    if(response.right_user == "fresh" || response.right_user == "Not Found"){ 
                        $('#right_user .ap a').html("Not Found");
                        $('#right_user .user img').attr('src','#');
                    }else{
                        $('#right_user .ap a').html(response.right_user.user_name);

                        if(response.right_user.user.user_pic_path != '' && response.right_user.user.user_pic_path != null){
                        var imgurl =  durl+response.right_user.user.user_pic_path+response.right_user.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#right_user .user img').attr('src',imgurl);
                    }
                    
                    if(response.left_user_left == "fresh" || response.left_user_left == "Not Found"){ 
                        $('#left_user_left .ap a').html("Not Found");
                        $('#left_user_left .user img').attr('src','#');
                    }else{
                        $('#left_user_left .ap a').html(response.left_user_left.user_name);
                    if(response.left_user_left.user.user_pic_path != '' && response.left_user_left.user.user_pic_path != null){
                       var imgurl =  durl+response.left_user_left.user.user_pic_path+response.left_user_left.user.user_pic;
                    }else{
                        var imgurl = freeid_img;
                    }

                    $('#left_user_left .user img').attr('src',imgurl);
                    }

             
                    if(response.left_user_middle == "fresh" || response.left_user_middle == "Not Found"){ 
                        $('#left_user_middle .ap a').html("Not Found");
                        $('#left_user_middle .user img').attr('src','#');

                    }else{
                        $('#left_user_middle .ap a').html(response.left_user_middle.user_name);

                        if(response.left_user_middle.user.user_pic_path != '' && response.left_user_middle.user.user_pic_path != null){
                        var imgurl =  durl+response.left_user_middle.user.user_pic_path+response.left_user_middle.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#left_user_middle .user img').attr('src',imgurl);
                    }

                    
                    if(response.left_user_right == "fresh" || response.left_user_right == "Not Found"){
                        $('#left_user_right .ap a').html("Not Found");
                        $('#left_user_right .user img').attr('src','#');
                     }else{
                        $('#left_user_right .ap a').html(response.left_user_right.user_name);

                        if(response.left_user_right.user.user_pic_path != '' && response.left_user_right.user.user_pic_path != null){
                        var imgurl =  durl+response.left_user_right.user.user_pic_path+response.left_user_right.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }
                        $('#left_user_right .user img').attr('src',imgurl);
                     }
                    
                     if(response.middle_user_left == "fresh" || response.middle_user_left == "Not Found"){
                        $('#middle_user_left .ap a').html("Not Found");
                        $('#middle_user_left .user img').attr('src','#');
                     }else{
                        $('#middle_user_left .ap a').html(response.middle_user_left.user_name);
                        if(response.middle_user_left.user.user_pic_path != '' && response.middle_user_left.user.user_pic_path != null){
                        var imgurl =  durl+response.middle_user_left.user.user_pic_path+response.middle_user_left.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }
                        $('#middle_user_left .user img').attr('src',imgurl);
                     }
                   

                     if(response.middle_user_middle == "fresh" || response.middle_user_middle == "Not Found"){ 
                        $('#middle_user_middle .ap a').html("Not Found");
                        $('#middle_user_middle .user img').attr('src','#');
                     }else{
                        $('#middle_user_middle .ap a').html(response.middle_user_middle.user_name);
                        if(response.middle_user_middle.user.user_pic_path != '' && response.middle_user_middle.user.user_pic_path != null){
                        var imgurl =  durl+response.middle_user_middle.user.user_pic_path+response.middle_user_middle.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#middle_user_middle .user img').attr('src',imgurl);
                     }

                    
                     if(response.middle_user_right == "fresh" || response.middle_user_right == "Not Found"){
                        $('#middle_user_right .ap a').html("Not Found");
                        $('#middle_user_right .user img').attr('src','#');
                      }else{
                        $('#middle_user_right .ap a').html(response.middle_user_right.user_name);

                        if(response.middle_user_right.user.user_pic_path != '' && response.middle_user_right.user.user_pic_path != null){
                        var imgurl =  durl+response.middle_user_right.user.user_pic_path+response.middle_user_right.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#middle_user_right .user img').attr('src',imgurl);
                      }
                  
                      if(response.right_user_left == "fresh" || response.right_user_left == "Not Found"){ 
                        $('#right_user_left .ap a').html("Not Found");
                        $('#right_user_left .user img').attr('src', '#');
                      }else{
                        $('#right_user_left .ap a').html(response.right_user_left.user_name);
                    if(response.right_user_left.user.user_pic_path != '' && response.right_user_left.user.user_pic_path != null){
                       var imgurl =  durl+response.right_user_left.user.user_pic_path+response.right_user_left.user.user_pic;
                    }else{
                        var imgurl = freeid_img;
                    }

                    $('#right_user_left .user img').attr('src',imgurl);
                      }

                      if(response.right_user_middle == "fresh" || response.right_user_middle == "Not Found"){ 
                        $('#right_user_middle .ap a').html("Not Found");
                        $('#right_user_middle .user img').attr('src','#');
                       }else{
                        $('#right_user_middle .ap a').html(response.right_user_middle.user_name);

                        if(response.right_user_middle.user.user_pic_path != '' && response.right_user_middle.user.user_pic_path != null){
                        var imgurl =  durl+response.right_user_middle.user.user_pic_path+response.right_user_middle.user.user_pic;
                        }else{
                            var imgurl = freeid_img;
                        }

                        $('#right_user_middle .user img').attr('src',imgurl);
                       }

                       if(response.right_user_right == "fresh" || response.right_user_right == "Not Found"){ 
                        $('#right_user_right .ap a').html("Not Found");
                        $('#right_user_right .user img').attr('src','#');
                       }else{
                        $('#right_user_right .ap a').html(response.right_user_right.user_name);
                    
                    if(response.right_user_middle.user.user_pic_path != '' && response.right_user_middle.user.user_pic_path != null){
                       var imgurl =  durl+response.right_user_right.user.user_pic_path+response.right_user_right.user.user_pic;
                    }else{
                        var imgurl = freeid_img;
                    }

                    $('#right_user_right .user img').attr('src',imgurl);
                       }
 
                   

                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });

                
                  },

           
                  error: function(error) {
                      console.log(error);
                      // Handle errors here 
                
               } });
              }
          });
    </script>
@endpush







