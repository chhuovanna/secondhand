@extends('backend.layouts.app')
@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div style="padding:10px"><a href="{!!route('product.create')!!}"><button type="button" class="btn btn-success btn-sm pull-right">Add Product</button></a></div>
                    <table id="product" class="table table-hover table-condensed" style="width:100%">
                        <thead>
                        <tr>

                            <th>Id</th>

                            <th>Image</th>

                            <th>Name</th>

                            <th>Price</th>
                            <th>Description</th>
                            <th>View Number</th>
                            <th>Status</th>

                            <th>Pickup Time</th>
                            <th>Pickup Adress</th>
                            <th>Category</th>
                            <!-- <th>Created At</th>
                            <th>Updated At</th>

-->
                            <th>Action</th>

                        </tr>
                        </thead>
                    </table>




                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
        <div class="modal fade" id="featured_product_modal" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Featured Product Setting</h4>
                    <button type="button" class="close featured-close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <div class='operation'></div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="start_date">Start date</label>
                        <div class="col-md-3">
                            <input type="date" id="start_date" name="start_date" value="" >
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="end_date">End date</label>
                        <div class="col-md-3">
                            <input type="date" id="end_date" name="end_date" value="">
                        </div><!--col-->
                    </div><!--form-group-->
                    <input type="hidden" id="modal_product_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary featured-close"  data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="featured-ok" data-dismiss="modal">Ok</button>

                </div>
            </div>
        </div>
    </div><!--row-->
@endsection
@push('after-scripts')
    <script>
        $(document).ready(function() {
            oTable = $('#product').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('product.getproduct') }}",
                "columns": [
                    {data: 'product_id', name: 'product_id'},
                    {data: 'file_name', name: 'image',orderable: false, searchable: false,
                        render:function ( data, type, row, meta ) {
                            if (data){
                                var source = "{{ asset('images/thumbnail') }}"+"/"+data;
                                return '<img src="'+source+'" height="42" width="42" class="thumbnail img-thumbnail" data-id="'+row.product_id+'" style="cursor:pointer">';
                            }else{
                                return '<i class="fa fa-film fa-3x" aria-hidden="true"></i>';
                            }
                        }
                    },
                    {data:'name',name:'name'},
                    {data:'price',name:'price'},
                    {data: 'description', name: 'description',
                        render:function ( data, type, row ) {
                            return type === 'display' && data && data.length > 50 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        }
                    },
                    {data: 'view_number', name: 'view_number'},
                    {data: 'status', name: 'status',
                        render:function ( data, type, row ) {
                            return type === 'display' && data && data.length > 50 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;

                        }
                    },
                    {data:'pickup_time', name:'pickup_address',
                        render:function ( data, type, row ) {
                            return type === 'display' && data && data.length > 50 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        }

                    },
                    {data:'pickup_address', name:'pickup_address',
                        render:function ( data, type, row ) {
                            return type === 'display' && data && data.length > 50 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        },
                    },
                    {data:'category', name:'category',
                        render:function ( data, type, row) {
                            var text="";
                            data.forEach(function(item){
                                text = text + ""+item.name+", ";
                            });
                            text = text.substring(0, text.length - 2);
                            return  type === 'display' && text && text.length > 50 ? '<span title="'+text+'">'+text.substr( 0, 20 )+'...</span>' : text;
                        },
                        orderable: false,
                        searchable: false
                    },
                    /* {data:'created_at',name:'created_at'},
                    {data:'updated_at',name:'updated_at'},*/
                    {data:'action', name: 'action', orderable: false, searchable: false},

                ],
                "order":[[0,'desc']]
                });
        });


        $(document).off('click','.product-delete');
        $(document).on('click','.product-delete' , function(){
            var confirm_delete = confirm("Do you really want to delete this product?");
            if (confirm_delete == true) {
                $.ajax({
                    type:"DELETE",
                    url:"product/"+$(this).data('id'),
                    data:{ _token: $('meta[name="csrf-token"]').attr('content'), product: $(this).data('id')},
                    success: function (data) {
                        if(data[0] == 1){
                            $('.col').prepend('</div><div class="alert alert-success alert-dismissible fade show success-msg" role="alert" >Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            oTable.ajax.reload(null, false);
                        }else{
                            $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to delete. '+data[1]+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            console.log(data);
                        }

                    },
                    error: function(data){
                        $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to delete. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        console.log(data);
                    }
                });
            }

        });
        $(document).off('click','.thumbnail');
        $(document).on('click','.thumbnail' , function(){
           //  alert( $(this).data('id'));
            $.ajax({
                type:"GET",
                url:"product/getphotos/",
                data:{ product_id: $(this).data('id')},
                success: function (data) {

                    console.log(data);
                    if(data[0] == 1){

                        $('.col').append(data[1]); //insert list of photos for viewing

                        var $lg = $("#lightgallery");

                        //apply the lightgallery to the list of photos
                        $lg.lightGallery({
                            mode: 'lg-slide-circular',
                            mousewheel:true,
                        });

                        //after closing the photo viewer, delete the list of photos
                        $lg.on('onCloseAfter.lg', function (event){
                            $(this).data('lightGallery').destroy(true);
                            $('#lightgallery').remove();
                        });

                        //automatically click on the first photo for viewing
                        $('.start').click();

                    }
                },
                error: function(data){
                    console.log(data);
                }
            });

        });

        $(document).off('click','.product-featured');
        $(document).on('click','.product-featured', function( ){

            $('#modal_product_id').val($(this).data('id'));

            //alert('here');
            $.ajax({
                type:"GET",
                url:"product/getactivefeatured/",
                data:{ product_id: $(this).data('id')},
                success: function (data) {

                    console.log(data);
                    if(data[0] == 1){
                        $('.operation').empty();
                        $('.operation').append('<h5 class="text-info">Update</h5><h6 class="text-info"> Product ID : '+$('#modal_product_id').val()+'</h6>');
                        var mydate = data[1][0];
                        $('#start_date').val(mydate.start_date);
                        $('#end_date').val(mydate.end_date);

                    }else if (data[0]==0){
                        $('.operation').empty();
                        $('.operation').append('<h5 class="text-success">Add</h5><h6 class="text-success"> Product ID : '+$('#modal_product_id').val()+'</h6>');
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();

                        today = yyyy+'-'+mm+'-'+dd;
                        $('#start_date').val(today);
                    }else if(data[0]==2){
                        $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >'+data[1]+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        //e.stopPropagation();
                    }
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

        $(document).off('click','#featured-ok');
        $(document).on('click','#featured-ok', function(){
            //alert(' ima her');
            $.ajax({
                type:"GET",
                url:"product/savefeatured",
                data:{ product_id: $('#modal_product_id').val()
                    , start_date: $('#start_date').val()
                    , end_date:$('#end_date').val()
                },
                success: function (data) {
                    console.log(data);
                    if (data[0] == 1){
                        $('.col').prepend('</div><div class="alert alert-success alert-dismissible fade show success-msg" role="alert" >Featured Product '+data[2]+' Saved<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                    }else if (data[0]==0){
                        $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to save featured product '+data[2]+'. '+data[1]+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else if (data[0] == 2){
                        $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >'+data[1]+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }

                },
                error: function(data){
                    console.log(data);
                }
            });

            $('#start_date').val('');
            $('#end_date').val('');
            $('#modal_product_id').val('');

        });

        $(document).off('click','#featured-close');
        $(document).on('click','#featured-close', function() {

            $('#start_date').val('');
            $('#end_date').val('');
            $('#modal_product_id').val('');
        });

    </script>
@endpush

@push('after-styles')
    <style type="text/css">
        .lg-backdrop.in {
            opacity: 0.5 !important;
        }
    </style>
@endpush

