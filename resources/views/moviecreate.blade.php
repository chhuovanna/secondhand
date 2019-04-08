@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <form action="{{url('admin\movie')}}" method="post">
                        
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">mid:</label>
                            <input type="number" name="mid" min=1 required>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">title:</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">year:</label>
                            <input type="number" min='1' max='9999' name="year">
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">director:</label>
                            <input type="text" name="director">
                        </div>
                        <input class="btn btn-primary" type="submit" value="Submit">
                    </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
