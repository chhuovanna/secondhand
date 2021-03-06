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
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						All Category
					</button>

					@foreach($categories as $category)
						@php $classname = str_replace(' ','-', $category->name);@endphp
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".{{$classname}}">
						{{$category->name}}
					</button>
					@endforeach
					<input type="hidden" class="filter-price" value='all'>

				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>

				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>
						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" id="search_name" placeholder="Search By Name">
					</div>
				</div>




				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Sort By
							</div>

							<ul>
								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-link-active sort-by" data-sort="default">
										Default
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 sort-by" data-sort="name">
										Name
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 sort-by" data-sort="newness">
										Newness
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 sort-by" data-sort="hightolow">
										<!-- Price: Low to High -->
										Price: Low to High
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 sort-by" data-sort="lowtohigh">
										<!-- Price: High to Low -->
										Price: High to low
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Release Price
								<!-- Price -->
							</div>

							<ul>
								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-link-active filter-by" data-filter="all">
										All
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-by" data-filter="50">
										$0 - $50
										<!-- $0.00 - $50.00 -->
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-by" data-filter="100">
										$50 - $100
										<!-- $50.00 - $100.00 -->
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-by" data-filter="150">
										$100 - $150
										<!-- $100.00 - $150.00 -->
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-by" data-filter="200">
										$150 - $200
										<!-- $150.00 - $200.00 -->
									</a>
								</li>

								<li class="p-b-6">
									<a href="javascript:void(0)" class="filter-link stext-106 trans-04 filter-by" data-filter="after200">
										$200+
									</a>
								</li>
							</ul>
						</div>

						

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
				@foreach ($products as $product)
					@php
						$category = "";
						$category_name = "";
						$product_categories = $product->category;
						foreach ($product_categories as $ele){
							$category .= str_replace(' ','-',$ele->name). " ";
							$category_name .= $ele->name. ", ";
						}
						$category_name = substr($category_name,0,strlen($category_name )-2);

					@endphp
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$category}}"  data-product_id="{{$product->product_id}}">
					<!-- Block2 -->
					<div class="block2" style="height=100%">
						<div class="block2-pic hov-img0" >
							@if($product->file_name)
							<img src="{{asset($product->location)}}/{{$product->file_name}}" alt="IMG-PRODUCT">
							@else
							<img src="{{asset('images/thumbnail')}}/default.png" alt="IMG-PRODUCT">
							@endif
							<a href="javascript:void(0);" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" data-product_id="{{$product->product_id}}">
								Quick View
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">


								<span class="stext-105 cl3 ">

                                    @php

                                    $active_featured_product = App\Product::getactivefeatured($product->product_id);
                                    if (sizeof($active_featured_product) == 1){
                                        $featured = true;
                                    }else {
                                        $featured = false;
                                    }
                                    @endphp
                                    @if($featured)

                                        <b class='pname'>{{$product->name}}</b>
                                        <sup style="color:white;background-color:red;border-radius: 10px;">&nbsp;&nbsp;Hot&nbsp;&nbsp;</sup>

                                    @else
                                    <b class='pname'>{{$product->name}}</b>
                                    @endif

								</span>


								<span class="stext-105 cl3 price">
									{{$product->price}}
								</span>

								<span class="stext-105 cl3 category">
									{{$category_name}}
								</span>
								@php
									$is_like = false;

									if($product->like){

										$like = $product->like;
										$number_like = sizeof($like);
										$user_id = optional(auth()->user())->id;
										foreach($like as $ele){
											if($user_id && $user_id == $ele->user_id){
												$is_like = true;
												break;
											}
										}
									}
								@endphp

								

							</div>

 							<div class="block2-txt-child2 flex-r p-t-3">

							 
								<span class="number-like">{{$number_like}}</span>
								

								@if($is_like)
								<a href="javascript:void(0);" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2 js-addedwish-b2" data-product_id="{{$product->product_id}}">
									
									<img class="icon-heart1 dis-block trans-04" src="{{asset('cozastore')}}/images/icons/icon-heart-01.png" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('cozastore')}}/images/icons/icon-heart-02.png" alt="ICON">

									
								</a>
								@else
								<a href="javascript:void(0);" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" data-product_id="{{$product->product_id}}">
									
									<img class="icon-heart1 dis-block trans-04" src="{{asset('cozastore')}}/images/icons/icon-heart-01.png" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('cozastore')}}/images/icons/icon-heart-02.png" alt="ICON">
									
								</a>
								@endif

							</div>
 						</div>
					</div>
				</div>

				@endforeach



			</div>


			<!-- Load more -->
			@php $num_product = sizeof($products);@endphp
			<div class="alert alert-info">
				<p class='loaded-report font-weight-bold text-xl-left'>{{$num_product}} out of {{$totalSize}} products loaded.</p>
			</div>

			<div class="flex-c-m flex-w w-full p-t-45">
			
				<input id="offset" value="{{$num_product}}" type='hidden'>
				<input id="totalSize" value="{{$totalSize}}" type='hidden'>
				
				<a href="javascript:void(0);" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadmore">
					Load More
				</a>
				
			</div>

		</div>
	</section>


@endsection
