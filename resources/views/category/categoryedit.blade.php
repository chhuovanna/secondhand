@extends('backend.layouts.app')

@section('title', 'Edit Category')

@section('content')
    {{ html()->form('PUT', route('category.update',['id'=>$category->category_id]))->class('form-horizontal')->acceptsFiles()->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Category Management
                        <small class="text-muted">Edit category</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>
            @include('backend.layouts.categorypartialform')


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
    </div>>
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

    <script>
        $(document).ready(function(){
            $(document).off('change','#image_id');
            $(document).on('change','#image_id', function(){
                $('.old-image').remove();
            });

        });
    </script>

@endpush
