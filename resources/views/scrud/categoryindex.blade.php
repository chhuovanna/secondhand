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
                    <div style="padding:10px"><a href="{!!route('category.create')!!}"><button type="button" class="btn btn-success btn-sm pull-right">Add Category</button></a></div>

                    <table id="category" class="table table-hover table-condensed" style="width:100%">

                        <thead>

                        <tr>

                            <th>Id</th>

                            <th>Image</th>

                            <th>Name</th>

                            <th>Description</th>

                            {{--<th>Created_at</th>--}}

                            {{--<th>Updated_at</th>--}}

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

            oTable = $('#category').DataTable({

                "processing": true,

                "serverSide": true,

                "ajax": "{{ route('category.getcategory') }}",

                "columns": [

                    {data: 'category_id', name: 'category_id'},

                    {data: 'file_name', name: 'image',orderable: false, searchable: false,
                        render:function ( data, type, row, meta ) {
                            if (data){
                                var source = "{{ asset('images/category') }}"+"/"+data;
                                return '<img src="'+source+'" height="42" width="42" class="thumbnail img-thumbnail" data-id="'+row.category_id+'" >';
                            }else{
                                return '<i class="fa fa-film fa-3x" aria-hidden="true"></i>';
                            }
                        }
                    },

                    {data: 'name', name: 'name'},

                    {data: 'description', name: 'description',
                        render:function ( data, type, row, meta ) {
                                return type === 'display' && data && data.length > 20 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data; 
                        }
                    },

                    //{data: 'image_id', name: 'image_id'},
                    // {data: 'created_at', name: 'created_at'},
                    // {data: 'updated_at', name: 'updated_at'},

                    {data:'action', name: 'action', orderable: false, searchable: false}

                ]
                ,
                "order":[[0,'desc']]
            });



            $(document).off('click','.category-delete');
            $(document).on('click','.category-delete' , function(){

                var confirm_delete = confirm("Do you really want to delete this category?");
                if (confirm_delete == true) {
                    $.ajax({
                        type:"DELETE",
                        url:"category/"+$(this).data('id'),
                        data:{ _token: $('meta[name="csrf-token"]').attr('content'), category_id: $(this).data('id')},
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


