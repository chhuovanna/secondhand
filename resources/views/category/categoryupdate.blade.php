@extends('backend.layouts.app')

@section('title', 'Update category')

@section('content')
    {{ html()->form('PUT', route('category',['id'=>$category->ID]))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Category Management
                        <small class="text-muted">Update Category</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>
            @include('backend.layouts.categorypartialform')
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('category.index'), 'Cancel') }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Submit') }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

    <script>

    </script>

@endpush
