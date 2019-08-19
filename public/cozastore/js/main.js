
(function ($) {
    "use strict";

    /*[ Load page ]
    ===========================================================*/
    $(".animsition").animsition({
        inClass: 'fade-in',
        outClass: 'fade-out',
        inDuration: 1500,
        outDuration: 800,
        linkElement: '.animsition-link',
        loading: true,
        loadingParentElement: 'html',
        loadingClass: 'animsition-loading-1',
        loadingInner: '<div class="loader05"></div>',
        timeout: false,
        timeoutCountdown: 5000,
        onLoadEvent: true,
        browser: [ 'animation-duration', '-webkit-animation-duration'],
        overlay : false,
        overlayClass : 'animsition-overlay-slide',
        overlayParentElement : 'html',
        transition: function(url){ window.location.href = url; }
    });

    /*[ Back to top ]
    ===========================================================*/
    var windowH = $(window).height()/2;

    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css('display','flex');
        } else {
            $("#myBtn").css('display','none');
        }
    });

    $('#myBtn').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 300);
    });


    /*==================================================================
    [ Fixed Header ]*/
    var headerDesktop = $('.container-menu-desktop');
    var wrapMenu = $('.wrap-menu-desktop');

    if($('.top-bar').length > 0) {
        var posWrapHeader = $('.top-bar').height();
    }
    else {
        var posWrapHeader = 0;
    }


    if($(window).scrollTop() > posWrapHeader) {
        $(headerDesktop).addClass('fix-menu-desktop');
        $(wrapMenu).css('top',0);
    }
    else {
        $(headerDesktop).removeClass('fix-menu-desktop');
        $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
    }

    $(window).on('scroll',function(){
        if($(this).scrollTop() > posWrapHeader) {
            $(headerDesktop).addClass('fix-menu-desktop');
            $(wrapMenu).css('top',0);
        }
        else {
            $(headerDesktop).removeClass('fix-menu-desktop');
            $(wrapMenu).css('top',posWrapHeader - $(this).scrollTop());
        }
    });


    /*==================================================================
    [ Menu mobile ]*/
    $('.btn-show-menu-mobile').on('click', function(){
        $(this).toggleClass('is-active');
        $('.menu-mobile').slideToggle();
    });

    var arrowMainMenu = $('.arrow-main-menu-m');

    for(var i=0; i<arrowMainMenu.length; i++){
        $(arrowMainMenu[i]).on('click', function(){
            $(this).parent().find('.sub-menu-m').slideToggle();
            $(this).toggleClass('turn-arrow-main-menu-m');
        })
    }

    $(window).resize(function(){
        if($(window).width() >= 992){
            if($('.menu-mobile').css('display') == 'block') {
                $('.menu-mobile').css('display','none');
                $('.btn-show-menu-mobile').toggleClass('is-active');
            }

            $('.sub-menu-m').each(function(){
                if($(this).css('display') == 'block') { console.log('hello');
                    $(this).css('display','none');
                    $(arrowMainMenu).removeClass('turn-arrow-main-menu-m');
                }
            });

        }
    });


    /*==================================================================
    [ Show / hide modal search ]*/
    $('.js-show-modal-search').on('click', function(){
        $('.modal-search-header').addClass('show-modal-search');
        $(this).css('opacity','0');
    });

    $('.js-hide-modal-search').on('click', function(){
        $('.modal-search-header').removeClass('show-modal-search');
        $('.js-show-modal-search').css('opacity','1');
    });

    $('.container-search-header').on('click', function(e){
        e.stopPropagation();
    });


    /*==================================================================
    [ Isotope ] */
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    /*$filter.each(function () {
        $filter.on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({filter: filterValue});
        });

    });
*/

    /////////////////////edited by vanna
    $filter.each(function () {
        $filter.on('click', 'button', function () {
            //var filterValue = $(this).attr('data-filter');

            $topeContainer.isotope({
                filter: function(){
                    var price = Number($(this).find('.price').text());
                    var filter_by = $('.filter-price').val();
                    var active_category = $('.how-active1').data('filter').substring(1);
                   // alert('imaher');

                    //$('.testoutput').append('<p>'+active_director+'</p>'+'<p>'+filter_by+'</p>');



                    if (isNaN(filter_by)){
                        if (filter_by  == 'all'){
                            if ( active_category === '')
                                return true;
                            else
                                return $(this).hasClass(active_category);
                        }else{
                            if ( active_category === '')
                                return (price >= 200 );
                            else
                                return (price >= 200 ) && $(this).hasClass(active_category);
                        }

                    }else{
                        filter_by = Number(filter_by);

                        if (price >= (filter_by - 50) &&  price <= filter_by){

                            if ( active_category === '')
                                return true;
                            else
                                return $(this).hasClass(active_category);
                        }
                        else
                            return false;
                    }
                }
            });
        });

    })

    // init Isotope
    $(window).on('load', function () {
        var $grid = $topeContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine : 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function(){
        $(this).on('click', function(){
            for(var i=0; i<isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });

    /*==================================================================
    [ Filter / Search product ]*/
    $('.js-show-filter').on('click',function(){
        $(this).toggleClass('show-filter');
        $('.panel-filter').slideToggle(400);

        if($('.js-show-search').hasClass('show-search')) {
            $('.js-show-search').removeClass('show-search');
            $('.panel-search').slideUp(400);
        }
    });

    $('.js-show-search').on('click',function(){
        $(this).toggleClass('show-search');
        $('.panel-search').slideToggle(400);

        if($('.js-show-filter').hasClass('show-filter')) {
            $('.js-show-filter').removeClass('show-filter');
            $('.panel-filter').slideUp(400);
        }
    });




    /*==================================================================
    [ Cart ]*/
    $('.js-show-cart').on('click',function(){
        $('.js-panel-cart').addClass('show-header-cart');
    });

    $('.js-hide-cart').on('click',function(){
        $('.js-panel-cart').removeClass('show-header-cart');
    });

    /*==================================================================
    [ Cart ]*/
    $('.js-show-sidebar').on('click',function(){
        $('.js-sidebar').addClass('show-sidebar');
    });

    $('.js-hide-sidebar').on('click',function(){
        $('.js-sidebar').removeClass('show-sidebar');
    });

    /*==================================================================
    [ +/- num product ]*/
    $('.btn-num-product-down').on('click', function(){
        var numProduct = Number($(this).next().val());
        if(numProduct > 0) $(this).next().val(numProduct - 1);
    });

    $('.btn-num-product-up').on('click', function(){
        var numProduct = Number($(this).prev().val());
        $(this).prev().val(numProduct + 1);
    });

    /*==================================================================
    [ Rating ]*/
    $('.wrap-rating').each(function(){
        var item = $(this).find('.item-rating');
        var rated = -1;
        var input = $(this).find('input');
        $(input).val(0);

        $(item).on('mouseenter', function(){
            var index = item.index(this);
            var i = 0;
            for(i=0; i<=index; i++) {
                $(item[i]).removeClass('zmdi-star-outline');
                $(item[i]).addClass('zmdi-star');
            }

            for(var j=i; j<item.length; j++) {
                $(item[j]).addClass('zmdi-star-outline');
                $(item[j]).removeClass('zmdi-star');
            }
        });

        $(item).on('click', function(){
            var index = item.index(this);
            rated = index;
            $(input).val(index+1);
        });

        $(this).on('mouseleave', function(){
            var i = 0;
            for(i=0; i<=rated; i++) {
                $(item[i]).removeClass('zmdi-star-outline');
                $(item[i]).addClass('zmdi-star');
            }

            for(var j=i; j<item.length; j++) {
                $(item[j]).addClass('zmdi-star-outline');
                $(item[j]).removeClass('zmdi-star');
            }
        });
    });

    /*==================================================================
    [ Show modal1 ]*/
/*
    $('.js-show-modal1').on('click',function(e){
        e.preventDefault();
        $('.js-modal1').addClass('show-modal1');
    });

    $('.js-hide-modal1').on('click',function(){
        $('.js-modal1').removeClass('show-modal1');
    });

*/

    //added by vanna
    // Quick View
    $(document).off('click', '.js-show-modal1');
    $(document).on('click', '.js-show-modal1',function(e){
        $('.js-modal1').addClass('show-modal1');
        $.ajax({
            type:"GET",
            url:"admin/product/getproductdetail",
            data:{ product_id:$(this).data('product_id')  }   ,
            success: function (data) {
                //console.log(data);
                if(data[0] == 1){
                    var gl_container = $('.gallery-lb');
                    var text_container = $('.detail-text');
                    var product = data[1];
                    var location;
                    var html = "";
                    var size;
                    var i;
                    var temp;
                    var category_name;
                    var category;


                    if (product['photo'].length > 0){
                        //alert('hter');
                        size = product['photo'].length;
                        for (i = 0; i< size ; i++){
/*
                            location = movie['photos'][i]['location']+'\\'+movie['photos'][i]['file_name'];
                            html = html + '<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'
                                        +location+'">';
                            html = html + '<i class="fa fa-expand"></i></a>';
*/
                            location = product['photo'][i]['location']+'\\'+product['photo'][i]['file_name'];
                            html = html + '<div class="item-slick3" data-thumb="'+location+'">';
                            html = html + '<div class="wrap-pic-w pos-relative">';
                            html = html + '<img src="'+location+'" alt="IMG-PRODUCT">';
                            html = html + '<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'
                                        +location+'">';
                            html = html + '<i class="fa fa-expand"></i></a></div></div>';

                        }
                        gl_container.prepend(html);
                        html = "";
                    }


                    if (product['thumbnail'] !== null){
                        location = product['thumbnail']['location']+'\\'+product['thumbnail']['file_name'];

                    }else{
                        location = product['thumbnail_id'];
                    }

                    html = '<div class="item-slick3" data-thumb="'+location+'">';
                    html = html + '<div class="wrap-pic-w pos-relative">';
                    html = html + '<img src="'+location+'" alt="IMG-PRODUCT">';
                    html = html + '<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'
                                +location+'">';
                    html = html + '<i class="fa fa-expand"></i></a></div></div>';

/*                    html = html + '<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="'
                                +location+'">';
                    html = html + '<i class="fa fa-expand"></i></a>';
*/
                    gl_container.prepend(html);
                    html = "";

                    category_name = "";
                    category = product['category'];
                    //alert(category);
                    for (i = 0 ; i < category.length; i++){

                        category_name = category_name + category[i].name +  ", ";
                    }
                    category_name = category_name.substring(0, category_name.length - 2);


                    html = '<h4 class="mtext-105 cl2 js-name-detail p-b-14">'+product.name+'</h4>';
                    html = html + '<span class="mtext-106 cl2">'+product.price+'</span>';
                    html = html + '<p class="stext-102 cl3 p-t-23">'+product.description+'</p>';
                    html = html + '<p class="stext-102 cl3 p-t-23"><b>Category:</b> <a href="javascript:void(0);">'
                            +category_name+'</a></p>';
                    html = html
                            +'<p class="stext-102 cl3 p-t-23">'
                             +   '<b>Name:</b>'
                            +seller.name
                            +'</p>'


                            +'<p class="stext-102 cl3 p-t-23">'
                             +   '<b>Address:</b>'
                            +seller.address
                            +'</p>'

                            +'<p class="stext-102 cl3 p-t-23">'
                             +   '<b>Email:</b><a href="#">'
                            +seller.email</a>
                            +'</p>'
                            +'<p class="stext-102 cl3 p-t-23">'
                             +   '<b>Phone:</b>'
                            +seller.phone
                            +'</p>'

                            +'<p class="stext-102 cl3 p-t-23">'
                             +   '<b>Message_Account:</b>'
                            +seller.message_account
                            +'</p>'

                           + '<p class="stext-102 cl3 p-t-23">'
                            +    '<b>Type:</b>'
                            +seller.type
                            +'</p>';

                    text_container.prepend(html);
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

                }
            },
            error: function(data){
                console.log(data);
            }

        });

    });

    $(document).off('click','.js-hide-modal1');
    $(document).on('click','.js-hide-modal1',function(){
        $('.js-modal1').removeClass('show-modal1');
        $('.gallery-lb').slick('unslick');
        $('.gallery-lb').empty();
        $('.detail-text').empty();

    });

    //end quick view
    //added by vanna

    /*===================================================================[ Load more ]*/


    $(document).off('click','#loadmore');
    $(document).on('click', '#loadmore', function(){

        var offset = parseInt($('#offset').val());

        //alert(offset);
        $.ajax({
                    type:"GET",
                    url:"admin/product/getproductmore/",
                    data:{ offset: offset  }   ,
                    success: function (data) {
                        console.log(data);
                        if(data[0] == 1){
                            var i;
                            var items = data[1];
                            var $content;
                            for (i=0; i< items.length; i ++){
                                $content = $(items[i]);
                                $('.isotope-grid').append( $content );
                                $('.isotope-grid').isotope( 'insert', $content );
                            }

                            offset = offset  +items.length;
                            $('#offset').val(offset);
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
            });

    });


    $(document).off('click','#loadmore_shop');
    $(document).on('click', '#loadmore_shop', function(){

        var offset = parseInt($('#offset').val());

        //alert(offset);
        $.ajax({
                    type:"GET",
                    url:"admin/seller/getsellermore/",
                    data:{ offset: offset  }   ,
                    success: function (data) {
                        console.log(data);
                        if(data[0] == 1){
                            var i;
                            var items = data[1];
                            var $content;
                            for (i=0; i< items.length; i ++){
                                $content = $(items[i]);
                                $('.isotope-grid').append( $content );
                                $('.isotope-grid').isotope( 'insert', $content );
                            }

                            offset = offset  +items.length;
                            $('#offset').val(offset);
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
            });

    });
 /*===================================================================[ sort by ]*/

 // for seller

 $(document).off('click','#loadmore');
    $(document).on('click', '#loadmore', function(){

        var offset = parseInt($('#offset').val());

        //alert(offset);
        $.ajax({
                    type:"GET",
                    url:"admin/product/getproductmore/",
                    data:{ offset: offset  }   ,
                    success: function (data) {
                        console.log(data);
                        if(data[0] == 1){
                            var i;
                            var items = data[1];
                            var $content;
                            for (i=0; i< items.length; i ++){
                                $content = $(items[i]);
                                $('.isotope-grid').append( $content );
                                $('.isotope-grid').isotope( 'insert', $content );
                            }

                            offset = offset  +items.length;
                            $('#offset').val(offset);
                        }
                    },
                    error: function(data){
                        console.log(data);
                    }
            });

    });

    // ------------------------------------------------------------------

    $topeContainer.isotope({
        getSortData: {
            product_id: '[data-product_id] parseInt',
            name: '.pname',
            price:function( itemElem ) { // function
                var price = $(itemElem).find('.price').text();
                return parseFloat(price);
            }
        },
    });

    $(document).off('click','.sort-by');
    $(document).on('click','.sort-by', function(){
        var sort_by = $(this).data('sort');
        var old_sort_by = $('.filter-link-active.sort-by');
        old_sort_by.removeClass('filter-link-active');
        $(this).addClass('filter-link-active');

        if(sort_by == 'default'){
            $topeContainer.isotope({
                sortBy: ''
            });
        }else if(sort_by == 'name'){
            $topeContainer.isotope({
                sortBy: 'pname'
            });
        }else if(sort_by == 'newness'){
            $topeContainer.isotope({
                sortBy: 'product_id',
                sortAscending: false
            });
        }else if (sort_by == 'hightolow'){
            $topeContainer.isotope({
                sortBy: 'price',
                sortAscending: true
            });
        }else if (sort_by == 'lowtohigh'){
            $topeContainer.isotope({
                sortBy: 'price',
                sortAscending: false
            });
        }
    });

/*===================================================================[ filter by ]*/
    $(document).off('click','.filter-by');
    $(document).on('click','.filter-by', function(){

       
        var old_active = $('.filter-link-active.filter-by');


        $(this).addClass('filter-link-active');
        old_active.removeClass('filter-link-active');

        $('.filter-price').val($(this).data('filter'));



        $topeContainer.isotope({

          filter: function() {
              var price = Number($(this).find('.price').text());
              var filter_by = $('.filter-price').val();
              var active_category = $('.how-active1').data('filter').substring(1);
              // alert('imaher');

              //$('.testoutput').append('<p>'+active_director+'</p>'+'<p>'+filter_by+'</p>');



              if (isNaN(filter_by)){
                  if (filter_by  == 'all'){
                      if ( active_category === '')
                          return true;
                      else
                          return $(this).hasClass(active_category);
                  }else{
                      if ( active_category === '')
                          return (price >= 200 );
                      else
                          return (price >= 200 ) && $(this).hasClass(active_category);
                  }

              }else{
                  filter_by = Number(filter_by);

                  if (price >= (filter_by - 50) &&  price <= filter_by){

                      if ( active_category === '')
                          return true;
                      else
                          return $(this).hasClass(active_category);
                  }
                  else
                      return false;
              }
          }
        });


    })



})(jQuery);
