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


<div class="table-responsive mb-3">
	<h3>Royality Fund Balance -- @php echo $royality_fund @endphp   <form class="d-inline mb-2" action="#" method="post">
	  @csrf
	  <button type="submit" class="btn btn-success mb-2">Balance Send</button>
  </form></h3>

	  <hr>
	  
	  <h4>Brand Promooters - @php echo count($brand_promoters); @endphp --- Sending Condition -- 0% </h4>
	  <hr>
	  <table class="table custom-table table-bordered table-striped m-0">
		  <thead>
			  <tr>
				  <th>Name </th>
				  <th>Username </th>
				  <th>Rank</th>
			  
			  </tr>
		  </thead>
		  <tbody>
			  @foreach ( $brand_promoters as $data )
				  <tr>
					 <td>{{ $data->name}}</td>
					  <td>{{ $data->username}}</td>
					  <td>{{ $data->user_rank }}</td>
				  </tr>
			  @endforeach
		  </tbody>
		  <tfoot>
			  <tr>
				  <td colspan="5" class="text-center"></td>
			  </tr>
		  </tfoot>
	  </table>
  </div>
						<div class="table-responsive mb-3">
						  <h3>Royality Fund Balance -- @php echo $royality_fund @endphp   <form class="d-inline mb-2" action="#" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success mb-2">Balance Send</button>
                        </form></h3>
				
						    <hr>
						    
						    <h4>Marketing managers - @php echo count($marketing_managers); @endphp --- Sending Condition -- {{ $mmc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $mmc->rank_royality;
						    echo $tt;
						    @endphp</h4>
						    <hr>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $marketing_managers as $data )
										<tr>
										   <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						
						<div class="table-responsive my-4">
						    <h4>Executive Managers  - @php echo count($executive_managers); @endphp --- Sending Condition -- {{ $emc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $emc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $executive_managers as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>Assistant General Managers  - @php echo count($assistant_general_managers); @endphp --- Sending Condition -- {{ $agmc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $agmc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $assistant_general_managers as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>Deputy General Managers  - @php echo count($deputy_general_managers); @endphp --- Sending Condition -- {{ $dgmc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $dgmc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $deputy_general_managers as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>General Managers  - @php echo count($general_managers); @endphp --- Sending Condition -- {{ $gmc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $gmc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $general_managers as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>Executive Directors  - @php echo count($executive_directors); @endphp --- Sending Condition -- {{ $edc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $edc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $executive_directors as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>Ruby Directors  - @php echo count($ruby_directors); @endphp --- Sending Condition -- {{ $rdc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $rdc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $ruby_directors as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="table-responsive my-4">
						    <h4>Dimond Directors  - @php echo count($dimond_directors); @endphp --- Sending Condition -- {{ $ddc->rank_royality }}% > Total amount -- @php
						    
						    $tt = $royality_fund / 100 *  $ddc->rank_royality;
						    echo $tt;
						    @endphp</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
									    <th>Name </th>
									    <th>Username </th>
									    <th>Rank</th>
									
									</tr>
								</thead>
								<tbody>
									@foreach ( $dimond_directors as $data )
										<tr>
										    <td>{{ $data->name}}</td>
											<td>{{ $data->username}}</td>
											<td>{{ $data->user_rank }}</td>
										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
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
         
            width:50%;
            padding:20px;
            background:#fff;
        }
        .user_plate .Right{
         
            width:50%;
            padding:20px;
            background:#fff;
        }
    </style>
@endsection