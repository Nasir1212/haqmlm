
@if ($tree->count() > 0)

    <ul class="child_tree  @if($tree->count() == 1) pip_bar @endif" @if($tree->count() == 1) style ="margin-left:25px" @endif >

       
        @foreach ($tree as $data)

        @php
        $crcs = \App\Models\CustomerRankCondition::latest('target_point')->get();
        $crn = '';

        foreach($crcs as $crc){
        if($crc->target_point <= $data->total_submitted_point){
        $crn = $crc->rank_name;
        break;
        }
        }   
        @endphp
        
            <li class="child_li">
                {{-- <a href="#" id="stt" class="aa"> --}}

                    <p style="margin-bottom: -5px;font-size: 11px;"  data-user='["{{$data['name']}}","{{$data['email']}}","{{$data['created_at']}}","{{$data["point"]}}",@if (\Carbon\Carbon::parse($data["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7))){{$data["submitted_point"]}}@else "0" @endif,"{{$data["user_rank"]}}","{{$crn}}","{{$data["children"]->count()}}","{{route('fetch_total_team_point',['id'=>$data['username']])}}"]'>{{$data["username"]}}</p> 
                    <div style="margin-top: 4px;">
                 <a href="{{route('user_unilevel_tree',['id'=>$data['username']])}}">
                    <img style="width: 80px;height:80px;border-radius: 50%;border: 2px solid gold;" src="{{$data["user_pic"] != null ?asset($data["user_pic_path"].$data["user_pic"]): url('/assets/olter_logo.png')}}">
                    <div class="data-box">
                     
                          {{-- {{$data['username']}}  --}}
                    </div>
                     
                </a>  
            </div>  
            {{-- </a> --}}
            @if ( count($data['childrenn']) > 0)
            <ul class="child_tree"  >
                @foreach($data['childrenn'] as $data)
                @php
                $crcs = \App\Models\CustomerRankCondition::latest('target_point')->get();
                $crn = '';
                foreach($crcs as $crc){
                    if($crc->target_point <= $data->total_submitted_point){
                        $crn = $crc->rank_name;
                    break;
                    }
                }
          @endphp
                <li class="child_li">
                    {{-- <a href="#" id="stt" class="aa"> --}}
                        <p style="margin-bottom: -5px;font-size: 11px;"  data-user='["{{$data['name']}}","{{$data['email']}}","{{$data['created_at']}}","{{$data["point"]}}",@if (\Carbon\Carbon::parse($data["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7))){{$data["submitted_point"]}}@else "0" @endif,"{{$data["user_rank"]}}","{{$crn}}","{{$data["children"]->count()}}","{{route('fetch_total_team_point',['id'=>$data['username']])}}"]'>{{$data["username"]}}</p> 
    
                        <div style="margin-top: 4px;">
                     <a href="{{route('user_unilevel_tree',['id'=>$data['username']])}}">
                        <img style="width: 80px;height:80px;border-radius: 50%;border: 2px solid gold;" src="{{$data["user_pic"] != null ?asset($data["user_pic_path"].$data["user_pic"]): url('/assets/olter_logo.png')}}">
                        <div class="data-box">
                         {{-- {{$data['username']}} --}}
                               
                        </div>
                         
                    </a>  
                </div>  
                {{-- </a> --}}
                </li>
                @endforeach
               
            </ul>

            @endif
            </li>         
        @endforeach
    </ul>
@endif

