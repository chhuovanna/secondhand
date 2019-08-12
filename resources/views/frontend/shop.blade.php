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
                    @php
                        $category = "";
                        $category_name = "";
                        $categories = $seller->category;
                        foreach ($categories as $ele){
                            $category .= str_replace(' ','-',$ele->name). " ";
                            $category_name .= $ele->name. ", ";
                        }
                        $category_name = substr($category_name,0,strlen($category_name )-2);

                    @endphp
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$category}}" data-seller_id="{{$seller->seller_id}}">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            @if($seller->file_name)
                            <img src="{{asset($seller->location)}}/{{$seller->file_name}}" alt="IMG-SELLER">
                            @else
                            <img src="{{asset('images/thumbnail')}}/default.png" alt="IMG-SELLER">
                            @endif
                            <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-seller_id="{{$seller->seller_id}}">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">


                                <span class="stext-105 cl3 ">
                                    <b class="pname">{{$seller->name}}</b>
                                </span>


                                <span class="stext-105 cl3 price">
                                    {{$seller->address}}
                                </span>
                                <span class="stext-105 cl3 email">
                                    {{$seller->email}}
                                </span>
                                <span class="stext-105 cl3 phone">
                                    {{$seller->phone}}
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
                @php $num_seller = sizeof($sellers);@endphp

                <input id="offset" value="{{$num_seller}}" type='hidden'>
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