@extends('backend.layouts.app')

@section('title', 'Add category')

@section('content')
    {{ html()->form('POST', route('category.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Category Management
                        <small class="text-muted">Add Category</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Add')
                            ->class('col-md-1 form-control-label')
                            ->for('add') }}

                        <div class="col-md-3">
                            {{ html()->input('number','add')
                                ->class('form-control')
                                ->placeholder('add')
                                ->attribute('min', 1)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Update')
                            ->class('col-md-1 form-control-label')
                            ->for('update') }}

                        <div class="col-md-3">
                            {{ html()->text('update')
                                ->class('form-control')
                                ->placeholder('update')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Delete')
                            ->class('col-md-1 form-control-label')
                            ->for('delete') }}

                        <div class="col-md-3">
                            {{ html()->text('delete')
                                ->class('form-control')
                                ->placeholder('delete') }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
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
