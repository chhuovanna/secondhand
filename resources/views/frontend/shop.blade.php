@extends('frontend.layouts.indexlayout')
@section('content')

<section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="filter-col4 p-b-27">
                            <div class="mtext-102 cl2 p-b-15 testoutput">
                                <!-- Director -->
                            </div>

                            <div class="flex-w p-t-4 m-r--5">
                                </div>
                        </div>
                    </div>
                </div>
            </div>


<div class="row isotope-grid">
                @foreach ($sellers as $seller)
                    @php /*$director = str_replace(' ','-',$seller->director);*/$director='test';@endphp
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$director}}" data-mid="{{$seller->seller_id}}">

                    
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            @if($seller->image->file_name)
                            <img src="{{asset($seller->image->location)}}/{{$seller->image->file_name}}" alt="IMG-SELLER">
                            @else
                            <img src="{{asset('images/image')}}/default.png" alt="IMG-SELLER">
                            @endif
                            <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-mid="{{$seller->seller_id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                

                                <span class="stext-105 cl3 ">
                                    <b class="title">{{$seller->Name}}</b>
                                </span>


                                <span class="stext-105 cl3 year">
                                    {{$seller->Address}}
                                </span>

                                <span class="stext-105 cl3 director">
                                    {{$seller->Email}}
                                </span>
                                <span class="stext-105 cl3 director">
                                    {{$seller->Phone}}
                                </span>
                                <span class="stext-105 cl3 director">
                                    {{$seller->Message_Account}}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="{{asset('cozastore')}}/images/icons/icon-heart-01.png" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('cozastore')}}/images/icons/icon-heart-02.png" alt="ICON">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>


            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <input id="offset" value="0" type='hidden'>
                <a href="javascript:void(0);" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadmore">
                    Load More
                </a>
            </div>
            
        </div>
    </section>

<script src="{{asset('cozastore')}}/js/main.js"></script>

    @stack('after-scripts')

</body>
</html>
@endsection



@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-shop').addClass('active-menu');
    </script>
@endpush	