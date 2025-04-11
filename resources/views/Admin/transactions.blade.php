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
							<h4>Report  </h4>
							@if (auth()->user()->id == 1)
							<div class="row">
								<div class="col-6">
									<form action="{{ route('Transaction_list')}}" method="get" class="d-inline-block">
										@csrf
										<label for="username">Username</label>
										<br>
										<input type="search" id="username" name="username" class="form-control w-50 d-inline-block" placeholder="username" value="<?php if(isset($_GET['username'])){ echo $_GET['username']; }else{ echo "hms"; } ?>">
										<input type="hidden" name="remark" value="{{ $_GET['remark']}}">
										<button type="submit" class="btn btn-info">Search</button>
									</form>
								</div>
								<div class="col-6">

								
								</div>
							</div>
						@endif
							<hr>
							<a href="{{ route('Transaction_list',['remark'=>'monthly_income']) }}" class="btn btn-dark mb-2">Bonus Statement </a>
							<a href="{{ route('Transaction_list',['remark'=>'refer_bonus']) }}" class="btn btn-dark mb-2">Refer Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'sponsor_bonus']) }}" class="btn btn-dark mb-2">Sponsor Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'direct_bonus']) }}" class="btn btn-dark mb-2">Cashback Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'working_bonus']) }}" class="btn btn-dark mb-2">Working Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'non_working_gen_bonus']) }}" class="btn btn-dark mb-2">Non Working Generation Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'non_working_matrix_bonus']) }}" class="btn btn-dark mb-2">Non Working Matrix Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'life_tile_insentive']) }}" class="btn btn-dark mb-2">Life time Incentive</a>
							<a href="{{ route('Transaction_list',['remark'=>'qualify_yearly_bonus']) }}" class="btn btn-dark mb-2">Qualify Yearly Bonus</a>
							<a href="{{ route('Transaction_list',['remark'=>'death_benefit']) }}" class="btn btn-dark mb-2">Death Benefit</a>
							<a href="{{ route('Transaction_list',['remark'=>'point_history']) }}" class="btn btn-dark mb-2">Point History</a>
							<a href="{{ route('Transaction_list',['remark'=>'auto_point_submit_history']) }}" class="btn btn-dark mb-2">Auto Point Submit History</a>
							<a href="{{ route('Transaction_list',['remark'=>'self_point_submit_history']) }}" class="btn btn-dark mb-2">Self Point Submit History</a>
                        <hr>
@if ($monthly_income_part == 0)
@if ($userinfo == 1)
<div class="row">
	<div class="col-12">
	
		<h3 class="text-center">Username -- {{$user->username}}</h3>
		<hr>
	</div>
	<div class="col-6">
		<h4> Name: {{ $user->name }}</h4>
		<h4> Phone: {{ $user->phone }}</h4>
		<h4> Email: {{ $user->email }}</h4>
	</div>

	<div class="col-6 text-right">
		
		<h4>Sponsor Name: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->name; } ?></h4>
		<h4>Sponsor Phone: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->phone; } ?></h4>
		<h4>Sponsor Email: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->email; } ?></h4>
	
	</div>
	
</div>
@endif

@if(isset($transactions[0]) && $transactions[0]->remark == 'self_pv_submit')
<table class="table custom-table table-bordered table-striped m-0">
								
	<thead>
		<tr>
			<th>SPS Date</th>
			<th>Date</th>
			<th>User</th>
			<th>Transaction</th>
			<th>Points</th>
			<th>Prev Points</th>
			<th>Remark</th>
			<th>Details</th>
		</tr>
	</thead>
	<tbody>
		
		@foreach ( $transactions as $transaction )
			<tr>
				<td>{{ $transaction->created_at }}</td>
				<td>{{ $transaction->admin_recollect_date }}</td>
				<td>
					<?php if(isset($transaction->userdata)){ ?>
						<a class="btn btn-info" href="{{ route('userdt',['username'=>$transaction->userdata->username])}}">{{ $transaction->userdata->username }}</a> 
					<?php } ?>
					
				</td>
				<td>{{ $transaction->trx }}</td>
				<td>{{ formatAmount($transaction->amount)}}
					@if($gsd->id == 1)
				@if($transaction->remark == 'auto_pv_submit')
				<form action="{{ route('auto_pv_collection_back_action') }}" method="post">
				    @csrf
					<input type="hidden" name="id" value="{{ $transaction->id }}"> 
					<input type="hidden" name="single" value="1"> 
					<input type="hidden" name="date" value="{{ $transaction->created_at->format('Y-m-d') }}">
					<input type="hidden" name="user_id" value="{{ $transaction->user_id}}"> 
					<button class="btn btn-warning">Back</button>
				</form>
				@endif
				@endif
				</td>
				<td>{{ $transaction->post_balance}}</td>
				<td>{{ $transaction->remark}}</td>
				<td>{{ $transaction->details }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" class="text-center"></td>
		</tr>
	</tfoot>
</table>
{{ $transactions->links() }}
@else
<table class="table custom-table table-bordered table-striped m-0">
								
	<thead>
		<tr>
			<th>Date</th>
			<th>User</th>
			<th>Transaction</th>
			<th>Amount</th>
			<th>Prev Balance</th>
			<th>Remark</th>
			<th>Details</th>
		</tr>
	</thead>
	<tbody>
		
		@foreach ( $transactions as $transaction )
			<tr>
				<td>{{ $transaction->created_at }}</td>
				<td>
					<?php if(isset($transaction->userdata)){ ?>
						<a class="btn btn-info" href="{{ route('userdt',['username'=>$transaction->userdata->username])}}">{{ $transaction->userdata->username }}</a> 
					<?php } ?>
					
				</td>
				<td>{{ $transaction->trx }}</td>
				<td>{{formatAmount($transaction->amount)}}
					@if($gsd->id == 1)
				@if($transaction->remark == 'auto_pv_submit')
				<form action="{{ route('auto_pv_collection_back_action') }}" method="post">
				    @csrf
					<input type="hidden" name="id" value="{{ $transaction->id }}"> 
					<input type="hidden" name="single" value="1"> 
					<input type="hidden" name="date" value="{{ $transaction->created_at->format('Y-m-d') }}">
					<input type="hidden" name="user_id" value="{{ $transaction->user_id}}"> 
					<button class="btn btn-warning">Back</button>
				</form>
				@endif
				@endif
				</td>
				<td>{{ formatAmount($transaction->post_balance)}}</td>
				<td>{{ $transaction->remark}}</td>
				<td>{{ $transaction->details }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" class="text-center"></td>
		</tr>
	</tfoot>
</table>

{{ $transactions->links() }}
@endif
@elseif ($monthly_income_part == 2)
@if (auth()->user()->id == 1)
<h3>Point History Filter With Date</h3>
<form action="{{ route('Transaction_list')}}" method="get" class="d-inline-block">
	@csrf
	<div class="row">
		<div class="col-8"><input type="month" id="date" name="date" class="form-control" value="<?php echo date('Y-m'); ?>">	</div>
		<div class="col-4">
			<input type="hidden" name="remark" value="date_point_history">
			<button type="submit" class="btn btn-info">Search</button>
		</div>
	</div>
</form>
<hr>
@endif

<table class="table custom-table table-bordered table-striped m-0">
	<thead>
	<tr>
		<th>Join Date</th>
		<th>Pv Submit Date</th>
		<th>Username</th>
		<th>Full Name</th>
		<th>Point</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($pointHistory as $ph)
		<tr>
			<td>{{$ph->user->created_at }}</td>
			<td>{{$ph->created_at}}</td>
			<td>{{$ph->user->username }}</td>
			<td>{{$ph->user->name }}</td>
			<td>{{$ph->point}}</td>
		</tr>
		@endforeach
	
	</tbody>
</table>
{{ $pointHistory->links() }}
@else
<h2>You can filter income report with month and year</h2>
<?php if(!isset($dwnhidden)) { ?>
<form action="{{ route('Transaction_report_sheet') }}" method="post" class="d-inline-block mr-3">
	@csrf
	<?php if(isset($_GET['date'])):
	if(auth()->user()->id == 1): ?>
		<input type="hidden" name="username" class="form-control" placeholder="username" value="<?php if(isset($_GET['username'])){ echo $_GET['username'];} ?>">
		<?php endif ?>
		<input type="hidden" id="date" name="date" class="form-control" value="<?php if(isset($_GET['date'])){ echo $_GET['date']; } ?>">
	<?php endif  ?>
	
	<button type="submit" class="btn btn-info">Bonus Sheet </button>
</form>
<?php } ?>
<form action="{{ route('Transaction_list')}}" method="get" class="d-inline-block">
	@csrf
	
	<div class="row">
		@if (auth()->user()->id == 1)
		<div class="col-4"><input type="search" name="username" class="form-control" placeholder="username" value="<?php if(isset($_GET['username'])){ echo $_GET['username']; }else{ echo "hms"; } ?>"></div>
		<div class="col-4"><input type="month" id="date" name="date" class="form-control" value="<?php if(isset($_GET['date'])){ echo $_GET['date']; }else{ echo date('Y-m'); } ?>">
		@else
		<div class="col-8"><input type="month" id="date" name="date" class="form-control" value="<?php if(isset($_GET['date'])){ echo $_GET['date']; }else{ echo date('Y-m'); } ?>">
		@endif
		
		<input type="hidden" name="remark" value="income_filter">
		</div>

		<div class="col-4"><button type="submit" class="btn btn-info">Search</button></div>
	</div>
</form>

<hr>
@if ($userinfo == 1)
<div class="row">
	<div class="col-12">
		<h3 class="text-center">Username -- {{$user->username}}</h3>
		<hr>
	</div>
	<div class="col-6">
		<h4> Name: {{ $user->name }}</h4>
		<h4> Phone: {{ $user->phone }}</h4>
		<h4> Email: {{ $user->email }}</h4>
	</div>
	<div class="col-6 text-right">
		<h4>Sponsor Name: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->name; } ?></h4>
		<h4>Sponsor Phone: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->phone; } ?></h4>
		<h4>Sponsor Email: <?php if(!empty($user->sponsor) == false){ echo $user->sponsor->email; } ?></h4>
	</div>
</div>
@endif
<table class="table custom-table table-bordered table-striped m-0">
	<thead>
	<tr>
		<th>Earning Type</th>
		<th>Amount</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td>Direct Bonus</td>
			<td>{{ $monthly_income['DirectBonusTransaction'] }}</td>
		</tr>
		<tr>
			<td>Sponsor Bonus</td>
			<td>{{ $monthly_income['SpbTransaction'] }}</td>
		</tr>
		<tr>
			<td>Working Bonus</td>
			<td>{{ $monthly_income['WgbTransaction'] }}</td>
		</tr>
		<tr>
			<td>Non Working Generation Bonus</td>
			<td>{{ $monthly_income['NwmtgTransaction'] }}</td>
		</tr>
		<tr>
			<td>Non Working Matrix Bonus</td>
			<td>{{ $monthly_income['NwmtbTransaction'] }}</td>
		</tr>
		<tr>
			<td>Life Time insentives </td>
			<td>0</td>
		</tr>
		<tr>
			<td>Qualify Yearly Bonus </td>
			<td>0</td>
		</tr>
		<tr>
			<td>Death Benefit </td>
			<td>0</td>
		</tr>
	</tbody>
</table>

@endif

							
						</div>
					</div>
				</div>

			</div>
		</div>
    </div>

	
@endsection
