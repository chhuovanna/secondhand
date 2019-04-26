@extends('backend.layouts.app')

@section('title', 'Rate movie')

@section('content')



<form action="{{ url('admin\movie\saverating')}}" method="post">
    @csrf
<div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        Movie Managment
                        <small class="text-muted">Rate Movie</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label('Movie')
                            ->class('col-md-1 form-control-label')
                            ->for('mid') }}

                        <div class="col-md-3">
                             <select name="mid" class="form-control" >
                                @foreach ($movies as $movie) {
                                    <option value='{{ $movie->mID }}'>{{ $movie->title}}</option>"
                                @endforeach
                                
                            </select>
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Reviewer')
                            ->class('col-md-1 form-control-label')
                            ->for('rid') }}

                        <div class="col-md-3">
                            <select name="rid" class="form-control" >
                                    @foreach ($reviewers as $reviewer) 
                                        <option value='{{$reviewer->rID}}'>{{$reviewer->name }}</option>
                                    @endforeach    
                            </select>
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row">
                        {{ html()->label('Stars')
                            ->class('col-md-1 form-control-label')
                            ->for('stars') }}

                        <div class="col-md-3">
                            {{ html()->input('number','stars')
                                ->class('form-control')
                                ->placeholder('stars')
                                ->attributes(['min'=> 1, 'max' => 5])
                                ->required()
                                 }}
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

