@extends('backend.layouts.app')

@section('title', 'Edit Seller')

@section('content')
    {{ html()->form('PUT', route('seller.update',['id'=>$seller->seller_id]))->class('form-horizontal')->acceptsFiles()->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Seller Management
                        <small class="text-muted">Edit seller</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>
            @include('backend.layouts.sellerpartialform')


        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('seller.index'), 'Cancel') }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Submit') }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    </div>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

    <script>

    </script>

@endpush
