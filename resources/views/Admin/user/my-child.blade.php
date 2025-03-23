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
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">

				<style>
					.tfs {
						width: 40%;
						padding: 7px 2px;
						background: #120c0c;
					}
				</style>

						<div class="table-responsive">
							<h4>{{ $page_title }}</h4>
							<form action="{{ route('my_down_line_reset')}}" class="d-inline-block" method="post">
							    @csrf
							    @if($gsd->id == 1)
							    <input type="text" name="username" placeholder="username" class="w-50 p-2 ">
							    @endif
							   <button type="submit" class="btn btn-info">Rerender</button>
							</form>
							    <hr>
								@if (auth()->user()->id == 1)
							<div class="bg-white p-3 text-center">
								
								<form action="{{ route('my_down_line')}}" method="get">
									@csrf
									<input type="search" name="username" class="p-2 w-25 border" placeholder="username">
									<button type="submit" class="btn btn-info">Search</button>
								</form>
					
							</div>
							@endif
			                <div class="user_plate">
			                    <div class="left">
			                        <h2 class="text-dark">Left Side</h2>
			                        <hr>
			                        @if(!empty($childl))
			                        <div class="h3 text-dark">Total = @php
			                        $freel=0;
			                        
			                        echo count($childl) @endphp</div>
			                        
			                        @foreach($childl as $data)
			                            <div class="btn mb-2 @if($data->invest_status == 1) btn-success @else btn-danger @endif">
			                                <a href="#">{{ $data->username }}</a>
			                            </div>
			                            
			                            <?php 
			                            
			                            if($data->invest_status == 0){
			                                $freel +=1;
			                            }
			                            
			                            
			                            ?>
			                            
			                        @endforeach
			                   
			                          <h2 class="text-dark">
			                        Paid Member --- {{ count($childl) }}
			                        </h2>
			                        @endif
			                    </div>
								<div class="Middle">
			                        <h2 class="text-dark">Middle Side</h2>
			                        <hr>
			                        @if(!empty($childm))
			                        <div class="h3 text-dark">Total = @php
			                        $freel=0;
			                        
			                        echo count($childm) @endphp</div>
			                        
			                        @foreach($childm as $data)
			                            <div class="btn mb-2 @if($data->invest_status == 1) btn-success @else btn-danger @endif">
			                                <a href="#">{{ $data->username }}</a>
			                            </div>
			                            
			                            <?php 
			                            
			                            if($data->invest_status == 0){
			                                $freel +=1;
			                            }
			                            
			                            
			                            ?>
			                            
			                        @endforeach
			   
			                          <h2 class="text-dark">
			                        Paid Member --- {{ count($childm) }}
			                        </h2>
			                        @endif
			                    </div>
			                    <div class="Right">
			                        <h2 class="text-dark">Right Side</h2>
			                        <hr>
			                        @if(!empty($childr))
			                        <div class="h3 text-dark">Total = @php 
			                        $freer =0;
			                        echo count($childr) @endphp</div>
			                        @foreach($childr as $data)
			                            <div class="btn mb-2 @if($data->invest_status == 1) btn-success @else btn-danger @endif">
			                                <a href="#">{{ $data->username }}</a>
			                            </div>
			                            
			                                <?php 
			                            
			                            if($data->invest_status == 0){
			                                $freer +=1;
			                            }
			                            
			                            
			                            ?>
			                            
			                        @endforeach
			                        
			                   
			                        <h2 class="text-dark">
			                        Paid Member --- {{ count($childr) }}
			                        </h2>
			                        @endif
			                    </div>
			                </div>
						</div>
					</div>
				</div>

			</div>
		</div>
    </div>
    <style>
        .user_plate{
            display:flex;
            width:100%;
            padding:20px;
            background:#fff;
        }
        .user_plate .left{
         
            width:33.33%;
            padding:20px;
            background:#fff;
        }
		.user_plate .Middle{
         
		 width:33.33%;
		 padding:20px;
		 background:#fff;
	 }
        .user_plate .Right{
         
            width:33.33%;
            padding:20px;
            background:#fff;
        }
    </style>
@endsection