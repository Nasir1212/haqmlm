@extends('layouts.Back.app')
@section('content')
<style>
	  .user-tag {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        display: flex;
        align-items: center;
    }

    .user-tag .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .user:hover {
        background-color: #f0f0f0;
    }
</style>
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Sms Sender</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
			<div class="row gutters">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	
					<div class="card">
						<div class="card-body">
							<form action="{{ route('sms_sending_action')}}" method="post">
								@csrf
							
                           
									<div class="form-group">
										<label for="sms_type" class="w-100 font-weight-bold mb-1">User Selection System<span class="text-danger">*</span></label>
										<select name="sms_type" id="sms_type" class="form-control">
										    <option value="auto">
												Auto All User Number
											</option>
											<option value="manual">
												Manual Number
											</option>
											
										
										</select>
									</div>
								<div class="form-group">
									<label class="w-100 font-weight-bold mb-1" for="manual_sms_numbers">Manual Sms Numbers ----<span class="text-danger"> If is it manual</span></label>
									<input class="form-control" placeholder="017xxxx, 019xxx, 01300xxx" id="manual_sms_numbers" name="manual_sms_numbers">
								
								</div>
								<div class="form-group">
									<label class="w-100 font-weight-bold mb-1" for="sms_body">Sms Body<span class="text-danger">*</span></label>
									<textarea class="form-control" rows="3" cols="5" id="sms_body" name="sms_body"></textarea>
								
								</div>
							
								<button type="submit" class="btn btn-success">Send</button>
							</form>
						</div>
					</div>
	
				</div>

				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<h5 class="text-center m-3">User Notification </h5>

				<div class="card">
					<div class="card-body">
						<form action="{{ route('send_notification_action')}}" method="post">
							@csrf
						
						
								<div class="form-group">
									<label for="notification_type" class="w-100 font-weight-bold mb-1">User Selection System<span class="text-danger">*</span></label>
									<select name="notification_type" id="notification_type" class="form-control" onchange="if(this.value=='manual'){document.getElementById('user_selection').style.display='block';}else{document.getElementById('user_selection').style.display='none';}">
										<option value="all">
											All User ID 
										</option>
										<option value="manual">
											Manual ID
										</option>
									</select>
								</div>

							<div class="form-group" id="user_selection" style="display: none;">
								<!-- User name input -->
							<label class="w-100 font-weight-bold mb-1" for="user_name">
								User name <span class="text-danger"> If is it manual</span>
							</label>

							<!-- Selected user tags -->
							<div id="selected-users" style="display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 5px;"></div>

							<input type="text" class="form-control" placeholder="Search By User name" id="user_name" autocomplete="off">

							<div class="user-list" id="user_list" style="display: none; border: 1px solid #ccc; max-height: 150px; overflow-y: auto;">
								<ul id="users" style="list-style: none; padding: 0; margin: 0;">
									@php
										use App\Models\User;
										$users = User::all();
									@endphp
									@foreach($users as $user)
										<li class="user" data-id="{{ $user->id }}" style="padding: 5px; cursor: pointer;">
											{{ $user->username }}
										</li>
									@endforeach
								</ul>
							</div>
						</div>


							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="notification_body">Notification Body<span class="text-danger">*</span></label>
								<textarea class="form-control" rows="3" cols="5" id="notification_body" name="notification_body"></textarea>
							
							</div>
						
							<button type="submit" class="btn btn-success">Send Notification</button>
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
	 const input = document.getElementById('user_name');
    const userList = document.getElementById('user_list');
    const users = document.querySelectorAll('.user');
    const selectedUsersContainer = document.getElementById('selected-users');

    const selectedUserIds = new Set();

    input.addEventListener('input', () => {
        const query = input.value.toLowerCase();
        userList.style.display = 'block';
        users.forEach(user => {
            const name = user.textContent.toLowerCase();
            user.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    users.forEach(user => {
        user.addEventListener('click', () => {
            const id = user.dataset.id;
            const name = user.textContent;

            if (!selectedUserIds.has(id)) {
                selectedUserIds.add(id);

                const tag = document.createElement('div');
                tag.classList.add('user-tag');
                tag.innerHTML = `
                    ${name}
                    <span class="remove-tag" data-id="${id}">&times;</span>
                    <input type="hidden" name="user_ids[]" value="${id}">
                `;
                selectedUsersContainer.appendChild(tag);

                input.value = '';
                userList.style.display = 'none';
            }
        });
    });

    selectedUsersContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-tag')) {
            const id = e.target.dataset.id;
            selectedUserIds.delete(id);
            e.target.parentElement.remove();
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            userList.style.display = 'none';
        }
    });

    input.addEventListener('focus', () => {
        userList.style.display = 'block';
    });
</script>
@endpush