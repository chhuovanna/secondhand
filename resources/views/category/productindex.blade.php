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

                            <th>Name</th>

                            <th>Description</th>

                            <th>View_number</th>

                            <th>Status</th>
                            <th>Pickup_address</th>
                            <th>Pickup_time</th>
                            <th>Created_at</th>
                            <th>Update_at</th>
                            <th>Post_id</th>
                            <th>Image_id</th>
                            <th>Action</th>

                        </tr>

                        </thead>

                    </table>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
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


                    {data: 'name', name: 'name'},

                    {data: 'price', name: 'price'},

                    {data: 'description', name: 'description',

                        render:function ( data, type, row, meta ) {
                            return type === 'display' && data && data.length > 20 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        }
                    },
                    {data: 'view_number', name: 'view_number'},
                    {data: 'status', name: 'status'},
                    {data: 'pickup_address', name: 'pickup_address'},
                    {data: 'pickup_time', name: 'pickup_time'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'post_id', name: 'post_id'},
                    {data: 'image_id', name: 'image'},
                    {data:'action', name: 'action', orderable: false, searchable: false}

                ]

            });



            $(document).off('click','.product-delete');
            $(document).on('click','.product-delete' , function(){

                var confirm_delete = confirm("Do you really want to delete this category?");
                if (confirm_delete == true) {
                    $.ajax({
                        type:"DELETE",
                        url:"category/"+$(this).data('id'),
                        data:{ _token: $('meta[name="csrf-token"]').attr('content'), ID: $(this).data('id')},
                        success: function (data) {
                            if(data == 1){
                                $('.col').prepend('</div><div class="alert alert-success alert-dismissible fade show success-msg" role="alert" >Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                oTable.ajax.reload(null, false);
                            }else{
                                $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to delete<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                console.log(data);
                            }

                        },
                        error: function(data){
                            $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to delete<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            console.log(data);
                        }
                    });
                }

            });
        });
    </script>

@endpush




