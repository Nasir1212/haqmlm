@extends('layouts.Front.app') 
@section('content')


    <!--/.page-header-->
<style>
    .bg{
        background-size: cover;
        background-image:url(<?php echo asset($page->image_path.$page->image_name); ?>);
        background-repeat: no-repeat;
        background-position: center center;
        background-repeat: no-repeat;
        
    }
</style>
    <section class=" <?php if($page->image_path != ''){ echo 'bg';} ?>">
        <div class="container py-4">
              <h4>{{$page->name}}</h4>
           {!! $page->content  !!}
        </div>
    </section>
    <!--/.cta-section-->

    @endsection