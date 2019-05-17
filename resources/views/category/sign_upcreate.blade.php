@extends('backend.layouts.app')

@section('title', 'Add Sign_up')

@section('content')


    <form action="{{ url('admin\sign_up\store')}}" method="post">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Sign_up Management
                            <small class="text-muted">Add sign_up</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4">
                    <div class="col">
                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="mid" >Seller:</label>

                            <div class="col-md-3">
                                <select name="seller_id" class="form-control">
                                    @foreach ($sellers as $seller) {
                                    <option value='{{ $seller->seller_id }}'>{{ $seller->title}}</option>"
                                    @endforeach
                                </select>
                            </div><!--col-->
                        </div><!--form-group-->


                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="sign_up_id" >View:</label>

                            <div class="col-md-3">
                                <select name="sign_up_id" class="form-control">
                                    @foreach ($views as $view)
                                        <option value='{{$view->sign_up_id}}'>{{$view->name }}</option>
                                    @endforeach
                                </select>

                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            <label class="col-md-1 form-control-label" for="stars" >Stars:</label>

                            <div class="col-md-3">
                                <input class="form-control" type="number" min='1' max='5' name="stars" required>

                            </div><!--col-->
                        </div><!--for-->

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('sign_up.index'), 'Cancel') }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit('Submit') }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
        {{ html()->form()->close() }}
    </form>
@endsection