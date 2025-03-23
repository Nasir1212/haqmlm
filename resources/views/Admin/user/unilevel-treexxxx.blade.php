@extends('layouts.Back.app')

@push('css')
	<link rel="stylesheet" href="{{asset('assets/backend/tree/orgchart.css')}}">
		<link rel="stylesheet" href="{{asset('assets/backend/tree/style.css')}}">
@endpush
@section('content')

	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->


		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
     
				{{-- <div id="chart-legend">
					
					<div class="chart-legend__item">
			  <div class="chart-legend__item__color highlight-parent"></div>
					  <div class="chart-legend__item__title">Parent</div>
					</div>
			<div class="chart-legend__item">
			  <div class="chart-legend__item__color highlight-children"></div>
				  <div class="chart-legend__item__title">Children</div>
				</div>
			<div class="chart-legend__item">
			  <div class="chart-legend__item__color highlight-siblings"></div>
				  <div class="chart-legend__item__title">Siblings</div>
				</div>
                
            </div> --}}


				{{-- <div id="chart-container"></div> --}}
               

				<div id="chart-container">
                    <div class="orgchart noncollapsable" style="cursor: default;">
                        <ul class="nodes">
                          @if($tree)
                        <li class="hierarchy">
                            <div id="" class="node">
                        <span class="office">{{$tree['username']}}</span>
                        <div class="title">
                            <a href="http://127.0.0.1:8000/user-unilevel-tree/kader">
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
                    {{-- @dd($data); --}}
                    {{-- @if ($data->childrenn->isNotEmpty())
                @include('Admin.user.unilevel-tree-child', ['tree' => $data->childrenn])
            @endif --}}

            {{-- @dd($tree['childrenn'][0]['username']); --}}
                @if ( count($tree['childrenn']) > 0)
                @include('Admin.user.unilevel-tree-child', ['tree' => $tree['childrenn']])  
                @endif
                        </li>
                    
                @endif
                {{-- <li class="hierarchy">
                    <div id="21" data-parent="5" class="node">
                        <span class="office">Mizan</span>
                        <div class="title"><a href="http://127.0.0.1:8000/user-unilevel-tree/Mizan"><img class="avatar" src="https://haqmultishop.com/storage/uploads/users/545714IMG_20231202_101732.jpg" alt="profile"></a>
                            
                            
                            </div>
                        <div class="content">
                        <div>Mohammad Mizan</div>
                        <div>+8801857440649</div>
                        <div>Current Point - 55</div>
                        <div> 
                            </div>
                            <div> Team Points 0</div>
                            <div> Total Sponsors 3</div>
                        </div>
                      <i class="edge verticalEdge topEdge oci"></i>
                      <i class="edge horizontalEdge rightEdge oci"></i>
                      <i class="edge horizontalEdge leftEdge oci"></i>
                    </div>
                </li>
                <li class="hierarchy">
                    <div id="69" data-parent="5" class="node">
                        <span class="office">Jahed</span>
                        <div class="title">
                            <a href="http://127.0.0.1:8000/user-unilevel-tree/Jahed"><img class="avatar" src="https://haqmultishop.com/storage/uploads/users/6767417000545096632316000786370035462.jpg" alt="profile"></a>
                            </div>
                        <div class="content">
                        <div>Md. Jahadul Islam </div>
                        <div>01812495416</div>
                        <div>Current Point - 36</div>
                        <div> 
                            </div>
                            <div> Team Points 0</div>
                            <div> Total Sponsors 1</div>
                        </div>
                      <i class="edge verticalEdge topEdge oci"></i>
                      <i class="edge horizontalEdge rightEdge oci"></i>
                      <i class="edge horizontalEdge leftEdge oci"></i>
                    </div>
                </li>
                <li class="hierarchy">
                    <div id="86" data-parent="5" class="node">
                        <span class="office">Redoan</span>
                        <div class="title"><a href="http://127.0.0.1:8000/user-unilevel-tree/Redoan"><img class="avatar" src="https://haqmultishop.com/storage/uploads/users/164413IMG-20240322-WA0001.jpg" alt="profile"></a>
                            
                            
                            </div>
                        <div class="content">
                        <div>Md.Redoan</div>
                        <div>01631985474</div>
                        <div>Current Point - 0</div>
                        <div> 2025 - Feb | 100</div>
                        <div> Team Points 0</div>
                        <div> Total Sponsors 3</div>
                    </div>
                      <i class="edge verticalEdge topEdge oci"></i>
                      <i class="edge horizontalEdge rightEdge oci"></i>
                      <i class="edge horizontalEdge leftEdge oci"></i>
                    </div>
                  
                </li>
            </ul>
        </li> --}}
    </ul>


</div>
                </div>
		
			
            </div>
        </div>
    </div>
		<style type="text/css">
    {{--
 #chart-container {
    height: 1500px;
    background: #d5d5d5;
    overflow:scroll !important;
}
	#chart-legend {
    padding: 10px;
    width: 300px;
    margin: 0 auto;
    margin-top: 10px;
    border: 2px dashed #aaa;
    display: flex;
}
   .orgchart .node.highlight-parent .title, .chart-legend__item__color.highlight-parent {
       background-color: blue;
   }
   .orgchart .node.highlight-parent .content {
       border: 1px solid blue;
   }
   .orgchart .node.highlight-siblings .title, .chart-legend__item__color.highlight-siblings {
       background-color: green;
   }
   .orgchart .node.highlight-siblings .content {
       border: 1px solid green;
   }
   .orgchart .node.highlight-children .title, .chart-legend__item__color.highlight-children {
       background-color: #aeaeae;
   }
   .orgchart .node.highlight-children .content {
       border: 1px solid #aeaeae;
   }
   #chart-legend {
       padding: 10px;
       width: 300px;
       margin: 0 auto;
       margin-top: 10px;
       border: 2px dashed #aaa;
   }
   #chart-legend__title {
       margin-bottom: 10px;
       font-weight: bold;
   }
   .chart-legend__item {
       margin-bottom: 5px;
       padding: 5px 10px;
   }
   .chart-legend__item__color,
   .chart-legend__item__title {
       vertical-align: middle;
       line-height: 20px;
   }
   .chart-legend__item__color {
       width: 20px;
       height: 20px;
       border-radius: 20px;
   }
   .chart-legend__item div {
       display: inline-block;
   }

   /* .orgchart .node {
    box-sizing: border-box;
    display: inline-block;
    position: relative;
    margin: 0 0 20px 0;
    padding: 2px;
    border: 1px dashed transparent;
    text-align: center;
    background: #264307;
    margin: 1px 5px;
    border-radius: 10px;
    margin-bottom: 21px;
    height: 336px;
} */
	/* .orgchart .node .title {
    height: 158px;
    text-align: left;
    line-height: 40px;
    background-color: rgb(97 97 97);
    display: flex;
    flex-direction: column;
    align-items: center;
} */

.orgchart .node {
    box-sizing: border-box;
    display: inline-block;
    position: relative;
    margin: 0 0 20px 0;
    padding: 2px;
    border: 1px dashed transparent;
    text-align: center;
    background: #264307;
    margin: 1px 5px;
    border-radius: 10px;
    margin-bottom: 21px;
    height: 306px;
}

.orgchart .node .title {
    height: 129px;
    text-align: left;
    
    background-color: rgb(97 97 97);
    display: flex;
    flex-direction: column;
    align-items: center;
}
			.orgchart .node .content {
			  text-align: left;
			  padding: 5px;
			}


			.orgchart .node .content .symbol {
			  color: #aaa;
			  margin-right: 20px;
			}
			.oci-leader::before, .oci-leader::after {
			  background-color: rgba(217, 83, 79, 0.8);
			}
            .orgchart .node .avatar {
    width: 130px;
    height: 127px;
    margin: 0 auto;
}

			.oci-menu::before {
    content: "≡";
    display: inline-block;
    width: 1rem;
    height: 1rem;
    text-align: center;
    line-height: 1rem;
    color: #000;
    font-size: 2rem;
}
.orgchart .node .content {
    box-sizing: border-box;
    width: 130px;
    height: 157px;
    line-height: 20px;
    font-size: 10px;
    border: 1px solid rgba(217, 83, 79, 0.8);
    border-width: 0 1px 1px 1px;
    border-radius: 0 0 0.25rem 0.25rem;
    text-align: center;
    background-color: #fff;
    color: #333;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 0% 0% 18% 18%;
    display: inline-block;
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}
.orgchart .node .content div:nth-child(1){
    line-height:13px !important; 
}

.orgchart ul li .node:hover {
    background-color: rgb(0 0 0 / 84%) !important;
}

--}}
		  </style>
@endsection
 @push('script')
	
		{{-- <script type="text/javascript" src="{{asset('assets/backend/tree/orgchart.js')}}"></script>
		<script type="text/javascript">
			$(function() {
		var apurl = '{{ config('app.url') }}'
			var datasource = {!! $tree !!};
         

			var nodeTemplate = function(data) {
			  return `
				<span class="office">${data.username}</span>
				<div class="title">
                    
                    
                    </div>
				<div class="content">
				<div>
				${data.name}
				</div>
				</div>
			  `;
			};
		
		function vck(data,pv){
		    var months = ['Hi','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov',"Dec"]
		    if(data == '' || data == null){
		        return '';
		    }else{
		       var dvv =  data.split('-');
		       
		       // Split the string into an array
var numbersArray = dvv[1].split(',');

// Remove leading zeros from each element
for (var i = 0; i < numbersArray.length; i++) {
    // Convert each element to a number, which automatically removes leading zeros
    
    numbersArray[i] = parseInt(numbersArray[i], 10).toString();
}

// Join the array back into a string
var resultString = numbersArray.join(',');

	var resultString = resultString;
	if(resultString == 0){
	    resultString = 12;
	}
  
	 return dvv[0]+" - "+ months[resultString]+" | "+parseInt(pv);
		     
		    }
		    
		}
		
		function imgd(path,v){
		    if(path == '' || path == null || v == '' || v == null){
		        return '{{ config('app.url') }}storage/uploads/users/sq-logo.png';
		    }else{
		         return apurl+path+v;
		    }
		}
		
			var oc = $('#chart-container').orgchart({
			  'data' : datasource,
			  'nodeTemplate': nodeTemplate,
		
			  'nodeID': 'id',
			  'pan': true,
              'zoom': true,
			  'createNode': function($node, data) {
					$node.find('.title').prepend(`<a href="{{ url('/') }}/user-unilevel-tree/${data.username}"><img class="avatar" src="${imgd(data.user_pic_path,data.user_pic)}" alt="profile" /></a>`);
					$node.find('.content').prepend($node.find('.symbol'));
					$node.find('.content').append(`<div>${data.phone}</div>`);
					$node.find('.content').append(`<div>Current Point - ${parseInt(data.point)}</div>`);
					$node.find('.content').append(`<div> ${vck(data.point_submit_date, data.submitted_point)}</div>`);
					
					
						
					$node.find('.content').append(`<div> Team Points ${parseInt(data.team_point)}</div>`);
					$node.find('.content').append(`<div> Total Sponsors ${data.total_child}</div>`);
				}
			});
		
			oc.$chartContainer.on('touchmove', function(event) {
      event.preventDefault();
    });

	$(window).resize(function() {
      var width = $(window).width();
      if(width > 576) {
        oc.init({'verticalLevel': undefined});
      } else {
        oc.init({'verticalLevel': 2});
      }
    });

	oc.$chart.find('.node')
      .on('mouseenter', function() {
        oc.getParent($(this)).addClass('highlight-parent');
        oc.getSiblings($(this)).addClass('highlight-siblings');
        oc.getChildren($(this)).addClass('highlight-children');
      })
      .on('mouseleave', function () {
        oc.$chart.find('.highlight-parent, .highlight-siblings, .highlight-children')
          .removeClass('highlight-parent highlight-siblings highlight-children');
      });

	  $('.orgchart').addClass('noncollapsable'); 

		  });

          window.onload = function() {
        window.scrollBy(0, 10); // Scrolls 10 pixels down
    }; --}}
		  </script>
		  @endpush