@extends('backend.layouts.app')

@section('title', 'Add Product')

@section('content')
    {{ html()->form('POST', route('product.store'))->class('form-horizontal')->acceptsFiles()->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Product Management
                        <small class="text-muted">Add product</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>
            @include('backend.layouts.productpartialform')


            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('product.index'), 'Cancel') }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit('Submit') }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    </div>

    {{ html()->form()->close() }}

{{ html()->form()->close() }}

@endsection

@push('after-scripts')


<script>
    $('[name="category_id[]"]').select2({width:'100%'});
</script>

@endpush
