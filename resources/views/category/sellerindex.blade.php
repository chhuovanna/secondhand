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
                    <div style="padding:10px"><a href="{!!route('seller.create')!!}"><button type="button" class="btn btn-success btn-sm pull-right">Add Seller</button></a></div>

                    <table id="seller" class="table table-hover table-condensed" style="width:100%">

                        <thead>

                        <tr>

                            <th>Id</th>

                            <th>Name</th>

                            <th>Address</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>massage_account</th>

                            <th>Type</th>

                            <th>Created_at</th>

                            <th>Updated_at</th>

                            <th>Image</th>

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

            oTable = $('#seller').DataTable({

                "processing": true,

                "serverSide": true,

                "ajax": "{{ route('seller.getseller') }}",

                "columns": [

                    {data: 'seller_id', name: 'seller_id'},

                    {data: 'name', name: 'name'},

                    {data: 'address', name: 'address',
                        render:function ( data, type, row, meta ) {
                            return type === 'display' && data && data.length > 20 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        }
                    },
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'instant_massage_account', name: 'instant_massage_account'},
                    {data: 'type', name: 'type'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'file_name', name: 'image',orderable: false, searchable: false,
                        render:function ( data, type, row, meta ) {
                            var source = "{{ asset('images/') }}"+"/"+data;
                            return '<img src="'+source+'" height="42" width="42">';
                        }
                    },
                    {data:'action', name: 'action', orderable: false, searchable: false}

                ]

            });



            $(document).off('click','.seller-delete');
            $(document).on('click','.seller-delete' , function(){

                var confirm_delete = confirm("Do you really want to delete this category?");
                if (confirm_delete == true) {
                    $.ajax({
                        type:"DELETE",
                        url:"seller/"+$(this).data('id'),
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

