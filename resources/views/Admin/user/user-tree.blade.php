@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">User Tree   &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<style>
			.card {
 
    height: 850px;
}
		.user {
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
.user img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    /*object-fit: cover;*/
    position: relative;
    z-index: 99;
}
.user .user-name {
    line-height: 3.5;
    font-size: 16px;
    font-weight: 500;
    color: #777777;
}
.line {
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
.user::before {
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


.fuser::before {
  
    background-color: red;

}
.euser::before {

    background-color: gray;

}
.puser::before {
    background-color: green;
}

.line::before, .line::after {
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
.llll:last-child  .line {
    border: none;
}
p, li, span {
    color: #5b6e88;
    margin-bottom: 0;
}
.w-1 {
    width: 100%;
}
.w-2 {
    width: 33%;
}
.w-4 {
    width: 11%;
}
.sngl {
    width: 1px;
    height: 86px;
    margin: auto;
    margin-top: 2px;
    border-left: 2px dotted #fff;
}
.unl {
    font-size: 20px;
    font-weight: bold;
    color: #e9e9e9;
}
.ap {
    margin-top: 32px;
}

@media only screen and (max-width:767px){
    
    .mccd{
        width:1000px !important;
    }
}
		</style>
		


<div class="card px-3 pt-4 mccd">

    <div class="text-center">
		
         <form action="{{ route('user_tree_jump')}}" method="post" class="mb-3">
    @csrf
    <button type="button" class="level_info btn btn-info" data-target="#level_info" data-toggle="modal">Level info</button> <input type="text" name="username" class="form-control w-25 d-inline-block" placeholder="username">
    <button type="submit" class="btn btn-info">Jump</button>
</form>
    </div>

   <hr>
	<div class="row text-center justify-content-center llll">
		<!-- <div class="col"> -->
		<div class="w-1" >
			@if ($user == 'fresh' || $user == 'Not Found')
			<div class="euser user showDetails">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="paid-user">
				
			</div> 
			<p class="user-name ap"><a href="#" class="unl">No User</a></p> 
			@else
			LSP 
			@if (\Carbon\Carbon::parse($user->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$user->user->submitted_point}}
			@else 0 @endif
			<div class="@if($user->user->invest_status == 1) puser @else fuser @endif   user umd"  data-toggle="modal" data-rank="{{ $user->rank }}" data-left="{{$user->left}}" data-middle="{{$user->middle}}" data-right="{{$user->right}}" data-username="{{$user->user->username}}" data-target="#user_info">
				
				<img src="@if($user->user->user_pic != '') {{ url('/'.$user->user->user_pic_path.$user->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif"  alt="*" class="no-user @if($user->user->invest_status == 1) border-success @else  border-danger @endif">
			
			 </div> 
			 	<p class="user-name ap">
			 	   @if($up_user != 0)
			 	    <a href="{{ route('user_tree',['id'=> $up_user])}}" class="unl mr-2">Up-line</a>
			 	    <span class="text-success">||</span> 
			 	  @endif
			 	    <a href="{{ route('user_tree',['id'=> $user->user->username])}}" class="unl ml-2">
			 	    
			 	     {{ $user->user->username }}</a> <br>
					 {{ $user->user->submitted_point }} Pv
					</p>
			@endif
			<span class="line">
				<div class="sngl"></div>
			</span>            
		</div>
	</div>

	<div class="row text-center justify-content-center llll">
		<!-- <div class="col"> -->
		<div class="w-2">
			@if ($left_user == 'fresh' || $left_user == 'Not Found')
			<div class="euser user">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>
			 @else
			 LSP 
				@if (\Carbon\Carbon::parse($left_user->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
				{{$left_user->user->submitted_point}}
				@else 0 @endif
			<div class="@if($left_user->user->invest_status == 1) puser @else fuser @endif user umd"  data-toggle="modal" data-rank="{{ $left_user->rank }}" data-left="{{$left_user->left}}" data-middle="{{$left_user->middle}}" data-right="{{$left_user->right}}" data-username="{{$left_user->user->username}}"  data-target="#user_info">
				<img src="@if($left_user->user->user_pic != '') {{ url('/'.$left_user->user->user_pic_path.$left_user->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
			
			 </div> 
			 	<p class="user-name ap">
				    <a href="{{ route('user_tree',['id'=> $left_user->user->username])}}" class="unl">{{ $left_user->user->username }}</a> 
					<br> {{ $left_user->user->submitted_point }} Pv
				    </p>
			@endif
			 <span class="line">
				<div class="sngl"></div>
			</span>              

		</div>


		<div class="w-2">
			@if ($middle_user == 'fresh' || $middle_user == 'Not Found')
			<div class="euser user">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>
			 @else
			 LSP 
			 @if (\Carbon\Carbon::parse($middle_user->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			 {{$middle_user->user->submitted_point}}
			 @else 0 @endif
			<div class="@if($middle_user->user->invest_status == 1) puser @else fuser @endif user umd"  data-toggle="modal" data-rank="{{ $middle_user->rank }}" data-left="{{$middle_user->left}}" data-middle="{{$middle_user->middle}}" data-right="{{$middle_user->right}}" data-username="{{$middle_user->user->username}}"  data-target="#user_info">
				<img src="@if($middle_user->user->user_pic != '') {{ url('/'.$middle_user->user->user_pic_path.$middle_user->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
			
			 </div> 
			 	<p class="user-name ap">
				    <a href="{{ route('user_tree',['id'=> $middle_user->user->username])}}" class="unl">{{ $middle_user->user->username }}</a> 
				   <br> {{ $middle_user->user->submitted_point }} Pv
				</p>
			@endif
			 <span class="line">
				<div class="sngl"></div>
			</span>              

		</div>
		
		<!-- <div class="col"> -->
		<div class="w-2 ">
			@if ($right_user == 'fresh' || $right_user == 'Not Found')
			<div class="euser user">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>
			 @else
			 LSP 
			 @if (\Carbon\Carbon::parse($right_user->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			 {{$right_user->user->submitted_point}}
			 @else 0 @endif
			 <div class="@if($right_user->user->invest_status == 1) puser @else fuser @endif user umd"  data-toggle="modal" data-rank="{{ $right_user->rank }}" data-left="{{$right_user->left}}" data-middle="{{$right_user->middle}}" data-right="{{$right_user->right}}" data-username="{{$right_user->user->username}}"  data-target="#user_info">
				 <img src="@if($right_user->user->user_pic != '') {{ url('/'.$right_user->user->user_pic_path.$right_user->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
				
				   
			  </div> 
			   <p class="user-name ap">
				      <a href="{{ route('user_tree',['id'=> $right_user->user->username])}}" class="unl">{{ $right_user->user->username }}</a> 
					 <br> {{ $right_user->user->submitted_point }} Pv
					</p> 
			 @endif
			 <span class="line">
				<div class="sngl"></div>
			</span>              
			</div>
	</div>


	<div class="row text-center justify-content-center llll">
		<div class="w-4 ">
			@if ($left_user_left == 'fresh' || $left_user_left == 'Not Found')

			<div class="euser user">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>
			@else
			LSP 
			@if (\Carbon\Carbon::parse($left_user_left->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$left_user_left->user->submitted_point}}
			@else 0 @endif
			<div class="@if($left_user_left->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px" data-toggle="modal" data-rank="{{ $left_user_left->rank }}" data-left="{{$left_user_left->left}}" data-middle="{{$left_user_left->middle}}" data-right="{{$left_user_left->right}}" data-username="{{$left_user_left->user->username}}"  data-target="#user_info">
				<img src="@if($left_user_left->user->user_pic != '') {{ url('/'.$left_user_left->user->user_pic_path.$left_user_left->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
			
			 </div> 
			 	<p class="user-name ap">
				    <a href="{{ route('user_tree',['id'=> $left_user_left->user->username])}}" class="unl">{{ $left_user_left->user->username }}</a>
					<br> {{ $left_user_left->user->submitted_point }} Pv
				    </p>
			@endif
		</div>

		<div class="w-4 ">
			@if ($left_user_middle == 'fresh' || $left_user_middle == 'Not Found')

			<div class="euser user">
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>
			@else
			LSP 
			@if (\Carbon\Carbon::parse($left_user_middle->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$left_user_middle->user->submitted_point}}
			@else 0 @endif
			<div class="@if($left_user_middle->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px" data-toggle="modal" data-rank="{{ $left_user_middle->rank }}" data-left="{{$left_user_middle->left}}" data-middle="{{$left_user_middle->middle}}" data-right="{{$left_user_middle->right}}" data-username="{{$left_user_middle->user->username}}"  data-target="#user_info">
				<img src="@if($left_user_middle->user->user_pic != '') {{ url('/'.$left_user_middle->user->user_pic_path.$left_user_middle->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
			
			 </div> 
			 	<p class="user-name ap">
				    <a href="{{ route('user_tree',['id'=> $left_user_middle->user->username])}}" class="unl">{{ $left_user_middle->user->username }}</a>
					<br> {{ $left_user_middle->user->submitted_point }} Pv
				    </p>
			@endif
		</div>
	
		<div class="w-4 ">

			@if ($left_user_right == 'fresh' || $left_user_right == 'Not Found')

			<div class="euser user" >
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				<p class="user-name"><a href="#" class="unl">No User</a></p>
			 </div> 
			
			@else 
			LSP 
			@if (\Carbon\Carbon::parse($left_user_right->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$left_user_right->user->submitted_point}}
			@else 0 @endif

			<div class="@if($left_user_right->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px" data-toggle="modal" data-rank="{{ $left_user_right->rank }}" data-left="{{$left_user_right->left}}" data-middle="{{$left_user_right->middle}}" data-right="{{$left_user_right->right}}" data-username="{{$left_user_right->user->username}}"  data-target="#user_info">
				<img src="@if($left_user_right->user->user_pic != '') {{ url('/'.$left_user_right->user->user_pic_path.$left_user_right->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap">
				    <a href="{{ route('user_tree',['id'=> $left_user_right->user->username])}}" class="unl">{{ $left_user_right->user->username }}</a>
				    <br> {{ $left_user_right->user->submitted_point }} Pv
				    </p>
			@endif 
			
			</div>
			{{-- middle --}}


			<div class="w-4 ">
				@if ($middle_user_left == 'fresh' || $middle_user_left == 'Not Found')
				<div class="euser user" >
					<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
					
				 </div> 
				 <p class="user-name ap"><a href="#" class="unl">No User</a></p>       
				@else

				LSP 
			@if (\Carbon\Carbon::parse($middle_user_left->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$middle_user_left->user->submitted_point}}
			@else 0 @endif
				<div class="@if($middle_user_left->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px" data-toggle="modal" data-rank="{{ $middle_user_left->rank }}" data-left="{{$middle_user_left->left}}" data-middle="{{$middle_user_left->middle}}" data-right="{{$middle_user_left->right}}" data-username="{{$middle_user_left->user->username}}"  data-target="#user_info">
					<img src="@if($middle_user_left->user->user_pic != '') {{ url('/'.$middle_user_left->user->user_pic_path.$middle_user_left->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
				
				 </div> 
					<p class="user-name ap">
						
						 <a href="{{ route('user_tree',['id'=> $middle_user_left->user->username])}}" class="unl">{{ $middle_user_left->user->username }}</a>
						 <br> {{ $middle_user_left->user->submitted_point }} Pv
						</p>
				@endif
				</div> 

				<div class="w-4 ">
					@if ($middle_user_middle == 'fresh' || $middle_user_middle == 'Not Found')
					<div class="euser user" >
						<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
						
					 </div> 
					 <p class="user-name ap"><a href="#" class="unl">No User</a></p>       
					@else
					LSP 
			@if (\Carbon\Carbon::parse($middle_user_middle->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$middle_user_middle->user->submitted_point}}
			@else 0 @endif

					<div class="@if($middle_user_middle->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px" data-toggle="modal" data-rank="{{ $middle_user_middle->rank }}" data-left="{{$middle_user_middle->left}}" data-middle="{{$middle_user_middle->middle}}" data-right="{{$middle_user_middle->right}}" data-username="{{$middle_user_middle->user->username}}"  data-target="#user_info">
						<img src="@if($middle_user_middle->user->user_pic != '') {{ url('/'.$middle_user_middle->user->user_pic_path.$middle_user_middle->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
					
					 </div> 
						<p class="user-name ap">
							
							 <a href="{{ route('user_tree',['id'=> $middle_user_middle->user->username])}}" class="unl">{{ $middle_user_middle->user->username }}</a>
							 <br> {{ $middle_user_middle->user->submitted_point }} Pv
							</p>
					@endif
					</div> 

					<div class="w-4 ">
						@if ($middle_user_right == 'fresh' || $middle_user_right == 'Not Found')
						<div class="euser user" >
							<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
							
						 </div> 
						 <p class="user-name ap"><a href="#" class="unl">No User</a></p>       
						@else
						LSP 
			@if (\Carbon\Carbon::parse($middle_user_right->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$middle_user_right->user->submitted_point}}
			@else 0 @endif
						<div class="@if($middle_user_right->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px"  data-toggle="modal" data-rank="{{ $middle_user_right->rank }}" data-left="{{$middle_user_right->left}}" data-middle="{{$middle_user_right->middle}}" data-right="{{$middle_user_right->right}}" data-username="{{$middle_user_right->user->username}}"  data-target="#user_info">
							<img src="@if($middle_user_right->user->user_pic != '') {{ url('/'.$middle_user_right->user->user_pic_path.$middle_user_right->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
						
						 </div> 
							<p class="user-name ap">
								
								 <a href="{{ route('user_tree',['id'=> $middle_user_right->user->username])}}" class="unl">{{ $middle_user_right->user->username }}</a>
								 <br> {{ $middle_user_right->user->submitted_point }} Pv
								</p>
						@endif
						</div> 




		<!-- <div class="col"> -->
		
	
			{{-- right --}}
		 <div class="w-4 ">
			@if ($right_user_left == 'fresh' || $right_user_left == 'Not Found')
			<div class="euser user" >
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			 </div> 
			 <p class="user-name ap"><a href="#" class="unl">No User</a></p>       
			@else
			LSP 
			@if (\Carbon\Carbon::parse($right_user_left->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$right_user_left->user->submitted_point}}
			@else 0 @endif
			<div class="@if($right_user_left->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px"  data-toggle="modal" data-rank="{{ $right_user_left->rank }}"  data-left="{{$right_user_left->left}}" data-middle="{{$right_user_left->middle}}" data-right="{{$right_user_left->right}}" data-username="{{$right_user_left->user->username}}"  data-target="#user_info">
				<img src="@if($right_user_left->user->user_pic != '') {{ url('/'.$right_user_left->user->user_pic_path.$right_user_left->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
			
			 </div> 
				<p class="user-name ap">
				    
				     <a href="{{ route('user_tree',['id'=> $right_user_left->user->username])}}" class="unl">{{ $right_user_left->user->username }}</a>
					 <br> {{ $right_user_left->user->submitted_point }} Pv
					</p>
			@endif
			</div> 


			<div class="w-4 ">
				@if ($right_user_middle == 'fresh' || $right_user_middle == 'Not Found')
				<div class="euser user" >
					<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
					
				 </div> 
				 <p class="user-name ap"><a href="#" class="unl">No User</a></p>       
				@else
				LSP 
			@if (\Carbon\Carbon::parse($right_user_middle->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$right_user_middle->user->submitted_point}}
			@else 0 @endif
				<div class="@if($right_user_middle->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px"  data-toggle="modal" data-rank="{{ $right_user_middle->rank }}" data-left="{{$right_user_middle->left}}" data-middle="{{$right_user_middle->middle}}" data-right="{{$right_user_middle->right}}" data-username="{{$right_user_middle->user->username}}"  data-target="#user_info">
					<img src="@if($right_user_middle->user->user_pic != '') {{ url('/'.$right_user_middle->user->user_pic_path.$right_user_middle->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
				
				 </div> 
					<p class="user-name ap">
						
						 <a href="{{ route('user_tree',['id'=> $right_user_middle->user->username])}}" class="unl">{{ $right_user_middle->user->username }}</a>
						 <br> {{ $right_user_middle->user->submitted_point }} Pv
						</p>
				@endif
			</div> 


		
		 <div class="w-4 ">
			@if ($right_user_right == 'fresh' || $right_user_right == 'Not Found')
			<div class="euser user" >
				<img src="{{ asset('assets/sq-logo.png')}}" alt="*" class="no-user">
				
			</div> 
			<p class="user-name ap"><a href="#" class="unl">No User</a></p> 
			@else

			LSP 
			@if (\Carbon\Carbon::parse($right_user_right->user->point_submit_date )->gt(\Carbon\Carbon::now()->subDays(7)))
			{{$right_user_right->user->submitted_point}}
			@else 0 @endif

			<div class="@if($right_user_right->user->invest_status == 1) puser @else fuser @endif user umd" style="height:90px"  data-toggle="modal" data-rank="{{ $right_user_right->rank }}"  data-left="{{$right_user_right->left}}" data-middle="{{$right_user_right->middle}}" data-right="{{$right_user_right->right}}" data-username="{{$right_user_right->user->username}}"  data-target="#user_info">
				<img src="@if($right_user_right->user->user_pic != '') {{ url('/'.$right_user_right->user->user_pic_path.$right_user_right->user->user_pic)}} @else {{ asset('assets/sq-logo.png')}} @endif" alt="*" class="no-user">
				
			 </div> 
			<p class="user-name ap">
				    
				      <a href="{{ route('user_tree',['id'=> $right_user_right->user->username])}}" class="unl">{{ $right_user_right->user->username }}</a>
					  <br> {{ $right_user_right->user->submitted_point }} Pv
					</p>
			@endif         
		 </div>
		<!-- <div class="col"> -->

	</div>
	
</div>




<div class="modal fade" id="level_info" tabindex="-1" role="dialog" aria-labelledby="levelModalLabel" aria-modal="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			    <div class="w-100">
			         <div class="text-center">
			        <h5>{{ $user->user_name }} -- Matrix level Information  </h5>
			        		<h5 class="modal-title" id="levelModalLabel"><span style="color:green;background:#fff;padding:1px 5px;"> My Position <span id="mpos" style="    color: #ffffff;
    background: #000000;
    padding: 4px 9px;
    border-radius: 2px;
    margin-right: 4px;
    display: inline-block;
    box-shadow: 0px 0px 3px black;">{{ $user->root_level - 1 }} </span> From - Main ID</span> </h5>
    <h5><span style="background:#fff;padding:1px 5px;display: inline-block;"> <span style="color:red;"> Level Members </span>{{ $dfl }} / {{ $lvc }} </span></h5>
			        
			    </div>
		
				
			    </div>
			   
			</div>
			<div class="modal-body">
				<div class="row" style="font-size: 15px">
					
					<div class="col-6">
						1st : 3 / {{ count(json_decode($user->matrix_Levels->lv_1, true)) }} <br>
						2nd : 9 / {{ count(json_decode($user->matrix_Levels->lv_2, true)) }} <br>
						3rd : 27 / {{ count(json_decode($user->matrix_Levels->lv_3, true)) }} <br>
						4th : 81 / {{ count(json_decode($user->matrix_Levels->lv_4, true)) }} <br>
						5th : 243 / {{ count(json_decode($user->matrix_Levels->lv_5, true)) }} <br>
						6th : 729 / {{ count(json_decode($user->matrix_Levels->lv_6, true)) }} <br>
					</div>
					<div class="col-6 text-right">
						7th : 2187 / {{ count(json_decode($user->matrix_Levels->lv_7, true)) }} <br>
						8th : 6561 / {{ count(json_decode($user->matrix_Levels->lv_8, true)) }} <br>
						9th : 19683 / {{ count(json_decode($user->matrix_Levels->lv_9, true)) }} <br>
						10th : 59049 / {{ count(json_decode($user->matrix_Levels->lv_10, true)) }} <br>
						11th : 177147 / {{ count(json_decode($user->matrix_Levels->lv_11, true)) }} <br>
						12th : 531441 / {{ count(json_decode($user->matrix_Levels->lv_12, true)) }} <br>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  </div>
</div>













<div class="modal fade" id="user_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
			
				<h5 class="text-center">Rank : <span id="rank_n"></span></h5>
				<div class="table-responsive">
					<table class="table table-bordered m-0">
						<thead>
							<tr>
								<th>Left</th>
								<th>Middle</th>
								<th>Right</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="left">0</td>
								<td id="middle">0</td>
								<td id="right">0</td>
							</tr>
					
						</tbody>
					</table>
				</div>
			
			</div>
			<div class="modal-footer">
				<a href="#"  class="btn btn-secondary" id="downlink">Click Down</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
  </div>
</div>

    </div>
@endsection
@push('script')
	<script>
		  'use strict';
        (function($){
            $('.umd').on('click', function () {
				var modal = $('#user_info');
		
			if($(this).data('rank') != ''){
			    modal.find('#rank_n').text($(this).data('rank'));
			}else{
			    modal.find('#rank_n').text('No Rank');
			}
				
				
				modal.find('#right').text($(this).data('right'));
				modal.find('#left').text($(this).data('left'));
				modal.find('#middle').text($(this).data('middle'));
				var dlink = "{{ config('app.url','url')}}"+'user-tree/';
				modal.find('#downlink').attr('href',dlink+$(this).data('username'));
			})})(jQuery)

	</script>
@endpush