@extends('backend.layouts.app')

@section('title', 'Show Rate')

@section('content')

    <  method="post">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Seller Management
                            <small class="text-muted">Show Rate</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label('seller_ID')
                                ->class('col-md-1 form-control-label')
                                ->for('seller_id') }}

                            <div class="col-md-3">
                                <select name="id" id="id" class="form-control" >
                                    @foreach ($sellers as $seller) {
                                    <option value='{{ $seller->ID }}'>{{ $seller->name}}</option>"
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

                $('#seller_id').off('change');
                $('#seller_id').on('change', function(){
                    //alert('change');
                    $.ajax({
                        type:"GET",
                        url:"getcategory",
                        data:{id: parseInt($('#seller_id').val())},
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