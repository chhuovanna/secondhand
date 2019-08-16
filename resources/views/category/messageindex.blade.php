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
                    <table id="message" class="table table-hover table-condensed" style="width:100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Full Name</th>

                            <th>Email</th>

                            <th>Phone</th>

                            <th>Message</th>
                            <th>Status</th>
                            <th>Created_at</th>
                            <th>Update_at</th>
                            
                             <th>Action</th>
                            <!-- <th>Updated At</th> -->


                            
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

            oTable = $('#message').DataTable({

                "processing": true,

                "serverSide": true,

                "ajax": "{{ route('message.getmessage') }}",

                "columns": [
                    {data: 'message_id', name: 'message_id'},

                   

                    {data: 'full_name', name: 'full_name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'message', name: 'message'
                       /* render:function ( data, type, row, meta ) {
                            return type === 'display' && data && data.length > 20 ? '<span title="'+data+'">'+data.substr( 0, 20 )+'...</span>' : data;
                        }*/
                    },
                    
                    // {data: 'created_at', name: 'created_at'},
                    // {data: 'updated_at', name: 'updated_at'},
                    {data: 'status', name: 'status',
                        render:function ( data, type, row, meta ) {
                            if (data == 0){
                                return '<b>Unread</b><span class="badge badge-pill badge-danger"><b>New<b></span>';
                            }else{
                                return "Read";
                            }
                        }},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data:'action', name: 'action', orderable: false, searchable: false},


                ]
                ,
                "order":[[0,'desc']]
            });
 });

// // add by hoa
//         $(document).off('click','.list-message');
//         $(document).on('click','.list-message' , function(){
//             var confirm_delete = confirm("Do you really want to delete this product?");
//             if (confirm_delete == true) {
//                 $.ajax({
//                     type:"READ",
//                     url:"message/"+$(this).data('id'),
//                     data:{ _token: $('meta[name="csrf-token"]').attr('content'), message: $(this).data('id')},
//                     success: function (data) {
                        
//                     },
//                     error: function(data){
//                         $('.col').prepend('<div class="alert alert-warning alert-dismissible fade show fail-msg" role="alert" >Fail to delete. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
//                         console.log(data);
//                     }
                
            

    </script>

@endpush
@push('after-styles')
    <style type="text/css">
        .lg-backdrop.in {
            opacity: 0.5 !important;
        }
    </style>
@endpush
