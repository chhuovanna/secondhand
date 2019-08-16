@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">

            <div class="card">

                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                
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
                                return 'New';
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
    </script>

@endpush
@push('after-styles')
    <style type="text/css">
        .lg-backdrop.in {
            opacity: 0.5 !important;
        }
    </style>
@endpush
