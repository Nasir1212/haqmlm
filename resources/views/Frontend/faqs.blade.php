@extends('layouts.Front.app') 
@section('content')
    <!--/.page-header-->
    <section class="blog-section blog-page bg-grey padding">
        <div class="container py-3">
            <h2 class="text-center">Questions & Answer</h2>
            <div class="row">
                <div class="col-lg-12 sm-padding">
                    <div class="accordion faq-accordion" id="faq-accordion">
                        @foreach ($faqs as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $key }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">{{ $faq->name }}</button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse <?php if($key == 0){ echo 'show';} ?>" aria-labelledby="heading{{ $key }}" data-bs-parent="#faq-accordion">
                                <div class="accordion-body">
                                    {!! $faq->content !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                      
                    </div>
                </div>
               
            </div>
        </div>
    </section>
    <!--Blog Section-->
    @endsection