@extends('backend.layouts.app')

@section('title', 'Add seller')

@section('content')
    {{ html()->form('POST', route('seller.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Seller Management
                        <small class="text-muted">Add Seller</small>
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
                            {{ html()->input('number','seller_id')
                                ->class('form-control')
                                ->placeholder('seller_id')
                                ->attribute('min', 1)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Name')
                            ->class('col-md-1 form-control-label')
                            ->for('name') }}

                        <div class="col-md-3">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder('name')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Address')
                            ->class('col-md-1 form-control-label')
                            ->for('address') }}

                        <div class="col-md-3">
                            {{ html()->text('address')
                                ->class('form-control')
                                ->placeholder('address') }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Email')
                            ->class('col-md-1 form-control-label')
                            ->for('email') }}

                        <div class="col-md-3">
                            {{ html()->text('email')
                                ->class('form-control')
                                ->placeholder('email')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Phone')
                            ->class('col-md-1 form-control-label')
                            ->for('phone') }}

                        <div class="col-md-3">
                            {{ html()->text('phone')
                                ->class('form-control')
                                ->placeholder('phone')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Instant_massage_account')
                            ->class('col-md-1 form-control-label')
                            ->for('instant_massage_account') }}

                        <div class="col-md-3">
                            {{ html()->text('instant_massage_account')
                                ->class('form-control')
                                ->placeholder('instant_massage_account')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Type')
                            ->class('col-md-1 form-control-label')
                            ->for('type') }}

                        <div class="col-md-3">
                            {{ html()->text('type')
                                ->class('form-control')
                                ->placeholder('type')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Created_at')
                            ->class('col-md-1 form-control-label')
                            ->for('created_at') }}

                        <div class="col-md-3">
                            {{ html()->text('created_at')
                                ->class('form-control')
                                ->placeholder('created_at')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Updated_at')
                            ->class('col-md-1 form-control-label')
                            ->for('updated_at') }}

                        <div class="col-md-3">
                            {{ html()->text('updated_at')
                                ->class('form-control')
                                ->placeholder('updated_at')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Image_id')
                            ->class('col-md-1 form-control-label')
                            ->for('updated_at') }}

                        <div class="col-md-3">
                            {{ html()->text('image_id')
                                ->class('form-control')
                                ->placeholder('image_id')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

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
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')

    <script>

    </script>

@endpush
