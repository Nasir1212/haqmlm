

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'HMS') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/backend/css/notify.css') }}"> --}}
    <!-- Custom CSS -->
    <style>

#dialogBox {
    min-width: 70px;
    border-radius: 5px;
    font-size: 14px;
}

#closeDialog{
    border: none;
    font-size: 21px;
    cursor: pointer;
    color: red;
    background: white;
    float: right;
    overflow: hidden;
    margin: 0;
    padding: 0;
    width: 13px;
    height: 30px;
    text-align: center;
    font-weight: bolder;
}
        .tree-container {
          
            position: relative;
            height: 75vh;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            overflow-x: auto; /* Enable horizontal scrolling */
            white-space: nowrap;
        }

        
        .tree {
            /* width:100000px; */
            width: 100%;
            position: absolute;
            /* left: 10%; */
            top: -4%;
            
        

   

            
        }
        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
        }
        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
        }
        .tree li::before, .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }
        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }
        .tree li a {
   
    padding: 1px 2px;
    text-decoration: none;
    color: #666;
    font-family: Arial, sans-serif;
    font-size: 12px;
    display: inline-block;
    border-radius: 5px;
    transition: all 0.5s;
}
        /* .tree li a:hover {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        } */
        .button-container {
    text-align: center;
    margin-top: 20px;
    display: flex;
}
.button-container a {
    display: inline-block;
    margin: 0 10px;
    padding: 2px 12px;
    font-size: 14px;
    color: #fff;
    background-color: #007bff;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}
        .button-container a:hover {
            background-color: #0056b3;
        }
        
ul li:first-child::before {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: none; /* Removes the top border */
    width: 50%;
    height: 20px;
}

    ul li:last-child::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: none; /* Removes the top border */
    width: 50%;
    height: 20px;
}
#stt {
    background: #b7e3fd;
    margin-left: 32px;
}
#stt::after {
    content: '';
    position: absolute;
    top: 51px;
    right: 50%;
    border-left: 1px solid #ccc;
    width: 2px;
    height: 20px;
    display: none;
}
li .aa{
    display:inline-block;
}
/* .data-box {
    display: block;
    background: #e2ffd1;
    padding: 10px;
} */


.tree-container {
    overflow: hidden;
    user-select: none;
    touch-action: none;
    width: 83rem;
    margin: 0 auto;
    transform: translateX(-106px);

}

.data-box{
    height: 8rem;
    box-sizing: content-box;
    border: 2px solid gold;
    border-radius: 0px 0px 25px 25px;
}

.box_img{
    width: 100px;
    height: 100px;
    border-radius: 5% 5% 0% 0%;
    border: 2px solid gold;
}

.card{
    background: #d7e7f1
}
.data-box div {
    font-size: 10px;
    font-weight: bold;
    margin-top: 2px;
   
}

.show_text{
    overflow: hidden;
    word-wrap: break-word;
    white-space: normal;
    width: 6rem;
    line-height: 1;
}
.card p {
    margin-bottom: 0rem;
    font-weight: bold;
    font-size: 10px;
}

    </style>
</head>
{{-- @dd(file_exists(asset($user->user_pic_path.$user->user_pic))); --}}

<body>
    {{-- <x-notify::notify /> --}}
    <div class="container mt-5">
        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div style="display: flex;justify-content: center;align-items: center;">
            <img style="width: 50px;height:50px" src="{{url('/')}}/assets/logo.png" alt="">
            <h1 class="text-center">Sponsor Team</h1>

        </div>
        
        {{-- <div class="button-container">
            <a href="#" class="button" id="zoomIn">+</a>
            <a href="#" class="button" id="zoomOut">-</a>
            <a href="{{route('dashboard_index')}}" class="button" id=""> back </a>
        </div> --}}

        <div style="display: flex;align-items: center;flex-direction: row-reverse;  justify-content: space-between;">
            <div>
                <div>
                   <form id="user_search_form" method="get" action="{{ route('my_sponsors') }}" 
          style="display: flex; justify-content: end; align-items: center;">
        
        <input type="text" class="form-control form-control-sm w-50 d-inline-block" 
               placeholder="User ID" name="id" id="searchInput">
               <input type="hidden" name="is_jump" value="ok">
        
        <button type="submit" id="jump_submit_btn" class="btn btn-primary btn-block btn-sm">Jump</button>
    </form>
                </div>
            </div>
            
            <div class="button-container">
                <a href="#" class="button" id="zoomIn">+</a>
                <a href="#" class="button" id="zoomOut">-</a>
                <a href="{{route('dashboard_index')}}" class="button" id=""> back </a>
            </div>
        </div>
      <div class="tree-container" id="tree-container">
    <div class="tree" id="tree" style="">
        <ul class="child_tree">
            @if ($user)
            @php
                 $crcs = \App\Models\CustomerRankCondition::latest('target_point')->get();
            $crn = '';
            foreach($crcs as $crc){
            if($crc->target_point <= $user->total_submitted_point){
                $crn = $crc->rank_name;
            break;
            }
            }
            @endphp
                <li id="first_li" >
                    <a href="#" id="stt" class="aa">
                        <p style="margin-bottom: 0rem"  data-user='[]'>{{$user->username}}</p> 
                        <div>
                        <img class="box_img" src="{{$user->user_pic != null ?asset($user->user_pic_path.$user->user_pic): url('/assets/logo.png')}}">
                         <div class="data-box">
                             <div class="show_text">
                               {{ $user->name }}
                             </div>
                           
                             <div style='color:green' onclick="window.location.href='tel:{{$user->phone}}'">
                            {{ $user->phone }}
                            </div>
                             <div>
                              Current Point {{ intval($user->point) }}
                            </div>
                             <div>
                              LSP 
                              @if (\Carbon\Carbon::parse($user["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7)))
                              {{$user["submitted_point"]}}
                              @else 0 @endif
                              
                              {{-- {{ $user->submitted_point }} --}}
                            </div>
                            <div style="color: green" id="{{route('fetch_total_team_point_by_sponsors',['id'=>$user['username']])}}"  onclick="show_tp(this.id,event)">
                                Team Points
                              
                              
                            </div>
                             <div>
                                {{$user["user_rank"] == ''?'No Rank':$user["user_rank"]}} | {{$crn==''?'No Rank':$crn}}
                            </div>
                            <div>
                               {{$user->customer_rank }}
                            </div>
                            <div>
                              
                                 First Sponsor - {{$user->first_sponsor->count()}}
                            </div>
                        
                           
                        </div>
                        </div>
                    </a>
                 
                    @if ($sponsors->count() > 0)
                        @include('Admin.tree', ['users' =>$sponsors])
                    @endif
                </li>
            @else
                <li>No User Found</li>
            @endif
        </ul>
    </div>
</div>

       
    </div>
    <!-- Include Panzoom.js -->
    <script src="https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="{{ asset('assets/backend/js/notify.js') }}"></script> 
    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script> --}}

    <script>
        

document.addEventListener('DOMContentLoaded', () => {
            const treeElement = document.getElementById('tree'); // The tree element
            const treeContainer = document.getElementById('tree-container'); // Container for panning/zooming
            
            // Initialize Panzoom
            const panzoom = Panzoom(treeElement);

            // Attach zoom buttons
            document.getElementById('zoomIn').addEventListener('click', (e) => {
                e.preventDefault();
                panzoom.zoomIn();
            });

            document.getElementById('zoomOut').addEventListener('click', (e) => {
                e.preventDefault();
                panzoom.zoomOut();
            });

            // Attach mouse wheel zooming
            treeContainer.addEventListener('wheel', panzoom.zoomWithWheel);

            // Optional: Node click behavior
            // document.querySelectorAll('.tree li a').forEach(node => {
            //     node.addEventListener('click', (e) => {
            //        // e.preventDefault();
            //       //  alert(`You clicked on ${node.textContent}`);
            //     });
            // });
        });

        document.addEventListener('DOMContentLoaded', () => {
    let tree = document.getElementById('tree'); // The parent tree element
    let treeContainer = document.getElementById('tree-container'); // The container
    let child_li = document.getElementsByClassName('child_li'); // Get all child elements

    if (child_li.length > 0) { 
        let totalWidth = child_li[0].getBoundingClientRect().width * child_li.length;
        tree.style.width = `${totalWidth +100}px`; //

    //     if(totalWidth >= 1200){
    //     tree.style.width = `${totalWidth -200}px`; //       
    // }else{
    //         tree.style.width = `${1000}px`; //       

    //     }
        setTimeout(() => {
            treeContainer.scrollLeft = (treeContainer.scrollWidth - treeContainer.clientWidth) / 2;
            
        }, 100); 
    } else {
        console.warn("No elements with class 'child_li' found.");
    }

let treesP = document.querySelectorAll('li p'); // The tree element

// treesP.forEach((tree)=>{
//         console.log(tree)
   

// })
// Hide dialog when clicking outside

document.addEventListener('click', (event) => {
    if (!dialogBox.contains(event.target) && !tree.contains(event.target)) {
        dialogBox.style.display = 'none';
    }
});

let dialogBox = document.createElement('div');
dialogBox.id = 'dialogBox';
dialogBox.style.position = 'absolute';
dialogBox.style.display = 'none'; // Hide initially
dialogBox.style.background = 'white';
dialogBox.style.border = '1px solid #ccc';
dialogBox.style.padding = '10px';
dialogBox.style.boxShadow = '2px 2px 10px rgba(0,0,0,0.2)';
dialogBox.style.zIndex = '1000';
document.body.appendChild(dialogBox);

});

function show_tp(url,event) {
   
  
// Create a dialog box dynamically


    let x = event.pageX; // Cursor X position
        let y = event.pageY; // Cursor Y position
        let screenWidth = window.innerWidth; // Get screen width
        let screenHeight = window.innerHeight; // Get screen height
        let dialogWidth = 200; // Approximate width of the dialog
        let dialogHeight = 100; // Approximate height of the dialog

        // Adjust X position if the dialog box is too close to the right edge
        if (x + dialogWidth > screenWidth) {
            x = screenWidth - dialogWidth - 10; // Push it left
        }

        // Adjust Y position if the dialog box is too close to the bottom edge
        if (y + dialogHeight > screenHeight) {
            y = screenHeight - dialogHeight - 10; // Push it up
        }


    // Set the dialog position
    dialogBox.style.left = `${x}px`;
    dialogBox.style.top = `${y}px`;
    dialogBox.style.display = 'block'; // Show dialog

    // Set dialog content (You can customize this)
    dialogBox.innerHTML = `
        <div>
        <button id="closeDialog" >&times;</button>
        <div id="total_team_point">
            
        </div>
       
        </div>
    `;
    fetch(url)
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        total_team_point.innerHTML = `${data}`; // Update the total team point
    })
    .catch(error => {
        console.error('Error:', error);
    });
    // Add event listener to close the dialog
    document.getElementById('closeDialog').addEventListener('click', () => {
        dialogBox.style.display = 'none';
    });
};


    </script>
 
</body>
</html>
