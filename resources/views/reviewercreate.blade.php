@extends('backend.layouts.app')

@section('title', 'Add reviewer')

@section('content')
{{ html()->form('POST', route('reviewer.store'))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Reviewer Managment
                        <small class="text-muted">Add reviewer</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('RID')
                            ->class('col-md-1 form-control-label')
                            ->for('rid') }}

                        <div class="col-md-3">
                            {{ html()->input('number','rid')
                                ->class('form-control')
                                ->placeholder('rid')
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
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('reviewer.index'), 'Cancel') }}
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
