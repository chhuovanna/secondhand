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
                    <table id="movie" class="table table-hover table-condensed" style="width:100%">

                        <thead>

                            <tr>

                                <th>Id</th>

                                <th>Title</th>

                                <th>director</th>

                                <th>year</th>

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

    oTable = $('#movie').DataTable({

        "processing": true,

        "serverSide": true,

        "ajax": "{{ route('datatable.getposts') }}",

        "columns": [

            {data: 'mID', name: 'mID'},

            {data: 'title', name: 'title'},

            {data: 'director', name: 'director'},

            {data: 'year', name: 'year'}

        ]

    });

});
</script>

@endpush

