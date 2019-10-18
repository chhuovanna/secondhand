@extends('frontend.layouts.indexlayout')
@section('metaimage')
    @php
        if(isset($product->thumbnail)){
            $location = '/'.$product->thumbnail->location.'/'.$product->thumbnail->file_name;
        }else{
            $location = '/'.$product->thumbnail_id;
        }
        $location = url($location);
    @endphp
<meta property="og:image"           content="{{$location}}" /> 

@endsection
@section('content')

<!-- <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div> -->

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<!-- <button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="{{asset('cozastore')}}/images/icons/icon-close.png" alt="CLOSE">
				</button> -->

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w" style="top:200px"></div>

								<div class="slick3 gallery-lb">
                                    @php
                                        if(isset($product->thumbnail)){
                                            $location = '/'.$product->thumbnail->location.'/'.$product->thumbnail->file_name;
                                        }else{
                                            $location = '/'.$product->thumbnail_id;
                                        }
                                    @endphp
									 <div id='to-be-hide' class="item-slick3" data-thumb="{{$location}}">
										<div class="wrap-pic-w pos-relative">
											<img src="{{$location}}" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{$location}}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
                                    </div>
                                    @foreach($product->photo as $ele)
                                        @php
                                            $location = '/'.$ele->location.'/'.$ele->file_name;
                                        @endphp

									<div class="item-slick3" data-thumb="{{$location}}">
										<div class="wrap-pic-w pos-relative">
											<img src="{{$location}}" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{$location}}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
                                    </div>
                                    @endforeach

								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">

						<div class="p-r-50 p-t-5 p-lr-0-lg detail-text">

                            @php
                                $category_list = "";
                                foreach($product->category as $ele){
                                    $category_list .= $ele->name . ', ';
                                }
                                $category_list = substr($category_list,0,strlen($category_list )-2);
                            @endphp
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">{{$product->name}}</h4>
                            <span class="mtext-106 cl2">Price : {{$product->price}}</span>
                            <p class="stext-102 cl3 p-t-23">Description : {{$product->description}}</p>
                            <p class="stext-102 cl3 p-t-23">Availability : {{$product->status}}</p>
                            <p class="stext-102 cl3 p-t-23">Like : {{$product->like_number}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Category : </b>{{$category_list}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Seller : </b>
                                <a href="{{route('frontend.product.showbyshop',[$seller->seller_id])}}">{{$seller->name}}</a>
                            </p>
                            <p class="stext-102 cl3 p-t-23"><b>Address : </b>{{$seller->address}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Email : </b>{{$seller->email}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Phone : </b>{{$seller->phone}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Message_Account : </b>{{$seller->message_account}}</p>
                            <p class="stext-102 cl3 p-t-23"><b>Type : </b>{{$seller->type}}</p>
                            <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                @php
                                $url = urlencode(route('frontend.product.detail',[$product->product_id]));
                                @endphp
                                <iframe src="https://www.facebook.com/plugins/share_button.php?href={{$url}}&layout=button&size=small&width=59&height=20&appId" width="59" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
								<!-- <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- </div> -->


@endsection

@push('after-scripts')
<script>
    $(document).ready(function(){
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled:true
                },
                mainClass: 'mfp-fade'
            });
        });

        $('.wrap-slick3').each(function(){
            var ele = $(this).find('.slick3');

            if (ele !== null){

                ele.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    infinite: true,
                    autoplay: false,
                    autoplaySpeed: 6000,

                    arrows: true,
                    appendArrows: $(this).find('.wrap-slick3-arrows'),
                    prevArrow:'<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                    nextArrow:'<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',

                    dots: true,
                    appendDots: $(this).find('.wrap-slick3-dots'),
                    dotsClass:'slick3-dots',
                    customPaging: function(slick, index) {
                        var portrait = $(slick.$slides[index]).data('thumb');
                        return '<img src=" ' + portrait + ' "/><div class="slick3-dot-overlay"></div>';
                    },
                });

            }
        });

    })
</script>
@endpush
