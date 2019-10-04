@extends('frontend.layouts.indexlayout')
@section('content')
    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <!-- <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Product Overview
                </h3>
            </div> -->

            <div class="flex-w flex-sb-m p-b-52">

                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">

                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col1 p-r-15 p-b-27">

                        </div>

                        <div class="filter-col2 p-r-15 p-b-27">


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


{{--Load more and quick View for home page--}}

            <div class="row isotope-grid">
                @foreach ($sellers as $seller)

                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item" data-seller_id="{{$seller->seller_id}}">
                    <!-- Block2 -->
                    <div class="block2" style="height:100%">
                        <div class="block2-pic hov-img0" >
                            @if($seller->file_name)
                            <img src="{{asset($seller->location)}}/{{$seller->file_name}}" alt="IMG-SELLER">
                            @else
                            <img src="{{asset('images/thumbnail')}}/default.png" alt="IMG-SELLER">
                            @endif
                            <a href="{{route('frontend.product.showbyshop', $seller->seller_id)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 show-product-shop" data-seller_id="{{$seller->seller_id}}">
                                View Store
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">


                                <span class="stext-105 cl3 ">
                                    <b class="sname">Name: {{$seller->name}}</b>
                                </span>


                                <span class="stext-105 cl3 address">
                                    <strong>Address: </strong>{{$seller->address}}
                                </span>
                                <span class="stext-105 cl3 email">
                                    <strong>Email: </strong>{{$seller->email}}
                                </span>
                                <span class="stext-105 cl3 phone">
                                    <strong>Phone: </strong>{{$seller->phone}}
                                </span>
                                <span class="stext-105 cl3 message_account">
                                    <strong>Message Account: </strong>{{$seller->message_account}}
                                </span>
                                <span class="stext-105 cl3 type">
                                    <strong>Type: </strong>{{$seller->type}}
                                </span>

                            </div>

                            <!-- <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="{{asset('cozastore')}}/images/icons/icon-heart-01.png" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('cozastore')}}/images/icons/icon-heart-02.png" alt="ICON">
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>

                @endforeach
            </div>


            <!-- Load more -->
           <div class="flex-c-m flex-w w-full p-t-45">
                @php $num_seller = sizeof($sellers);@endphp

                <input id="offset" value="{{$num_seller}}" type='hidden'>
                <a href="javascript:void(0);" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadmore_shop">
                    Load More
                </a>
            </div>

        </div>
    </section>


@endsection
@push('after-scripts')
    <script>
        $('.active-menu').removeClass('active-menu');
        $('.menu-shop').addClass('active-menu');
    </script>
@endpush
