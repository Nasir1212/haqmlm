<ul>
@foreach ($tree as $data)
<li class="hierarchy">
    <div id="5" class="node">
<span class="office">{{$data['username']}}</span>
<div class="title">
    <a href="http://127.0.0.1:8000/user-unilevel-tree/{{$data['username']}}">
        <img class="avatar" src="https://haqmultishop.com/storage/uploads/users/379297inbound518015285271990375.jpg" alt="profile"></a><i class="oci oci-menu parentNodeSymbol"></i>
    
    
    </div>
<div class="content">
<div>Mohammad abdul Kader</div>
<div>01852343829</div>
<div>Current Point - 691</div>
<div> 2025 - Feb | 100</div>
<div> Team Points 200</div>
<div> Total Sponsors 4</div>
</div>
<i class="edge verticalEdge bottomEdge oci"></i>
</div>
@if ( count($data['childrenn']) > 0)
                @include('Admin.user.unilevel-tree-child', ['tree' => $data['childrenn']])  
                @endif
</li>

@endforeach

</ul>