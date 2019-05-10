@extends('backend.layouts.app')

@section('title', 'Show Rate')

@section('content')

    <form  method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Category Management
                            <small class="text-muted">Show Rate</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label('category_ID')
                                ->class('col-md-1 form-control-label')
                                ->for('category_id') }}

                            <div class="col-md-3">
                                <select name="id" id="id" class="form-control" >
                                    @foreach ($categorys as $category) {
                                    <option value='{{ $category->ID }}'>{{ $category->name}}</option>"
                                    @endforeach

                                </select>
                            </div><!--col-->
                        </div><!--form-group-->
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">

                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>

        {{ html()->form()->close() }}
        @endsection

        @push('after-scripts')

            <script>

                $('#category_id').off('change');
                $('#category_id').on('change', function(){
                    //alert('change');
                    $.ajax({
                        type:"GET",
                        url:"getseller",
                        data:{id: parseInt($('#category_id').val())},
                        success: function (data) {
                            console.log(data);
                            $('#result').html(data);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });
            </script>

        @endpush