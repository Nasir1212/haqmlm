@extends('layouts.Back.app')
@push('css')
	<style>
		
/* ————————————————————–
  Tree core styles
*/


.tree input {
  position: absolute;
  clip: rect(0, 0, 0, 0);
  font: unset ;
  }

.tree input ~ ul { display: none; }

.tree input:checked ~ ul { display: block; }

/* ————————————————————–
  Tree rows
*/
.tree li {
  line-height: 1.2;
  position: relative;
  padding: 0 0 1em 1em;
  }

.tree ul li { padding: 1em 0 0 1em; }

.tree > li:last-child { padding-bottom: 0; }

/* ————————————————————–
  Tree labels
*/
.tree_label {
  position: relative;
  display: inline-block;
  }

label.tree_label { cursor: pointer; }

label.tree_label:hover { color: #666; }

/* ————————————————————–
  Tree expanded icon
*/
label.tree_label:before {
  background: #000;
  color: #fff;
  position: relative;
  z-index: 1;
  float: left;
  margin: 0 1em 0 -2em;
  width: 1em;
  height: 1em;
  border-radius: 1em;
  content: '+';
  text-align: center;
  line-height: .9em;
  }

:checked ~ label.tree_label:before { content: '–'; }

/* ————————————————————–
  Tree branches
*/
.tree li:before {
  position: absolute;
  top: 0;
  bottom: 0;
  left: -0.5em;
  display: block;
  width: 0;
  border-left: 1px solid #777;
  content: "";
  }

.tree_label:after {
  position: absolute;
  top: 0;
  left: -1.5em;
  display: block;
  height: 0.5em;
  width: 1em;
  border-bottom: 1px solid #777;
  border-left: 1px solid #777;
  border-radius: 0 0 0 .3em;
  content: '';
  }

label.tree_label:after { border-bottom: 0; }

:checked ~ label.tree_label:after {
  border-radius: 0 .3em 0 0;
  border-top: 1px solid #777;
  border-right: 1px solid #777;
  border-bottom: 0;
  border-left: 0;
  bottom: 0;
  top: 0.5em;
  height: auto;
  }

.tree li:last-child:before {
  height: 1em;
  bottom: auto;
  }

.tree > li:last-child:before { display: none; }

.tree_custom {
  display: block;
  background: #ffffff;
  padding: 1em;
  border-radius: 0.3em;
}


.cd__main{
  background: #352f2f;
 padding: 40px;
  
  
}
.cd__main{

    width: 100%;
}

	</style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

@endpush
@section('content')

	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item text-dark">Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->


		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div id="tree-container" class="cd__main"></div>
          
            </div>
        </div>
        </div>
       
@endsection
@push('script')
<script>
   
function dg_null_check(data){
    if(data == '' || data == null){
        return "No Rank";
    }else{
         return data;
    }
   
}
  function displayTree(node, container,repeatl=0) {

      var $ul = $('<ul class="tree">');
      var gn = '';
   if(repeatl == 0){
    gn = 'My Account';
   }else{
     gn =  repeatl + " Generation";
   }
        var $li = $('<li>').html(  '<input type="checkbox" checked="checked" id="c'+node.id+'" /><label class="tree_label" for="c'+node.id+'"><span style="border:1px solid black;color:green;padding:5px;margin-bottom:5px;display:inline-block">'+gn+' </span><br>'+node.username+'<br>'+node.phone+'<br>'+node.email+'<br>'+dg_null_check(node.user_rank)+'<br> Direct users = '+node.user_down+'<br> Downline all users = '+node.total_user_down+'</label>');
          repeatl += 1;
          if (node.children.length > 0) {
          node.children.forEach(function (child) {
              displayTree(child, $li,repeatl);
          });
      }

      $ul.append($li);
      container.append($ul);
  }

var myObject = <?php echo $tree ?>;
var jsonString = JSON.stringify(myObject);
var jsonData = JSON.parse(jsonString);

  displayTree(jsonData, $('#tree-container'));
</script>
@endpush
