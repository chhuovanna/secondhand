@extends('backend.layouts.app')

@section('title', 'Add movie')

@section('content')
{{ html()->form('POST', route('movie.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Movie Managment
                        <small class="text-muted">Add Movie</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('MID')
                            ->class('col-md-1 form-control-label')
                            ->for('mid') }}

                        <div class="col-md-3">
                            {{ html()->input('number','mid')
                                ->class('form-control')
                                ->placeholder('mid')
                                ->attribute('min', 1)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Title')
                            ->class('col-md-1 form-control-label')
                            ->for('title') }}

                        <div class="col-md-3">
                            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder('title')
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Released Year')
                            ->class('col-md-1 form-control-label')
                            ->for('year') }}

                        <div class="col-md-3">
                            {{ html()->input('number','year')
                                ->class('form-control')
                                ->placeholder('realeased year')
                                ->attributes(['min'=> 1, 'max' => 9999])
                                 }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Director')
                            ->class('col-md-1 form-control-label')
                            ->for('director') }}

                        <div class="col-md-3">
                            {{ html()->text('director')
                                ->class('form-control')
                                ->placeholder('director') }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('movie.index'), 'Cancel') }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit('Submit') }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->form()->close() }}
@endsection

