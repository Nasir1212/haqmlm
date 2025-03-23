
@if ($users->count() > 0)

    <ul class="child_tree"  >
        @foreach ($users as $child)
        @php
            
            $crcs = \App\Models\CustomerRankCondition::latest('target_point')->get();
            $crn = '';
            foreach($crcs as $crc){
                if($crc->target_point <= $child->total_submitted_point){
                    $crn = $crc->rank_name;
                    break;
                }
            }
            @endphp
        
            <li class="child_li ">
                <div class="card">
                {{-- <a href="#" style="background: #d8d8d8;" class="aa"> --}}
                    <p style="margin-bottom: 0rem"  data-user='["{{$child->phone}}","{{$child->point}}","{{$child->submitted_point}}","{{$child->user_rank}}","{{$child->customer_rank}}","{{$child->children->count()}}"]'>{{$child->username}}</p> 

                    <div>
                 <a href="{{route('my_sponsors',['id'=>$child->username])}}">
                    <img class="box_img" src="{{$child->user_pic != null ?asset($child->user_pic_path.$child->user_pic): url('/assets/logo.png')}}">
                 </a>
                    <div class="data-box">
                     
                             <div class="show_text">
                               {{ $child->name }}
                             </div>    

                             <div style='color:green' onclick="window.location.href='tel:{{ $child->phone}}'">
                             {{ $child->phone }}
                            </div>
                             <div>
                                Current Point {{ intval($child->point) }}
                            </div>
                             <div>
                                LSP   @if (\Carbon\Carbon::parse($child["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7))){{$child["submitted_point"]}}@else 0 @endif
                            </div  >
                             <div style="color: green" id="{{route('fetch_total_team_point',['id'=>$child['username']])}}"  onclick="show_tp(this.id,event)">
                                Team Points
                              
                              
                            </div>
                           
                             
                                <div>
                                    {{$child["user_rank"] == ''?'No Rank':$child["user_rank"]}} |   {{$crn==''?'No Rank':$crn}}
                                 </div>
                           
                            <div>
                               {{$child->customer_rank }}
                            </div>
                            <div>
                                 First Sponsor - {{$child->first_sponsor->count()}}
                            </div>
                    </div>
                     
                {{-- </a>   --}}
            </div>  
            {{-- </a> --}}
                </div>
            </li>         
        @endforeach
    </ul>
@endif

