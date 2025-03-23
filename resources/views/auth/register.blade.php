<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="full_name" :value="__('Full Name')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')"  autofocus autocomplete="full_name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Fathers Name -->
        <div>
            <x-input-label for="father_name" :value="__('Father\'s Name')" />
            <x-text-input id="father_name" class="block mt-1 w-full" type="text" name="father_name" :value="old('father_name')"  autofocus autocomplete="fathers_name" />
            <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
        </div>
        
         <!-- Fathers Name -->
        <div>
            <x-input-label for="mother_name" :value="__('Mother\'s Name')" />
            <x-text-input id="mother_name" class="block mt-1 w-full" type="text" name="mother_name" :value="old('mother_name')"  autofocus autocomplete="mother_name" />
            <x-input-error :messages="$errors->get('mother_name')" class="mt-2" />
        </div>
        <!-- Ref Username -->
        <div>
            <x-input-label for="ref_username" :value="__('Ref Username for Working Team')" />
            
            <input id="ref_username" class="block mt-1 w-full" type="text" name="ref_username" value="@if(isset($_GET['ref'])) {{ $_GET['ref'] }} @endif" @if(isset($_GET['ref'])) readonly @endif  required />
            <x-input-error :messages="$errors->get('ref_username')" class="mt-2" />
            <div class="realtime_ref_msg" for="ref_username"></div>

        </div>
        
        
         <!-- Sponsor Username -->
        <div>
            <x-input-label for="sponsor_username" :value="__('Sponsor Username')" />
            
            <input id="sponsor_username" class="block mt-1 w-full" type="text" name="sponsor_username" required />
            <x-input-error :messages="$errors->get('sponsor_username')" class="mt-2" />
            <div class="realtime_sponsor_msg" for="sponsor_username"></div>

        </div>

          <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" min="4" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
             <div class="realtime_username_msg" for="username"></div>
            
        </div>

      

  <!-- Phone -->
  <div class="mt-4">
    <x-input-label for="phone" :value="__('Phone')" />
    <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone" :value="old('phone')"  autocomplete="Phone" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            
             <div class="password_confirmation_msg" for="password_confirmation"></div>
        </div>
  <!--<div>-->
  <!--          <x-input-label for="uniqe_key_code" :value="__('Quniqe Id Setup - optional')" />-->
  <!--          <x-text-input id="uniqe_key_code" class="block mt-1 w-full" type="text" name="uniqe_key_code" :value="old('Existing uniqe_key_code')" />-->
  <!--          <x-input-error :messages="$errors->get('uniqe_key_code')" class="mt-2" />-->
  <!--      </div>-->
  <!--      <div class="mb-4">-->
  <!--          <div class="key_msg"></div>-->
  <!--         <button type="button" id="key_check">Key Check</button>-->
  <!--     </div>-->
       <div class="block mt-4">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="terms" required>
                <a target="_blank" href="{{ route('get_page',['slug'=>'terms-condition']) }}" class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Read & Agree With Terms & Condition') }}</a>
            </label>
        </div>
       
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <style>
        #key_check {
      color: white;
      background: blue;
      padding: 5px 10px;
      font-size: 17px;
  }
      </style>
    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script> 
    <script>
        'use strict';
      (function($){



    
    
          $('#position_review').on('change',function() {
            var ref_u = $('#ref_username').val();
              
              if(ref_u == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Referal Username !</h4>";
                    $('.ref_msg_box').html(msg);
              }else{
                var pos = $(this).val();
              $.ajax({
                  url: '{{ route('user_join_review') }}',
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                  data: { ref_username: ref_u, position: pos }, // Replace with your data
                  success: function(response) {
                      console.log(response);
                      var msg = "<h4 style='color:green;padding:10px'>New Account Setup Under <strong>"+response[0];
                     msg += " Position "+response[1]+"</strong></h4>";
                      $('.position_review_box').html(msg);
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });


//////////////////////

$('#password_confirmation').keyup(function() {
    if ($('#password').val() == $('#password_confirmation').val()) {
        $('.password_confirmation_msg').html('<h3 style="color:green;padding:10px">Password Match</h3>');
    } else {
        $('.password_confirmation_msg').html('<h3 style="color:red;padding:10px">Password Not Match!</h3>');
    }
});



 $('#username').keyup(function() {
            var username = $('#username').val();
              
              if(username == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Username !</h4>";
                    $('.realtime_username_msg').html(msg);
              }else{
                  username = username.replace(/\s+/g, '');
                  username = username.replace(/[^a-zA-Z0-9\s)(*&^%$#@!_+]/g, '');
                  $('#username').val(username);
                  
              $.ajax({
                  url: '{{ route('username__check') }}',
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                  data: { username: username }, // Replace with your data
                  success: function(response) {
                      console.log(response);
                      var msg = response[0];
                 
                      $('.realtime_username_msg').html(msg);
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });



///////////////////////

          $('#sponsor_username').keyup(function() {
            var sponsor_username = $('#sponsor_username').val();
              
              if(sponsor_username == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Sponsor Username !</h4>";
                    $('.realtime_sponsor_msg').html(msg);
              }else{
 sponsor_username = sponsor_username.replace(/\s+/g, '');
  sponsor_username = sponsor_username.replace(/[^a-zA-Z0-9\s)(*&^%$#@!_+]/g, '');
                  $('#sponsor_username').val(sponsor_username);
              $.ajax({
                  url: '{{ route('sponsor_user__check') }}',
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                  data: { sponsor_username: sponsor_username }, // Replace with your data
                  success: function(response) {
                      console.log(response);
                      var msg = response[0];
                 
                      $('.realtime_sponsor_msg').html(msg);
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });


///////////////////////

          $('#ref_username').keyup(function() {
            var ref_username = $('#ref_username').val();
              
              if(ref_username == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Refer Username !</h4>";
                    $('.realtime_ref_msg').html(msg);
              }else{
 ref_username = ref_username.replace(/\s+/g, '');
  ref_username = ref_username.replace(/[^a-zA-Z0-9\s)(*&^%$#@!_+]/g, '');
                  $('#ref_username').val(ref_username);
              $.ajax({
                  url: '{{ route('ref_user__check') }}',
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                  data: { ref_username: ref_username }, // Replace with your data
                  success: function(response) {
                      console.log(response);
                      var msg = response[0];
                 
                      $('.realtime_ref_msg').html(msg);
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });

          
          $('#key_check').on('click',function() {
            var uniqe_key_code = $('#uniqe_key_code').val();
              
              if(uniqe_key_code == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your Uniqe Key !</h4>";
                    $('.key_msg').html(msg);
              }else{
                var pos = $(this).val();
              $.ajax({
                  url: '{{ route('user_uniqe_key_check') }}',
                  method: 'POST',
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
                  data: { uniqe_key_code: uniqe_key_code, position: pos }, // Replace with your data
                  success: function(response) {
                      console.log(response);
                      var msg = "<h4 style='color:green;padding:10px'>First username <strong>"+response[0];
                     msg += " Key "+response[1]+"</strong></h4>";
                      $('.key_msg').html(msg);
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

</x-guest-layout>
